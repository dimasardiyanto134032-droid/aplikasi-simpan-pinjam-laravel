<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Anggota Baru</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow">
            @if ($errors->any())
                <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 6px; margin-bottom: 16px;">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('anggota.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium">Kode Anggota (Contoh: AGT-001)</label>
                    <input type="text" name="kode_anggota" value="{{ old('kode_anggota') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">NIK (16 Digit Angka)</label>
                    <input type="text" name="nik" maxlength="16" value="{{ old('nik') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Nomor HP</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Alamat</label>
                    <textarea name="alamat" rows="3" class="w-full border rounded p-2" required>{{ old('alamat') }}</textarea>
                </div>
                <div style="display: flex; gap: 8px; margin-top: 16px;">
                    <button type="submit" style="background-color: #2563eb; color: #ffffff; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer;">Simpan Data</button>
                    <a href="{{ route('anggota.index') }}" style="background-color: #d1d5db; color: #1f2937; padding: 10px 20px; border-radius: 6px; text-decoration: none;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
