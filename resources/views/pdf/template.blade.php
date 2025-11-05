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
            padding: {{ $template->margin_atas ?? 0.63 }}cm {{ $template->margin_kanan ?? 1.78 }}cm {{ $template->margin_bawah ?? 1.37 }}cm {{ $template->margin_kiri ?? 1.78 }}cm;
        }
        
        /* KOP SURAT STYLES */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000;
            position: relative;
        }
        
        .kop-surat .logo {
            width: 80px;
            height: 80px;
            position: absolute;
            left: 0;
            top: 0;
        }
        
        .kop-surat .identitas {
            padding: 0 100px;
        }
        
        .kop-surat .nama-pemerintahan {
            font-size: 16pt;
            font-weight: bold;
            margin: 0;
            padding: 0;
            line-height: 1.3;
            text-transform: uppercase;
        }
        
        .kop-surat .alamat {
            font-size: 10pt;
            margin: 5px 0 0 0;
            padding: 0;
            line-height: 1.4;
        }
        
        .kop-surat .kontak {
            font-size: 9pt;
            margin: 3px 0 0 0;
            padding: 0;
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
            <img src="{{ public_path('storage/' . $desaSetting->logo_path) }}" alt="Logo" class="logo">
            @endif
            
            <div class="identitas">
                <div class="nama-pemerintahan">
                    @if($desaSetting->nama_kabupaten)
                    <div>{{ $desaSetting->nama_kabupaten }}</div>
                    @endif
                    @if($desaSetting->nama_kecamatan)
                    <div>{{ $desaSetting->nama_kecamatan }}</div>
                    @endif
                    @if($desaSetting->nama_desa)
                    <div>{{ $desaSetting->nama_desa }}</div>
                    @endif
                </div>
                
                @if($desaSetting->alamat_lengkap || $desaSetting->kode_pos)
                <div class="alamat">
                    <em>
                        {{ $desaSetting->alamat_lengkap }}
                        @if($desaSetting->kode_pos)
                        Kode Pos {{ $desaSetting->kode_pos }}
                        @endif
                    </em>
                </div>
                @endif
                
                @if($desaSetting->no_telepon || $desaSetting->email || $desaSetting->website)
                <div class="kontak">
                    @if($desaSetting->no_telepon)
                    Telp: {{ $desaSetting->no_telepon }}
                    @endif
                    @if($desaSetting->email)
                    | Email: {{ $desaSetting->email }}
                    @endif
                    @if($desaSetting->website)
                    | Website: {{ $desaSetting->website }}
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
