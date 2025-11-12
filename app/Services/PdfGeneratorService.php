<?php

namespace App\Services;

use App\Models\ArsipSurat;
use App\Models\DesaSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfGeneratorService
{
    public function generate(ArsipSurat $arsipSurat)
    {
        $template = $arsipSurat->templateSurat;
        $desaSetting = DesaSetting::getActive();
        
        // Merge SEMUA data: desa settings + data variables + data penandatangan + data surat
        $allVariables = array_merge(
            // 1. Variable dari Pengaturan Desa (bisa dipakai di template)
            $desaSetting ? $desaSetting->getTemplateVariables() : [],
            
            // 2. Variable dari form isian
            $arsipSurat->data_variables ?? [],
            
            // 3. Variable dari Arsip Surat (nomor, tanggal, lampiran, perihal, penandatangan)
            [
                'nomor_surat' => $arsipSurat->nomor_surat,
                'lampiran' => $arsipSurat->lampiran ?? '-',
                'perihal' => $arsipSurat->perihal,
                'tanggal_surat' => $arsipSurat->tanggal_surat->isoFormat('D MMMM YYYY'),
                'penandatangan' => $arsipSurat->nama_penandatangan ?? $desaSetting?->nama_pamong_ttd ?? '',
                'jabatan' => $arsipSurat->jabatan_penandatangan ?? $desaSetting?->jabatan_pamong_ttd ?? '',
                'nip' => $arsipSurat->nip_penandatangan ?? $desaSetting?->nip_pamong_ttd ?? '',
            ]
        );
        
        // DEBUG: Log all variables untuk troubleshoot
        \Log::debug('PdfGeneratorService - allVariables:', [
            'jenis_kelamin' => $allVariables['jenis_kelamin'] ?? 'NOT SET',
            'agama' => $allVariables['agama'] ?? 'NOT SET',
            'data_variables' => $arsipSurat->data_variables ?? [],
        ]);
        
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
        
        $arsipSurat->update([
            'content_final' => $finalContent,
            'generated_at' => now(),
        ]);
        
        $htmlContent = $this->buildHtml($finalContent, $template, $desaSetting, $arsipSurat);
        
        $pdf = Pdf::loadHTML($htmlContent)
            ->setPaper($template->ukuran_kertas, $template->orientasi)
            ->setOption('margin-top', $template->margin_atas . 'cm')
            ->setOption('margin-right', $template->margin_kanan . 'cm')
            ->setOption('margin-bottom', $template->margin_bawah . 'cm')
            ->setOption('margin-left', $template->margin_kiri . 'cm')
            ->setOption('enable-local-file-access', true);
        
        $cleanNomor = preg_replace('/[^A-Za-z0-9\-]/', '-', $arsipSurat->nomor_surat);
        $filename = 'surat-' . $cleanNomor . '-' . time() . '.pdf';
        $path = 'surat-arsip/' . $filename;
        
        Storage::disk('public')->makeDirectory('surat-arsip');
        Storage::disk('public')->put($path, $pdf->output());
        
        $arsipSurat->update([
            'file_path' => $path,
            'status' => 'selesai',
            'jenis' => 'keluar',
        ]);
        
        $template->incrementUsage();
        
        return $arsipSurat->fresh();
    }
    
    private function replaceVariables(string $content, array $variables): string
    {
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        return $content;
    }
    
    private function buildHtml(array $content, $template, $desaSetting, $arsipSurat): string
    {
        return view('pdf.template', [
            'content' => $content,
            'template' => $template,
            'desaSetting' => $desaSetting,
            'arsipSurat' => $arsipSurat,
        ])->render();
    }
}
