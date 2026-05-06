<?php

namespace App\Services;

use App\Models\Cv;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfService
{
    /**
     * Generate PDF dari data CV dan return sebagai download response.
     */
    public function generate(Cv $cv): Response
    {
        $pdf = Pdf::loadView('pdf.cv', ['cv' => $cv]);

        $pdf->setPaper('A4', 'portrait');

        $filename = $this->sanitizeFilename($cv->nama_file) . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Sanitize nama file agar aman untuk dijadikan nama file PDF.
     */
    private function sanitizeFilename(string $name): string
    {
        // Hapus karakter yang tidak aman untuk nama file
        $name = preg_replace('/[^a-zA-Z0-9\-_\s]/', '', $name);
        $name = trim(preg_replace('/\s+/', '-', $name));
        return $name ?: 'CV';
    }
}
