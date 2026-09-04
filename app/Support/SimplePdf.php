<?php

namespace App\Support;

use Barryvdh\DomPDF\Facade\Pdf;

class SimplePdf
{
    public static function table(string $title, array $headers, array $rows, array $footers = [])
    {
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>' . htmlspecialchars($title) . '</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #1e293b;
                    font-size: 11px;
                    margin: 20px;
                }
                h1 {
                    text-align: center;
                    font-size: 18px;
                    color: #0f172a;
                    margin-bottom: 20px;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #e2e8f0;
                    padding: 10px 8px;
                    text-align: left;
                }
                th {
                    background-color: #f1f5f9;
                    color: #475569;
                    font-weight: bold;
                    font-size: 10px;
                    text-transform: uppercase;
                }
                tr:nth-child(even) {
                    background-color: #f8fafc;
                }
                .footer {
                    margin-top: 25px;
                    padding-top: 15px;
                    border-top: 2px solid #e2e8f0;
                    font-size: 10px;
                    color: #64748b;
                    line-height: 1.6;
                }
            </style>
        </head>
        <body>
            <h1>' . htmlspecialchars($title) . '</h1>
            <table>
                <thead>
                    <tr>';
        foreach ($headers as $header) {
            $html .= '<th>' . htmlspecialchars($header) . '</th>';
        }
        $html .= '  </tr>
                </thead>
                <tbody>';
        foreach ($rows as $row) {
            $html .= '<tr>';
            foreach ($row as $cell) {
                $html .= '<td>' . htmlspecialchars((string) $cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>
            </table>';
            
        if (!empty($footers)) {
            $html .= '<div class="footer">';
            foreach ($footers as $footer) {
                $html .= '<div><strong>' . htmlspecialchars($footer) . '</strong></div>';
            }
            $html .= '</div>';
        }

        $html .= '
        </body>
        </html>';

        return Pdf::loadHTML($html)->output();
    }
}
