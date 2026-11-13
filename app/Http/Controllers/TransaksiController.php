<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FPDF;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['anggota', 'user'])->latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();
        return view('transaksi.create', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'kode_transaksi' => 'required|unique:transaksis',
            'jenis' => 'required|in:Simpanan,Pinjaman,Angsuran',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        Transaksi::create([
            'anggota_id' => $request->anggota_id,
            'user_id' => Auth::id(),
            'kode_transaksi' => $request->kode_transaksi,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    public function edit(Transaksi $transaksi)
    {
        $anggotas = Anggota::orderBy('nama')->get();
        return view('transaksi.edit', compact('transaksi', 'anggotas'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'kode_transaksi' => 'required|unique:transaksis,kode_transaksi,' . $transaksi->id,
            'jenis' => 'required|in:Simpanan,Pinjaman,Angsuran',
            'jumlah' => 'required|numeric|min:1000',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $transaksi->update([
            'anggota_id' => $request->anggota_id,
            'kode_transaksi' => $request->kode_transaksi,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function cetakPdf()
    {
        $transaksis = Transaksi::with(['anggota', 'user'])->orderBy('tanggal', 'asc')->get();

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'LAPORAN TRANSAKSI SIMPAN PINJAM KOPERASI', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Dicetak pada: ' . date('d-m-Y H:i'), 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C', true);
        $pdf->Cell(35, 8, 'Kode Transaksi', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Tanggal', 1, 0, 'C', true);
        $pdf->Cell(55, 8, 'Nama Anggota', 1, 0, 'C', true);
        $pdf->Cell(30, 8, 'Jenis', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Jumlah (Rp)', 1, 0, 'C', true);
        $pdf->Cell(40, 8, 'Petugas', 1, 0, 'C', true);
        $pdf->Cell(37, 8, 'Keterangan', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 9);
        $no = 1;
        foreach ($transaksis as $row) {
            $pdf->Cell(10, 8, $no++, 1, 0, 'C');
            $pdf->Cell(35, 8, $row->kode_transaksi, 1, 0, 'C');
            $pdf->Cell(30, 8, $row->tanggal, 1, 0, 'C');
            $pdf->Cell(55, 8, $row->anggota->nama ?? '-', 1, 0, 'L');
            $pdf->Cell(30, 8, $row->jenis, 1, 0, 'C');
            $pdf->Cell(40, 8, number_format($row->jumlah, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 8, $row->user->name ?? '-', 1, 0, 'L');
            $pdf->Cell(37, 8, $row->keterangan ?? '-', 1, 1, 'L');
        }

        return response($pdf->Output('S'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="laporan-simpan-pinjam.pdf"');
    }
}
