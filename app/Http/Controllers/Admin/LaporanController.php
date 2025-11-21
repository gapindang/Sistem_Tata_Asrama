<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Penghargaan;
use App\Models\Denda;
use App\Models\RiwayatPelanggaran;
use App\Models\RiwayatPenghargaan;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function export(Request $request)
    {
        $type = $request->input('type', 'pelanggaran');
        $format = $request->input('format', 'csv');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $periode = $request->input('periode');

        // Apply date filter
        $dateFilter = $this->getDateFilter($startDate, $endDate, $periode);

        switch ($type) {
            case 'pelanggaran':
                $items = Pelanggaran::with('riwayatPelanggaran')->get();
                $filename = 'laporan_pelanggaran';
                $headings = ['ID', 'Nama Pelanggaran', 'Kategori', 'Poin', 'Denda', 'Total Kasus', 'Deskripsi'];
                $rows = $items->map(function ($item) use ($dateFilter) {
                    $query = $item->riwayatPelanggaran();
                    if ($dateFilter) {
                        $query->whereBetween('tanggal', [$dateFilter['start'], $dateFilter['end']]);
                    }
                    return [
                        $item->id_pelanggaran,
                        $item->nama_pelanggaran,
                        $item->kategori,
                        $item->poin,
                        'Rp ' . number_format($item->denda, 0, ',', '.'),
                        $query->count(),
                        $item->deskripsi ?? '-'
                    ];
                })->toArray();
                break;

            case 'riwayat_pelanggaran':
                $query = RiwayatPelanggaran::with(['warga', 'pelanggaran', 'petugas']);
                if ($dateFilter) {
                    $query->whereBetween('tanggal', [$dateFilter['start'], $dateFilter['end']]);
                }
                $items = $query->get();
                $filename = 'laporan_riwayat_pelanggaran';
                $headings = ['Tanggal', 'Nama Warga', 'NIM', 'Blok', 'Kamar', 'Jenis Pelanggaran', 'Poin', 'Status Sanksi', 'Petugas'];
                $rows = $items->map(function ($item) {
                    return [
                        Carbon::parse($item->tanggal)->format('d/m/Y'),
                        $item->warga->nama ?? '-',
                        $item->warga->nim ?? '-',
                        $item->warga->blok ?? '-',
                        $item->warga->no_kamar ?? '-',
                        $item->pelanggaran->nama_pelanggaran ?? '-',
                        $item->pelanggaran->poin ?? 0,
                        ucfirst($item->status_sanksi),
                        $item->petugas->nama ?? '-'
                    ];
                })->toArray();
                break;

            case 'penghargaan':
                $items = Penghargaan::with('riwayatPenghargaan')->get();
                $filename = 'laporan_penghargaan';
                $headings = ['ID', 'Nama Penghargaan', 'Poin Reward', 'Total Diberikan', 'Deskripsi'];
                $rows = $items->map(function ($item) use ($dateFilter) {
                    $query = $item->riwayatPenghargaan();
                    if ($dateFilter) {
                        $query->whereBetween('tanggal', [$dateFilter['start'], $dateFilter['end']]);
                    }
                    return [
                        $item->id_penghargaan,
                        $item->nama_penghargaan,
                        $item->poin_reward,
                        $query->count(),
                        $item->deskripsi ?? '-'
                    ];
                })->toArray();
                break;

            case 'riwayat_penghargaan':
                $query = RiwayatPenghargaan::with(['warga', 'penghargaan', 'petugas']);
                if ($dateFilter) {
                    $query->whereBetween('tanggal', [$dateFilter['start'], $dateFilter['end']]);
                }
                $items = $query->get();
                $filename = 'laporan_riwayat_penghargaan';
                $headings = ['Tanggal', 'Nama Warga', 'NIM', 'Blok', 'Kamar', 'Jenis Penghargaan', 'Poin', 'Petugas'];
                $rows = $items->map(function ($item) {
                    return [
                        Carbon::parse($item->tanggal)->format('d/m/Y'),
                        $item->warga->nama ?? '-',
                        $item->warga->nim ?? '-',
                        $item->warga->blok ?? '-',
                        $item->warga->no_kamar ?? '-',
                        $item->penghargaan->nama_penghargaan ?? '-',
                        $item->penghargaan->poin_reward ?? 0,
                        $item->petugas->nama ?? '-'
                    ];
                })->toArray();
                break;

            case 'denda':
                $query = Denda::with(['riwayatPelanggaran.warga', 'riwayatPelanggaran.pelanggaran']);
                if ($dateFilter) {
                    $query->whereBetween('created_at', [$dateFilter['start'], $dateFilter['end']]);
                }
                $items = $query->get();
                $filename = 'laporan_denda';
                $headings = ['ID Denda', 'Nama Warga', 'NIM', 'Jenis Pelanggaran', 'Nominal', 'Status Bayar', 'Tanggal Bayar', 'Bukti Bayar'];
                $rows = $items->map(function ($item) {
                    return [
                        $item->id_denda,
                        $item->riwayatPelanggaran->warga->nama ?? '-',
                        $item->riwayatPelanggaran->warga->nim ?? '-',
                        $item->riwayatPelanggaran->pelanggaran->nama_pelanggaran ?? '-',
                        'Rp ' . number_format($item->nominal, 0, ',', '.'),
                        ucfirst($item->status_bayar),
                        $item->tanggal_bayar ? Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-',
                        $item->bukti_bayar ? 'Ada' : 'Belum'
                    ];
                })->toArray();
                break;

            default:
                return redirect()->route('admin.laporan.index')->with('error', 'Tipe laporan tidak dikenali.');
        }

        // Add periode info to filename
        if ($dateFilter) {
            $filename .= '_' . Carbon::parse($dateFilter['start'])->format('Ymd') . '-' . Carbon::parse($dateFilter['end'])->format('Ymd');
        }

        // Export berdasarkan format
        if ($format === 'excel' && class_exists('\Maatwebsite\Excel\Facades\Excel')) {
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\ArrayExport($rows, $headings),
                $filename . '.xlsx'
            );
        }

        if ($format === 'pdf' && class_exists('\Dompdf\Dompdf')) {
            $html = '<html><head><style>
                table { border-collapse: collapse; width: 100%; font-size: 10px; }
                th { background-color: #4a5568; color: white; padding: 8px; text-align: left; border: 1px solid #ddd; }
                td { padding: 6px; border: 1px solid #ddd; }
                tr:nth-child(even) { background-color: #f8f9fa; }
                h2 { text-align: center; color: #2d3748; }
            </style></head><body>';

            $html .= '<h2>Laporan ' . ucwords(str_replace('_', ' ', $type)) . '</h2>';
            if ($dateFilter) {
                $html .= '<p style="text-align:center;">Periode: ' .
                    Carbon::parse($dateFilter['start'])->format('d M Y') . ' - ' .
                    Carbon::parse($dateFilter['end'])->format('d M Y') . '</p>';
            }

            $html .= '<table><thead><tr>';
            foreach ($headings as $heading) {
                $html .= '<th>' . e($heading) . '</th>';
            }
            $html .= '</tr></thead><tbody>';

            foreach ($rows as $row) {
                $html .= '<tr>';
                foreach ($row as $cell) {
                    $html .= '<td>' . e($cell) . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody></table></body></html>';

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"',
            ]);
        }

        // Default: CSV dengan auto-width (UTF-8 BOM untuk Excel compatibility)
        $response = new StreamedResponse(function () use ($rows, $headings) {
            $handle = fopen('php://output', 'w');

            // Add UTF-8 BOM untuk Excel bisa baca UTF-8 dengan benar
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Write headings
            fputcsv($handle, $headings);

            // Write data rows
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '.csv"');

        return $response;
    }

    /**
     * Helper untuk filter tanggal
     */
    private function getDateFilter($startDate, $endDate, $periode)
    {
        if ($startDate && $endDate) {
            return [
                'start' => Carbon::parse($startDate)->startOfDay(),
                'end' => Carbon::parse($endDate)->endOfDay()
            ];
        }

        if ($periode) {
            switch ($periode) {
                case 'today':
                    return [
                        'start' => Carbon::today(),
                        'end' => Carbon::today()->endOfDay()
                    ];
                case 'this_week':
                    return [
                        'start' => Carbon::now()->startOfWeek(),
                        'end' => Carbon::now()->endOfWeek()
                    ];
                case 'this_month':
                    return [
                        'start' => Carbon::now()->startOfMonth(),
                        'end' => Carbon::now()->endOfMonth()
                    ];
                case 'last_month':
                    return [
                        'start' => Carbon::now()->subMonth()->startOfMonth(),
                        'end' => Carbon::now()->subMonth()->endOfMonth()
                    ];
                case 'this_semester':
                    $month = Carbon::now()->month;
                    if ($month >= 8) { // Semester Ganjil: Agustus-Januari
                        return [
                            'start' => Carbon::create(Carbon::now()->year, 8, 1),
                            'end' => Carbon::create(Carbon::now()->year + 1, 1, 31)->endOfMonth()
                        ];
                    } else { // Semester Genap: Februari-Juli
                        return [
                            'start' => Carbon::create(Carbon::now()->year, 2, 1),
                            'end' => Carbon::create(Carbon::now()->year, 7, 31)->endOfMonth()
                        ];
                    }
                case 'this_year':
                    return [
                        'start' => Carbon::now()->startOfYear(),
                        'end' => Carbon::now()->endOfYear()
                    ];
            }
        }

        return null;
    }
}
