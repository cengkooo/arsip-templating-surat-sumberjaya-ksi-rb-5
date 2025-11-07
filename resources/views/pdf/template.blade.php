<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Surat - {{ $suratGenerate->nomor_surat }}</title>
    <style>
        @page {
            margin: 0;
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
            padding: {{ $template->margin_atas ?? 1.5 }}cm {{ $template->margin_kanan ?? 2 }}cm {{ $template->margin_bawah ?? 1.5 }}cm {{ $template->margin_kiri ?? 2 }}cm;
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
            width: 110px;
            height: 110px;
            position: absolute;
            left: 10px;
            top: 25px;
        }
        
        .kop-surat .identitas {
            padding: 5px 120px;
            text-align: center;
        }
        
        .kop-surat .nama-pemerintahan {
            font-size: 18pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
            line-height: 1.4;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .kop-surat .nama-pemerintahan div {
            margin: 0;
            padding: 0;
        }
        
        .kop-surat .alamat {
            font-size: 11pt;
            margin: 8px 0 0 0;
            padding: 0;
            line-height: 1.3;
            font-style: italic;
        }
        
        .kop-surat .kontak {
            font-size: 10pt;
            margin: 5px 0 0 0;
            padding: 0;
            line-height: 1.2;
        }
        
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
                <div class="nama-pemerintahan">
                    @if($desaSetting->nama_kabupaten)
                    <div>{{ strtoupper($desaSetting->nama_kabupaten) }}</div>
                    @endif
                    @if($desaSetting->nama_kecamatan)
                    <div>{{ strtoupper($desaSetting->nama_kecamatan) }}</div>
                    @endif
                    @if($desaSetting->nama_desa)
                    <div>{{ strtoupper($desaSetting->nama_desa) }}</div>
                    @endif
                </div>
                
                @if($desaSetting->alamat_lengkap)
                <div class="alamat">
                    {{ $desaSetting->alamat_lengkap }}
                    @if($desaSetting->kode_pos)
                     Kode Pos {{ $desaSetting->kode_pos }}
                    @endif
                </div>
                @endif
                
                @if($desaSetting->no_telepon || $desaSetting->email || $desaSetting->website)
                <div class="kontak">
                    @if($desaSetting->no_telepon)
                    Telp: {{ $desaSetting->no_telepon }}
                    @endif
                    @if($desaSetting->email && $desaSetting->no_telepon)
                     | 
                    @endif
                    @if($desaSetting->email)
                    Email: {{ $desaSetting->email }}
                    @endif
                    @if($desaSetting->website && ($desaSetting->email || $desaSetting->no_telepon))
                     | 
                    @endif
                    @if($desaSetting->website)
                    Website: {{ $desaSetting->website }}
                    @endif
                </div>
                @endif
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
