<?php

namespace App\Services;

use App\Models\SuratGenerate;
use App\Models\DesaSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfGeneratorService
{
    public function generate(SuratGenerate $suratGenerate)
    {
        $template = $suratGenerate->templateSurat;
        $desaSetting = DesaSetting::getActive();
        
        // Merge data variables dengan data penandatangan dan data surat
        $allVariables = array_merge(
            $suratGenerate->data_variables ?? [],
            [
                'nomor_surat' => $suratGenerate->nomor_surat,
                'tanggal_surat' => $suratGenerate->tanggal_surat->isoFormat('D MMMM YYYY'),
                'penandatangan' => $suratGenerate->nama_penandatangan ?? '',
                'jabatan' => $suratGenerate->jabatan_penandatangan ?? '',
                'nip' => $suratGenerate->nip_penandatangan ?? '',
            ]
        );
        
        $contentBody = $this->replaceVariables(
            $template->content_body,
            $allVariables
        );
        
        $contentHeader = $template->content_header 
            ? $this->replaceVariables($template->content_header, $allVariables)
            : '';
        
        $contentFooter = $template->content_footer
            ? $this->replaceVariables($template->content_footer, $allVariables)
            : '';
        
        $finalContent = [
            'header' => $contentHeader,
            'body' => $contentBody,
            'footer' => $contentFooter,
        ];
        
        $suratGenerate->update([
            'content_final' => json_encode($finalContent),
            'generated_at' => now(),
        ]);
        
        $htmlContent = $this->buildHtml($finalContent, $template, $desaSetting, $suratGenerate);
        
        $pdf = Pdf::loadHTML($htmlContent)
            ->setPaper($template->ukuran_kertas, $template->orientasi)
            ->setOption('margin-top', $template->margin_atas . 'cm')
            ->setOption('margin-right', $template->margin_kanan . 'cm')
            ->setOption('margin-bottom', $template->margin_bawah . 'cm')
            ->setOption('margin-left', $template->margin_kiri . 'cm')
            ->setOption('enable-local-file-access', true);
        
        $cleanNomor = preg_replace('/[^A-Za-z0-9\-]/', '-', $suratGenerate->nomor_surat);
        $filename = 'surat-' . $cleanNomor . '-' . time() . '.pdf';
        $path = 'surat-generate/' . $filename;
        
        Storage::disk('public')->makeDirectory('surat-generate');
        Storage::disk('public')->put($path, $pdf->output());
        
        $suratGenerate->update([
            'file_pdf_path' => $path,
            'status' => 'final',
        ]);
        
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
    
    private function buildHtml(array $content, $template, $desaSetting, $suratGenerate): string
    {
        return view('pdf.template', [
            'content' => $content,
            'template' => $template,
            'desaSetting' => $desaSetting,
            'suratGenerate' => $suratGenerate,
        ])->render();
    }
}
