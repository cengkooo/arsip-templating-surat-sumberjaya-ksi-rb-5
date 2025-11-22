<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSuratDomisiliSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori 'SURAT-KETERANGAN' ada
        $kategori = Kategori::firstOrCreate(
            ['kode' => 'Sk'],
            [
                'nama' => 'Surat Keterangan',
                'keterangan' => 'Kategori untuk berbagai surat keterangan',
                'is_active' => true,
            ]
        );

        TemplateSurat::updateOrCreate(
            ['kode_template' => 'SKD'],
            [
                'kategori_id' => $kategori->id,
                'nama_template' => 'Surat Keterangan Domisili',
                'keterangan' => 'Template contoh domisili siap pakai (header default, isi, footer/TTD).',
                'content_header' => null,
                'content_body' => <<<'HTML'
<body style="font-family:'Times New Roman', serif; font-size:14px; line-height:1.6; margin:40px;">

    <div style="text-align:center; font-weight:bold; text-transform:uppercase; text-decoration:underline; font-size:18px;">
        Surat Keterangan Domisili
    </div>

    <div style="text-align:center; margin-top:4px; font-size:14px; font-weight:bold;">
        Nomor : {{nomor_surat}}
    </div>

    <br><br>

    <p style="text-align:justify;">
        Penjabat Kepala Desa Sumber Jaya Kecamatan Jati Agung Kabupaten Lampung Selatan dengan ini menerangkan bahwa :
    </p>

    <table style="width:100%; margin-top:10px; line-height:1.6;">
        <tr>
            <td style="width:180px;">Nama</td>
            <td style="width:10px;">:</td>
            <td>{{nama}}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{nik}}</td>
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
            <td>Status Perkawinan</td>
            <td>:</td>
            <td>{{status_perkawinan}}</td>
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
        Adalah benar penduduk Desa Sumber Jaya yang sesuai dengan identitas tersebut diatas dan berdomisili
        ataupun bertempat tinggal di Desa Sumber Jaya secara terus menerus hingga sekarang.
    </p>

    <p style="text-align:justify;">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </p>

</body>
HTML,
                'content_footer' => <<<'HTML'
<table style="width: 100%; margin-top: 40px;">
    <tr>
        <td style="text-align: left;">
            Yang bersangkutan
        </td>
        <td style="text-align: right;">
            Sumber Jaya, {{tanggal_surat}} <br>
            Kepala Desa
        </td>
    </tr>

    <tr>
        <td style="padding-top: 60px; text-align: left;">
            {{nama}}
        </td>
        <td style="padding-top: 60px; text-align: right;">
            {{penandatangan}} <br>
            NIP. {{nip}}
        </td>
    </tr>
</table>
HTML,
                'variables' => [
                    'nama',
                    'nik',
                    'tempat_lahir',
                    'tanggal_lahir',
                    'jenis_kelamin',
                    'agama',
                    'status_perkawinan',
                    'pekerjaan',
                    'alamat',
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
