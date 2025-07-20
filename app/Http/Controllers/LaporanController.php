<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JurnalUmum;
use App\Models\JurnalDetail;
use App\Models\Account;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * Laporan Jurnal Umum
     */
    public function jurnalUmum(Request $request)
    {
        $query = JurnalUmum::with(['details.account'])
            ->orderBy('tanggal', 'desc');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $jurnals = $query->get();

        return view('backend.laporan.jurnal_umum', compact('jurnals'));
    }

    /**
     * Buku Besar
     */
    public function bukuBesar(Request $request)
    {
        $tipe = $request->tipe;
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $start = Carbon::parse($startDate);
        $bulan = $start->month;
        $tahun = $start->year;

        $akuns = Account::when($tipe, fn($q) => $q->where('kategori', $tipe))
            ->with([
                'jurnalDetails.jurnal' => fn($q) => $q->whereBetween('tanggal', [$startDate, $endDate]),
                'saldoAwal' => fn($q) => $q->where('bulan', $bulan)->where('tahun', $tahun)
            ])
            ->get();

        return view('backend.laporan.buku_besar_grouped', compact(
            'akuns', 'tipe', 'startDate', 'endDate', 'bulan', 'tahun'
        ));
    }

    public function cetakBukuBesarPdf(Request $request)
    {
        $tipe = $request->tipe;
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $start = Carbon::parse($startDate);
        $bulan = $start->month;
        $tahun = $start->year;

        $akuns = Account::when($tipe, fn($q) => $q->where('kategori', $tipe))
            ->with([
                'jurnalDetails.jurnal' => fn($q) => $q->whereBetween('tanggal', [$startDate, $endDate]),
                'saldoAwal' => fn($q) => $q->where('bulan', $bulan)->where('tahun', $tahun)
            ])
            ->get();

        $pdf = Pdf::loadView('backend.laporan.pdf.buku_besar', compact(
            'akuns', 'tipe', 'startDate', 'endDate', 'bulan', 'tahun'
        ))->setPaper('A4', 'landscape');

        return $pdf->download('laporan_buku_besar.pdf');
    }

    /**
     * Neraca Saldo
     */
    public function neracaSaldo(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $akuns = Account::with(['jurnalDetails' => function ($q) use ($startDate, $endDate) {
            $q->whereHas('jurnal', function ($sub) use ($startDate, $endDate) {
                $sub->whereBetween('tanggal', [$startDate, $endDate]);
            });
        }])->get();

        $data = $akuns->map(function ($akun) {
            $debit = $akun->jurnalDetails->sum('debit');
            $kredit = $akun->jurnalDetails->sum('kredit');
            return [
                'akun' => $akun,
                'debit' => $debit,
                'kredit' => $kredit,
                'saldo' => $debit - $kredit,
            ];
        });

        return view('backend.laporan.neraca_saldo', compact('data', 'startDate', 'endDate'));
    }

    public function cetakNeracaSaldoPdf(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        $akuns = Account::with(['jurnalDetails' => function ($query) use ($startDate, $endDate) {
            $query->whereHas('jurnal', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal', [$startDate, $endDate]);
            });
        }])->get();

        $data = $akuns->map(function ($akun) {
            $debit = $akun->jurnalDetails->sum('debit');
            $kredit = $akun->jurnalDetails->sum('kredit');
            return [
                'akun' => $akun,
                'debit' => $debit,
                'kredit' => $kredit,
                'saldo' => $debit - $kredit,
            ];
        });

        $pdf = PDF::loadView('backend.laporan.pdf.neraca_saldo', compact('data', 'startDate', 'endDate'));
        return $pdf->stream('laporan-neraca-saldo.pdf');
    }

    /**
     * Laporan Perhitungan Hasil Usaha (LPHU)
     */
    public function lphu(Request $request)
    {
        $startDate = $request->start_date ?? now()->startOfMonth()->toDateString();
        $endDate = $request->end_date ?? now()->toDateString();

        $pendapatan = Account::where('kategori', 'Pendapatan')
            ->with(['jurnalDetails' => function ($q) use ($startDate, $endDate) {
                $q->whereHas('jurnal', function ($sub) use ($startDate, $endDate) {
                    $sub->whereBetween('tanggal', [$startDate, $endDate]);
                });
            }])->get();

        $beban = Account::where('kategori', 'Beban')
            ->with(['jurnalDetails' => function ($q) use ($startDate, $endDate) {
                $q->whereHas('jurnal', function ($sub) use ($startDate, $endDate) {
                    $sub->whereBetween('tanggal', [$startDate, $endDate]);
                });
            }])->get();

        $totalPendapatan = $pendapatan->sum(fn($a) => $a->jurnalDetails->sum('kredit'));
        $totalBeban = $beban->sum(fn($a) => $a->jurnalDetails->sum('debit'));
        $hasilUsaha = $totalPendapatan - $totalBeban;

        return view('backend.laporan.lphu', compact(
            'pendapatan',
            'beban',
            'totalPendapatan',
            'totalBeban',
            'hasilUsaha',
            'startDate',
            'endDate'
        ));
    }

    public function cetakLphuPdf()
    {
        $startDate = request()->input('start_date');
        $endDate = request()->input('end_date');

        $pendapatan = Account::where('kategori', 'Pendapatan')
            ->with(['jurnalDetails' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('jurnal', function ($q) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $q->whereBetween('tanggal', [$startDate, $endDate]);
                    }
                });
            }])->get();

        $beban = Account::where('kategori', 'Beban')
            ->with(['jurnalDetails' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('jurnal', function ($q) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $q->whereBetween('tanggal', [$startDate, $endDate]);
                    }
                });
            }])->get();

        // Hitung total
        $totalPendapatan = $pendapatan->sum(function ($akun) {
            return $akun->jurnalDetails->sum('kredit');
        });

        $totalBeban = $beban->sum(function ($akun) {
            return $akun->jurnalDetails->sum('debit');
        });

        $hasilUsaha = $totalPendapatan - $totalBeban;

        $pdf = PDF::loadView('backend.laporan.pdf.lphu', [
            'pendapatan' => $pendapatan,
            'beban' => $beban,
            'totalPendapatan' => $totalPendapatan,
            'totalBeban' => $totalBeban,
            'hasilUsaha' => $hasilUsaha,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->stream('LPHU.pdf');
    }

    /**
     * Arus Kas
     */
    public function arusKas(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $query = JurnalDetail::whereHas('account', function ($q) {
            $q->where('kategori', 'Aset')->where('nama_akun', 'like', '%Kas%');
        });

        if ($start && $end) {
            $query->whereHas('jurnal', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            });
        }

        $kasMasuk = (clone $query)->where('debit', '>', 0)->sum('debit');
        $kasKeluar = (clone $query)->where('kredit', '>', 0)->sum('kredit');

        return view('backend.laporan.arus_kas', compact('kasMasuk', 'kasKeluar'));
    }

    public function arusKasPdf(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $query = JurnalDetail::with(['akun', 'jurnal'])->whereHas('account', function ($q) {
            $q->where('kategori', 'Aset')->where('nama_akun', 'like', '%Kas%');
        });

        if ($start && $end) {
            $query->whereHas('jurnal', function ($q) use ($start, $end) {
                $q->whereBetween('tanggal', [$start, $end]);
            });
        }

        $kasMasuk = (clone $query)->where('debit', '>', 0)->sum('debit');
        $kasKeluar = (clone $query)->where('kredit', '>', 0)->sum('kredit');
        $saldoKas = $kasMasuk - $kasKeluar;
        $tanggalCetak = now()->format('d F Y');

        $pdf = PDF::loadView('backend.laporan.pdf.arus_kas', compact(
            'kasMasuk',
            'kasKeluar',
            'saldoKas',
            'tanggalCetak',
            'start',
            'end'
        ))->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_arus_kas.pdf');
    }

    /**
     * Neraca
     */

    public function neraca(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        // Ambil akun-akun berdasarkan kategori
        $aset = Account::where('kategori', 'Aset')
            ->with(['jurnalDetails' => function ($q) use ($tanggal) {
                $q->whereHas('jurnal', fn($j) => $j->whereDate('tanggal', '<=', $tanggal));
            }])->get();

        $liabilitas = Account::where('kategori', 'Liabilitas') // sebelumnya salah: 'Kewajiban'
            ->with(['jurnalDetails' => function ($q) use ($tanggal) {
                $q->whereHas('jurnal', fn($j) => $j->whereDate('tanggal', '<=', $tanggal));
            }])->get();

        $ekuitas = Account::where('kategori', 'Ekuitas')
            ->with(['jurnalDetails' => function ($q) use ($tanggal) {
                $q->whereHas('jurnal', fn($j) => $j->whereDate('tanggal', '<=', $tanggal));
            }])->get();

        // Fungsi hitung saldo berdasarkan jenis kategori
        $hitungSaldo = function ($group) {
            return $group->map(function ($akun) {
                $debit = $akun->jurnalDetails->sum('debit');
                $kredit = $akun->jurnalDetails->sum('kredit');

                // Aset dan Beban: saldo = debit - kredit
                // Lainnya (Liabilitas, Ekuitas, Pendapatan): saldo = kredit - debit
                $kategoriDebit = ['Aset', 'Beban'];
                $saldo = in_array($akun->kategori, $kategoriDebit)
                    ? $debit - $kredit
                    : $kredit - $debit;

                return [
                    'akun' => $akun,
                    'saldo' => $saldo,
                ];
            });
        };

        // Hitung saldo per kategori
        $asetData = $hitungSaldo($aset);
        $liabilitasData = $hitungSaldo($liabilitas);
        $ekuitasData = $hitungSaldo($ekuitas);

        // Total
        $totalAset = $asetData->sum('saldo');
        $totalLiabilitas = $liabilitasData->sum('saldo');
        $totalEkuitas = $ekuitasData->sum('saldo');

        return view('backend.laporan.neraca', compact(
            'tanggal',
            'asetData',
            'liabilitasData',
            'ekuitasData',
            'totalAset',
            'totalLiabilitas',
            'totalEkuitas'
        ));
    }

    public function cetakNeracaPdf()
    {
        $startDate = request()->input('start_date');
        $endDate = request()->input('end_date');

        // Ambil data per kategori
        $aset = Account::where('kategori', 'Aset')
            ->with(['jurnalDetails' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('jurnal', function ($q) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $q->whereBetween('tanggal', [$startDate, $endDate]);
                    }
                });
            }])->get();

        $kewajiban = Account::where('kategori', 'Kewajiban')
            ->with(['jurnalDetails' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('jurnal', function ($q) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $q->whereBetween('tanggal', [$startDate, $endDate]);
                    }
                });
            }])->get();

        $modal = Account::where('kategori', 'Modal')
            ->with(['jurnalDetails' => function ($query) use ($startDate, $endDate) {
                $query->whereHas('jurnal', function ($q) use ($startDate, $endDate) {
                    if ($startDate && $endDate) {
                        $q->whereBetween('tanggal', [$startDate, $endDate]);
                    }
                });
            }])->get();

        // Perhitungan saldo
        $totalAset = $aset->sum(function ($akun) {
            return $akun->jurnalDetails->sum('debit') - $akun->jurnalDetails->sum('kredit');
        });

        $totalKewajiban = $kewajiban->sum(function ($akun) {
            return $akun->jurnalDetails->sum('kredit') - $akun->jurnalDetails->sum('debit');
        });

        $totalModal = $modal->sum(function ($akun) {
            return $akun->jurnalDetails->sum('kredit') - $akun->jurnalDetails->sum('debit');
        });

        $totalPasiva = $totalKewajiban + $totalModal;

        $pdf = PDF::loadView('backend.laporan.pdf.neraca', [
            'aset' => $aset,
            'kewajiban' => $kewajiban,
            'modal' => $modal,
            'totalAset' => $totalAset,
            'totalKewajiban' => $totalKewajiban,
            'totalModal' => $totalModal,
            'totalPasiva' => $totalPasiva,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->stream('Neraca.pdf');
    }

}
