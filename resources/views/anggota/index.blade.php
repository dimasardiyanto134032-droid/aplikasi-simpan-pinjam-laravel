<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Anggota Koperasi</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Daftar Anggota</h3>
                <a href="{{ route('anggota.create') }}" style="background-color: #2563eb; color: #ffffff; padding: 8px 16px; border-radius: 6px; font-weight: 600; text-decoration: none;">+ Tambah Anggota</a>
            </div>

            @if(session('success'))
                <div style="background-color: #dcfce7; color: #166534; padding: 12px; border-radius: 6px; margin-bottom: 16px;">{{ session('success') }}</div>
            @endif

            <table class="w-full border-collapse border border-gray-300 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">Kode</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">NIK</th>
                        <th class="border p-2">Nomor Telepon</th>
                        <th class="border p-2">Alamat</th>
                        <th class="border p-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggotas as $item)
                    <tr>
                        <td class="border p-2 text-center">{{ $item->kode_anggota }}</td>
                        <td class="border p-2">{{ $item->nama }}</td>
                        <td class="border p-2 text-center">{{ $item->nik }}</td>
                        <td class="border p-2 text-center">{{ $item->no_hp }}</td>
                        <td class="border p-2">{{ $item->alamat }}</td>
                        <td class="border p-2 text-center space-x-2">
                            <a href="{{ route('anggota.edit', $item->id) }}" style="color: #d97706; font-weight: 600;">Edit</a>
                            <form action="{{ route('anggota.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus anggota ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; font-weight: 600;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border p-4 text-center text-gray-500">Belum ada data anggota.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
