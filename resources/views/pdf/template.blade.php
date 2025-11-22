<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat - {{ $arsipSurat->nomor_surat }}</title>
    <style>
        @page {
            margin: {{ $template->margin_atas ?? 1.5 }}cm {{ $template->margin_kanan ?? 2 }}cm {{ $template->margin_bawah ?? 1.5 }}cm {{ $template->margin_kiri ?? 2 }}cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
        }
        
        .page-content {
            padding: 0;
        }
        
        /* KOP SURAT STYLES */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 4px solid #000;
            position: relative;
            min-height: 100px;
        }
        
        .kop-surat .logo {
            width: 90px;
            height: 90px;
            position: absolute;
            left: 10px;
            top: 25px;
            line-height: 1.4;
        }
        
        .kop-surat .identitas {
            padding: 5px 120px;
            text-align: center;
        }
        
        .kop-surat .nama-pemerintahan-kabupaten {
            font:'arial black', sans-serif;
            font-size: 14pt;
            font-weight: bold; 
            margin: 0;
            padding: 0;
        }

        
            .kop-surat .nama-pemerintahan-kecamatan {
            font:'times new roman', sans-serif;
            font-size: 20pt;
            font-weight: bold; 
            margin: 0;
            padding: 0;
        }

            .kop-surat .nama-pemerintahan-desa {
            font:'Bookman Old Style', sans-serif;
            font-size: 16pt;
            font-weight: bold; 
            margin: 0;
            padding: 0;
        }
        
        .kop-surat .nama-pemerintahan div {
            margin: 0;
            padding: 0;
        }
        
        /* alamat & kontak dihapus dari kop surat */
        
        /* HEADER TAMBAHAN */
        .header-tambahan {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        
        /* BODY CONTENT */
        .content-body {
            text-align: justify;
            margin-bottom: 20px;
            min-height: 200px;
        }
        
        /* FOOTER */
        .content-footer {
            margin-top: 30px;
        }
        
        /* TABLES */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table td {
            padding: 3px 5px;
            vertical-align: top;
        }
        
        /* GENERAL */
        img {
            max-width: 100%;
            height: auto;
        }
        
        p {
            margin: 0 0 10px 0;
        }
        
        h1, h2, h3, h4, h5, h6 {
            margin: 10px 0;
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-justify {
            text-align: justify;
        }
        
        .bold {
            font-weight: bold;
        }
        
        .underline {
            text-decoration: underline;
        }
        
        .mt-10 {
            margin-top: 10px;
        }
        
        .mt-20 {
            margin-top: 20px;
        }
        
        .mt-30 {
            margin-top: 30px;
        }
        
        .mb-10 {
            margin-bottom: 10px;
        }
        
        .mb-20 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="page-content">
        <!-- KOP SURAT (FIXED - DARI SETTINGS DESA) -->
        @if($desaSetting && $template->tampilkan_header && $template->header_type !== 'tidak')
        <div class="kop-surat">
            @if($desaSetting->logo_path && $template->tampilkan_logo)
                @php
                    $logoPath = storage_path('app/public/' . $desaSetting->logo_path);
                    if (file_exists($logoPath)) {
                        $imageData = base64_encode(file_get_contents($logoPath));
                        $mimeType = mime_content_type($logoPath);
                        $logoBase64 = "data:{$mimeType};base64,{$imageData}";
                    }
                @endphp
                @if(isset($logoBase64))
                <img src="{{ $logoBase64 }}" alt="Logo" class="logo">
                @endif
            @endif
            
            <div class="identitas">
                    <div class="nama-pemerintahan-kabupaten">
                    @if($desaSetting->nama_kabupaten)
                    <div>{{ strtoupper($desaSetting->nama_kabupaten) }}</div>
                    @endif
                    </div>
                    <div class="nama-pemerintahan-kecamatan">
                    @if($desaSetting->nama_kecamatan)
                    <div>{{ strtoupper($desaSetting->nama_kecamatan) }}</div>
                    @endif
                    </div>
                    <div class="nama-pemerintahan-desa">
                    @if($desaSetting->nama_desa)
                    <div>{{ strtoupper($desaSetting->nama_desa) }}</div>
                    @endif
                    </div>
                
                <!-- alamat_lengkap, no_telepon, email, website tidak ditampilkan di kop surat -->
            </div>
        </div>
        @endif
        
        <!-- HEADER TAMBAHAN (DARI TEMPLATE - OPSIONAL) -->
        @if(!empty($content['header']))
        <div class="header-tambahan">
            {!! $content['header'] !!}
        </div>
        @endif
        
        <!-- ISI SURAT (DARI TEMPLATE - WAJIB) -->
        <div class="content-body">
            {!! $content['body'] !!}
        </div>
        
        <!-- FOOTER (DARI TEMPLATE - TANDA TANGAN) -->
        @if(!empty($content['footer']) && $template->tampilkan_footer)
        <div class="content-footer">
            {!! $content['footer'] !!}
        </div>
        @endif
        
        <!-- QR CODE (JIKA AKTIF) -->
        @if($template->tampilkan_qrcode)
        <div class="mt-30" style="font-size: 8pt; text-align: center;">
            <p>Dokumen ini telah ditandatangani secara elektronik</p>
            <!-- QR Code akan ditambahkan di sini jika sudah implement -->
        </div>
        @endif
    </div>
</body>
</html>
