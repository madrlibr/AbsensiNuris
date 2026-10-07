<x-app-layout>
    <x-slot name="header">
        Dashboard Utama
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Total Siswa</div>
            <div class="text-2xl font-bold text-gray-800 mt-1">0</div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Hadir Hari Ini</div>
            <div class="text-2xl font-bold text-green-600 mt-1">0</div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Terlambat</div>
            <div class="text-2xl font-bold text-yellow-600 mt-1">0</div>
        </div>
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <div class="text-sm font-medium text-gray-500">Izin / Sakit / Alpa</div>
            <div class="text-2xl font-bold text-red-600 mt-1">0</div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Selamat Datang di Sistem Absensi SMK</h3>
        <p class="text-gray-600 text-sm">Pilih menu di sebelah kiri untuk mengelola master data, jadwal pelajaran, atau melihat rekapitulasi presensi.</p>
    </div>
</x-app-layout>