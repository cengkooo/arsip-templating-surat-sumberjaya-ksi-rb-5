<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSKTMLengkapSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori ada
        $kategori = Kategori::firstOrCreate(
            ['kode' => 'SK'],
            [
                'nama' => 'Surat Keterangan',
                'keterangan' => 'Kategori untuk berbagai surat keterangan',
                'is_active' => true,
            ]
        );

        // Template SKTM Lengkap (sesuai yang udah lu buat)
        TemplateSurat::updateOrCreate(
            ['kode_template' => 'SKTM'],
            [
                'kategori_id' => $kategori->id,
                'nama_template' => 'Surat Keterangan Tidak Mampu',
                'keterangan' => 'Template SKTM lengkap dengan semua field dan formatting',
                
                // Header (optional - kosongkan karena pakai kop surat otomatis)
                'content_header' => null,
                
                // Body (isi surat)
                'content_body' => <<<'HTML'
<body style="font-family:'Times New Roman', serif; font-size:14px; line-height:1.6; margin:40px;">

    <div style="text-align:center; font-weight:bold; text-transform:uppercase; text-decoration:underline; font-size:18px;">
        Surat Keterangan Tidak Mampu
    </div>

    <div style="text-align:center; margin-top:4px; font-size:14px; font-weight:bold;">
        Nomor : {{nomor_surat}}
    </div>

    <br><br>

    <p style="text-align:justify;">
        Kepala Desa Sumber Jaya Kecamatan Jati Agung Kabupaten Lampung Selatan, dengan ini menerangkan bahwa:
    </p>

    <table style="width:100%; margin-top:10px; line-height:1.6;">
        <tr>
            <td style="width:180px;">Nama</td>
            <td style="width:10px;">:</td>
            <td>{{nama}}</td>
        </tr>
        <tr>
            <td>Tempat Tgl Lahir</td>
            <td>:</td>
            <td>{{tempat_lahir}}, {{tanggal_lahir}}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{jenis_kelamin}}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{agama}}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{pekerjaan}}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{alamat}}</td>
        </tr>
    </table>

    <br>

    <p style="text-align:justify;">
        Adalah benar penduduk Desa Sumber Jaya yang sesuai dengan identitas tersebut diatas. 
        Selanjutnya menurut data dan pengamatan kami langsung nama tersebut tergolong dalam Rumah 
        Tangga Miskin <b>(Pra Sejahtera)</b>, untuk itu kami mohon kepada pihak-pihak yang 
        berhubungan dengan nama tersebut diatas untuk dapat membantunya.
    </p>

    <p style="text-align:justify;">
        Demikian Surat Keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

</body>
HTML,
                
                // Footer (tanda tangan)
                'content_footer' => <<<'HTML'
<table style="width: 100%; border: none; margin-top: 30px;">
<tr>
    <td style="width: 50%; border: none;"></td>
    <td style="width: 50%; text-align: center; border: none;">
        <p style="margin: 0; margin-bottom: 5px;">Sumber Jaya, {{tanggal_surat}}</p>
        <p style="margin: 0; margin-bottom: 80px;"><strong>{{jabatan}}</strong></p>
        <p style="margin: 0; margin-bottom: 0;"><strong><u>{{penandatangan}}</u></strong></p>
        <p style="margin: 0;">NIP: {{nip}}</p>
    </td>
</tr>
</table>
HTML,
                
                // Variables
                'variables' => [
                    'nomor_surat',
                    'nama_desa',
                    'nama_kecamatan',
                    'nama_kabupaten',
                    'nama',
                    'nik',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'jenis_kelamin',
                    'agama',
                    'pekerjaan',
                    'alamat',
                    'tanggal_surat',
                    'jabatan',
                    'penandatangan',
                    'nip',
                ],
                
                // Settings
                'orientasi' => 'portrait',
                'ukuran_kertas' => 'F4',
                'is_active' => true,
                'margin_kiri' => 2.00,
                'margin_kanan' => 2.00,
                'margin_atas' => 1.50,
                'margin_bawah' => 1.50,
                'tampilkan_qrcode' => false,
                'tampilkan_header' => true,
                'header_type' => 'semua_halaman',
                'tampilkan_footer' => true,
                'tampilkan_logo' => true,
                'format_nomor' => null,
                'lampiran_template' => null,
            ]
        );
    }
}
