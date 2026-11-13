<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catat Transaksi Baru</h2>
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

            <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block font-medium">Kode Transaksi (Contoh: TRX-001)</label>
                    <input type="text" name="kode_transaksi" value="{{ old('kode_transaksi') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Pilih Anggota</label>
                    <select name="anggota_id" class="w-full border rounded p-2" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggotas as $agt)
                            <option value="{{ $agt->id }}" {{ old('anggota_id') == $agt->id ? 'selected' : '' }}>
                                {{ $agt->kode_anggota }} - {{ $agt->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Jenis Transaksi</label>
                    <select name="jenis" class="w-full border rounded p-2" required>
                        <option value="Simpanan" {{ old('jenis') == 'Simpanan' ? 'selected' : '' }}>Simpanan</option>
                        <option value="Pinjaman" {{ old('jenis') == 'Pinjaman' ? 'selected' : '' }}>Pinjaman</option>
                        <option value="Angsuran" {{ old('jenis') == 'Angsuran' ? 'selected' : '' }}>Angsuran</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Jumlah (Rp)</label>
                    <input type="number" name="jumlah" min="1000" value="{{ old('jumlah') }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Tanggal Transaksi</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="2" class="w-full border rounded p-2">{{ old('keterangan') }}</textarea>
                </div>
                <div style="display: flex; gap: 8px; margin-top: 16px;">
                    <button type="submit" style="background-color: #2563eb; color: #ffffff; padding: 10px 20px; border-radius: 6px; font-weight: bold; cursor: pointer;">Simpan Transaksi</button>
                    <a href="{{ route('transaksi.index') }}" style="background-color: #d1d5db; color: #1f2937; padding: 10px 20px; border-radius: 6px; text-decoration: none;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
