<?php

namespace App\Exports;

use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Helper generik untuk download dataset laporan sebagai XLSX atau CSV.
 */
class LaporanExport
{
    public static function downloadAny(array $rows, string $name, string $format): Response
    {
        $headers = ['Tanggal', 'Jenis', 'ID Anggota', 'Nama', 'Keterangan', 'Nominal'];

        if ($format === 'csv') {
            $stream = fopen('php://temp', 'r+');
            fputcsv($stream, $headers);
            foreach ($rows as $line) {
                fputcsv($stream, $line);
            }
            rewind($stream);

            return response("\xEF\xBB\xBF" . stream_get_contents($stream), 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"$name.csv\"",
            ]);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan');
        $sheet->fromArray($headers, null, 'A1');
        $sheet->fromArray($rows, null, 'A2');
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, "$name.xlsx", [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
