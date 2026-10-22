<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Sekolah - Admin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
        }

        h1 {
            color: #1d4ed8;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Pengaturan Sekolah</h1>
        <p>Kelola informasi sekolah melalui akun admin.</p>

        @if (session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.pengaturan-sekolah.update') }}"
            method="POST"
        >
            @csrf

            <label>Nama Sekolah</label>
            <input
                type="text"
                name="nama_sekolah"
                value="{{ old('nama_sekolah', $sekolah?->nama_sekolah) }}"
                required
            >

            <label>NPSN</label>
            <input
                type="text"
                name="npsn"
                value="{{ old('npsn', $sekolah?->npsn) }}"
            >

            <label>Alamat Sekolah</label>
            <textarea name="alamat" rows="3">{{ old('alamat', $sekolah?->alamat) }}</textarea>

            <label>Nomor Telepon</label>
            <input
                type="text"
                name="telepon"
                value="{{ old('telepon', $sekolah?->telepon) }}"
            >

            <label>Tahun Ajaran</label>
            <input
                type="text"
                name="tahun_ajaran"
                placeholder="Contoh: 2026/2027"
                value="{{ old('tahun_ajaran', $sekolah?->tahun_ajaran) }}"
            >

            <button type="submit">Simpan Pengaturan</button>
        </form>
    </div>
</body>
</html>