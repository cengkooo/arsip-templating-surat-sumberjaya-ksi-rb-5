<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSuratUsahaSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori "Surat Keterangan" ada
        $kategori = Kategori::firstOrCreate(
            ['kode' => 'SK'],
            [
                'nama' => 'Surat Keterangan',
                'keterangan' => 'Kategori untuk berbagai surat keterangan',
                'is_active' => true,
            ]
        );

        TemplateSurat::updateOrCreate(
            ['kode_template' => 'SKU'],
            [
                'kategori_id' => $kategori->id,
                'nama_template' => 'Surat Keterangan Usaha',
                'keterangan' => 'Template SKU siap pakai dengan kop surat otomatis.',
                'content_header' => null,
                'content_body' => <<<'HTML'
<body style="font-family:'Times New Roman', serif; font-size:14px; line-height:1.6; margin:40px;">

    <!-- Judul -->
    <div style="text-align:center; font-weight:bold; text-transform:uppercase; text-decoration:underline; font-size:18px;">
        Surat Keterangan Usaha
    </div>

    <!-- Nomor -->
    <div style="text-align:center; margin-top:4px; font-size:14px; font-weight:bold;">
        <span style="text-decoration:underline;">Nomor :</span> {{nomor_surat}}
    </div>

    <br><br>

    <p style="text-align:justify;">
        Kepala Desa Sumber Jaya Kecamatan Jati Agung Kabupaten Lampung Selatan, dengan ini menerangkan bahwa :
    </p>

    <!-- Identitas Penduduk -->
    <table style="width:100%; margin-top:10px; line-height:1.6;">
        <tr>
            <td style="width:200px;">Nama</td>
            <td style="width:10px;">:</td>
            <td>{{nama}}</td>
        </tr>
        <tr>
            <td>Tempat Tanggal Lahir</td>
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
            <td>Kewarganegaraan</td>
            <td>:</td>
            <td>{{kewarganegaraan}}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{alamat}}</td>
        </tr>
    </table>

    <br>

    <p style="text-align:justify;">
        Adalah benar Penduduk Desa Sumber Jaya yang sesuai dengan identitas tersebut di atas.
        Selanjutnya yang bersangkutan menurut data dan pengamatan kami mempunyai usaha yang bernama :
    </p>

    <!-- Nama Usaha di Tengah -->
    <div style="text-align:center; font-weight:bold; font-size:16px; text-transform:uppercase; text-decoration:underline; margin:10px 0;">
        “{{nama_usaha}}”
    </div>

    <p style="text-align:justify;">
        Dengan identitas sebagai berikut :
    </p>

    <!-- Identitas Usaha -->
    <table style="width:100%; line-height:1.6;">
        <tr>
            <td style="width:30px; vertical-align:top;">1.</td>
            <td style="width:180px; vertical-align:top;">Nama Penanggung Jawab</td>
            <td style="width:10px; vertical-align:top;">:</td>
            <td>{{penanggung_jawab}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top;">2.</td>
            <td style="vertical-align:top;">Bergerak di bidang</td>
            <td style="vertical-align:top;">:</td>
            <td>{{bidang_usaha}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top;">3.</td>
            <td style="vertical-align:top;">Alamat / Domisili</td>
            <td style="vertical-align:top;">:</td>
            <td>{{alamat_usaha}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top;">4.</td>
            <td style="vertical-align:top;">Tahun Operasi</td>
            <td style="vertical-align:top;">:</td>
            <td>{{tahun_operasi}}</td>
        </tr>
        <tr>
            <td style="vertical-align:top;">5.</td>
            <td style="vertical-align:top;">Lain – lain</td>
            <td style="vertical-align:top;">:</td>
            <td>{{lain_lain}}</td>
        </tr>
    </table>

    <br>

    <p style="text-align:justify;">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

</body>
HTML,
                'content_footer' => <<<'HTML'
<div style="text-align:right; margin-top:40px; font-family:'Times New Roman', serif; font-size:14px; line-height:1.6;">

    Sumber Jaya, {{tanggal_surat}} <br>
    {{jabatan}} <br><br><br><br>

    <span style="font-weight:bold; text-decoration:underline;">
        {{penandatangan}}
    </span>
    <br>
    NIP: {{nip}}

</div>
HTML,
                'variables' => [
                    'nomor_surat',
                    'nama',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'jenis_kelamin',
                    'agama',
                    'pekerjaan',
                    'kewarganegaraan',
                    'alamat',
                    'nama_usaha',
                    'penanggung_jawab',
                    'bidang_usaha',
                    'alamat_usaha',
                    'tahun_operasi',
                    'lain_lain',
                    'nama_desa',
                    'tanggal_surat',
                    'jabatan',
                    'penandatangan',
                    'nip',
                ],
                'orientasi' => 'portrait',
                'ukuran_kertas' => 'A4',
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
