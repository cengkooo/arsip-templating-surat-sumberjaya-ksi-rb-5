<div class="template-preview" style="border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem; background: white;">
    @if($getRecord()->content_header)
    <div class="header-preview" style="border-bottom: 2px solid #000; padding-bottom: 1rem; margin-bottom: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #374151; font-size: 0.875rem; font-weight: 600;">📄 HEADER (KOP SURAT)</h4>
        <div style="background: #f9fafb; padding: 1rem; border-radius: 0.375rem; font-size: 0.875rem;">
            {!! $getRecord()->content_header !!}
        </div>
    </div>
    @endif

    @if($getRecord()->content_body)
    <div class="body-preview" style="margin-bottom: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #374151; font-size: 0.875rem; font-weight: 600;">📝 ISI SURAT</h4>
        <div style="background: #f9fafb; padding: 1rem; border-radius: 0.375rem; font-size: 0.875rem;">
            {!! $getRecord()->content_body !!}
        </div>
        <p style="margin-top: 0.5rem; font-size: 0.75rem; color: #6b7280;">
            💡 <strong>Tips:</strong> Variable seperti <code style="background: #fef3c7; padding: 0.125rem 0.25rem; border-radius: 0.25rem;">{{'{{'}}nama{{'}}'}}</code> akan diganti dengan data asli saat generate surat.
        </p>
    </div>
    @endif

    @if($getRecord()->content_footer)
    <div class="footer-preview" style="border-top: 1px solid #e5e7eb; padding-top: 1rem;">
        <h4 style="margin: 0 0 0.5rem 0; color: #374151; font-size: 0.875rem; font-weight: 600;">✍️ FOOTER (TANDA TANGAN)</h4>
        <div style="background: #f9fafb; padding: 1rem; border-radius: 0.375rem; font-size: 0.875rem;">
            {!! $getRecord()->content_footer !!}
        </div>
    </div>
    @endif
</div>