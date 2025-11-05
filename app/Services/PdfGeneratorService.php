<?php

namespace App\Services;

use App\Models\SuratGenerate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfGeneratorService
{
    public function generate(SuratGenerate $suratGenerate)
    {
        // 1. Get template
        $template = $suratGenerate->templateSurat;
        
        // 2. Replace variables dengan data
        $content = $this->replaceVariables(
            $template->content_header . $template->content_body . $template->content_footer,
            $suratGenerate->data_variables
        );
        
        // 3. Save content final
        $suratGenerate->update([
            'content_final' => $content,
            'generated_at' => now(),
        ]);
        
        // 4. Generate PDF
        $pdf = Pdf::loadHTML($this->buildHtml($content, $template))
            ->setPaper($template->ukuran_kertas, $template->orientasi);
        
        // 5. Save PDF file
        $filename = 'surat-' . $suratGenerate->nomor_surat . '-' . time() . '.pdf';
        $path = 'surat-generate/' . $filename;
        
        Storage::disk('public')->put($path, $pdf->output());
        
        // 6. Update record
        $suratGenerate->update([
            'file_pdf_path' => $path,
            'status' => 'final',
        ]);
        
        // 7. Increment template usage
        $template->incrementUsage();
        
        return $suratGenerate->fresh();
    }
    
    private function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        
        return $content;
    }
    
    private function buildHtml(string $content, $template): string
    {
        return view('pdf.template', [
            'content' => $content,
            'template' => $template,
        ])->render();
    }
}