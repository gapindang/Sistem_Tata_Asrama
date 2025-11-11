<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Penghargaan;
use App\Models\Denda;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function export()
    {
        $type = request('type', 'pelanggaran');
        $format = request('format', 'csv');

        switch ($type) {
            case 'pelanggaran':
                $items = Pelanggaran::all();
                $filename = 'pelanggaran.csv';
                $columns = ['id_pelanggaran', 'nama_pelanggaran', 'kategori', 'poin', 'denda', 'deskripsi'];
                break;
            case 'penghargaan':
                $items = Penghargaan::all();
                $filename = 'penghargaan.csv';
                $columns = ['id_penghargaan', 'nama_penghargaan', 'poin_reward', 'deskripsi'];
                break;
            case 'denda':
                $items = Denda::with('riwayatPelanggaran')->get();
                $filename = 'denda.csv';
                $columns = ['id_denda', 'id_riwayat_pelanggaran', 'nominal', 'status_bayar', 'tanggal_bayar'];
                break;
            default:
                return redirect()->route('admin.laporan.index')->with('error', 'Tipe laporan tidak dikenali.');
        }

        // Support for different formats: csv (default), excel (if maatwebsite/excel installed), pdf (if dompdf installed)
        if ($format === 'excel' && class_exists('\Maatwebsite\\Excel\\Excel')) {
            // simple array export via maatwebsite
            $rows = [];
            $rows[] = $columns;
            foreach ($items as $item) {
                $row = [];
                foreach ($columns as $col) {
                    $row[] = $item->{$col} ?? '';
                }
                $rows[] = $row;
            }

            return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ArrayExport($rows), str_replace('.csv', '.xlsx', $filename));
        }

        if ($format === 'pdf' && class_exists('\Dompdf\\Dompdf')) {
            $html = '<table border="1" cellpadding="5"><thead><tr>';
            foreach ($columns as $col) {
                $html .= '<th>' . e($col) . '</th>';
            }
            $html .= '</tr></thead><tbody>';
            foreach ($items as $item) {
                $html .= '<tr>';
                foreach ($columns as $col) {
                    $html .= '<td>' . e($item->{$col} ?? '') . '</td>';
                }
                $html .= '</tr>';
            }
            $html .= '</tbody></table>';

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . str_replace('.csv', '.pdf', $filename) . '"',
            ]);
        }

        // Default: CSV stream
        $response = new StreamedResponse(function () use ($items, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            foreach ($items as $item) {
                $row = [];
                foreach ($columns as $col) {
                    $row[] = $item->{$col} ?? '';
                }
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
