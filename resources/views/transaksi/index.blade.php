<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Transaksi Simpan Pinjam</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Riwayat Transaksi</h3>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ route('transaksi.cetak') }}" target="_blank" style="background-color: #dc2626; color: #ffffff; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none;">Cetak Laporan PDF</a>
                    <a href="{{ route('transaksi.create') }}" style="background-color: #2563eb; color: #ffffff; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none;">+ Tambah Transaksi</a>
                </div>
            </div>

            @if(session('success'))
                <div style="background-color: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 16px;">{{ session('success') }}</div>
            @endif

            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Kode</th>
                        <th class="border p-2">Tanggal</th>
                        <th class="border p-2">Nama Anggota</th>
                        <th class="border p-2">Jenis</th>
                        <th class="border p-2">Jumlah</th>
                        <th class="border p-2">Petugas</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $item)
                    <tr>
                        <td class="border p-2 text-center">{{ $item->kode_transaksi }}</td>
                        <td class="border p-2 text-center">{{ $item->tanggal }}</td>
                        <td class="border p-2">{{ $item->anggota->nama }}</td>
                        <td class="border p-2 text-center font-semibold">{{ $item->jenis }}</td>
                        <td class="border p-2 text-right">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <td class="border p-2 text-center">{{ $item->user->name }}</td>
                        <td class="border p-2 text-center space-x-2">
                            <a href="{{ route('transaksi.edit', $item->id) }}" style="color: #d97706; font-weight: 600;">Edit</a>
                            <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; font-weight: 600;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="border p-4 text-center text-gray-500">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
