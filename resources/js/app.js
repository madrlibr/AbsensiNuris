

import Alpine from 'alpinejs';
import { Html5Qrcode } from 'html5-qrcode';

window.Alpine = Alpine;

Alpine.start();

/**
 * Pemindai QR kamera untuk halaman absensi gerbang (#qr-scanner).
 * Hasil decode langsung dikirim ke server via fetch (JSON, tanpa reload).
 */
function initQrScanner() {
    const root = document.getElementById('qr-scanner');
    if (!root || typeof Html5Qrcode === 'undefined') return;

    const endpoint = root.dataset.endpoint;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const kameraSelect = document.getElementById('qr-kamera');
    const btnMulai = document.getElementById('qr-mulai');
    const btnStop = document.getElementById('qr-stop');
    const statusEl = document.getElementById('qr-status');
    const hasilEl = document.getElementById('hasil-scan');

    let pemindai = null;
    let jalan = false;
    let sibuk = false;
    let kodeTerakhir = '';
    let waktuTerakhir = 0;

    const setStatus = (teks) => { if (statusEl) statusEl.textContent = teks; };

    const bunyi = (sukses) => {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            osc.frequency.value = sukses ? 880 : 220;
            osc.type = 'sine';
            gain.gain.setValueAtTime(0.15, ctx.currentTime);
            osc.start();
            osc.stop(ctx.currentTime + 0.2);
        } catch (e) { /* abaikan: audio tidak wajib */ }
    };

    const badgeStatus = (status) => {
        const warna = status === 'hadir' ? 'bg-emerald-500' : (status === 'terlambat' ? 'bg-amber-500' : 'bg-slate-500');
        return `<p class="mt-3 inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold capitalize ${warna} text-white">${status}</p>`;
    };

    const tampilHasil = (h) => {
        if (!hasilEl) return;
        hasilEl.innerHTML = `
            <div class="rounded-2xl border p-5 text-center ${h.status === 'alpa' ? 'bg-rose-50 border-rose-200' : 'bg-emerald-50 border-emerald-200'}">
                <p class="text-lg font-bold text-slate-800">${h.nama}</p>
                <p class="text-xs font-medium text-slate-500">${h.nisn} · ${h.kelas}</p>
                ${badgeStatus(h.status)}
                <p class="mt-2 text-xs font-bold text-slate-500 uppercase tracking-wider">Absen ${h.tipe} · ${h.jam}</p>
            </div>`;
    };

    const tampilError = (pesan) => {
        if (!hasilEl) return;
        hasilEl.innerHTML = `
            <div class="rounded-2xl border p-5 text-center bg-rose-50 border-rose-200">
                <p class="text-sm font-bold text-rose-700">${pesan}</p>
            </div>`;
    };

    const updateStatistik = (s) => {
        if (!s) return;
        for (const [kunci, nilai] of Object.entries(s)) {
            const el = document.getElementById(`stat-${kunci.replace('_', '-')}`);
            if (el) el.textContent = nilai;
        }
    };

    async function kirim(kode) {
        const sekarang = Date.now();
        if (kode === kodeTerakhir && sekarang - waktuTerakhir < 4000) return; // abaikan pantulan kode sama
        kodeTerakhir = kode;
        waktuTerakhir = sekarang;
        if (sibuk) return;
        sibuk = true;
        setStatus('Memproses…');

        try {
            const res = await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ kode, metode: 'qr' }),
            });
            const data = await res.json();
            if (data.ok) {
                tampilHasil(data.hasil);
                updateStatistik(data.statistik);
                bunyi(true);
            } else {
                tampilError(data.error || 'Gagal mencatat.');
                bunyi(false);
            }
        } catch (e) {
            tampilError('Jaringan terputus. Coba lagi.');
        } finally {
            setTimeout(() => { sibuk = false; setStatus('Arahkan QR ke kamera…'); }, 1500);
        }
    }

    async function mulai(idKamera) {
        if (jalan) return;
        try {
            pemindai = new Html5Qrcode('qr-reader');
            await pemindai.start(
                idKamera ? { deviceId: { exact: idKamera } } : { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 250, height: 250 } },
                (teks) => kirim(teks),
                () => { /* abaikan frame tanpa QR */ },
            );
            jalan = true;
            setStatus('Arahkan QR ke kamera…');
            btnMulai?.classList.add('hidden');
            btnStop?.classList.remove('hidden');
        } catch (e) {
            setStatus('Kamera tidak dapat dibuka. Pastikan izin kamera diberikan dan situs diakses via HTTPS/localhost.');
            btnMulai?.classList.remove('hidden');
        }
    }

    async function berhenti() {
        if (pemindai && jalan) {
            try { await pemindai.stop(); } catch (e) { /* abaikan */ }
            pemindai.clear();
        }
        jalan = false;
        setStatus('Kamera berhenti.');
        btnStop?.classList.add('hidden');
        btnMulai?.classList.remove('hidden');
    }

    btnMulai?.addEventListener('click', () => mulai(kameraSelect?.value || ''));
    btnStop?.addEventListener('click', berhenti);

    // Isi pilihan kamera lalu nyalakan otomatis (halaman ini memang stasiun scan).
    Html5Qrcode.getCameras().then((perangkat) => {
        if (kameraSelect) {
            kameraSelect.innerHTML = '';
            perangkat.forEach((d, i) => {
                const opt = document.createElement('option');
                opt.value = d.id;
                opt.textContent = d.label || `Kamera ${i + 1}`;
                kameraSelect.appendChild(opt);
            });
            const belakang = perangkat.findIndex((d) => /back|rear|belakang/i.test(d.label));
            kameraSelect.selectedIndex = belakang >= 0 ? belakang : perangkat.length - 1;
        }
        if (perangkat.length > 0) {
            mulai(kameraSelect?.value || '');
        } else {
            setStatus('Tidak ada kamera yang terdeteksi di perangkat ini.');
        }
    }).catch(() => {
        setStatus('Izin kamera ditolak atau perangkat tidak mendukung. Gunakan input manual di bawah.');
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initQrScanner);
} else {
    initQrScanner();
}
