<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSuratKematianSeeder extends Seeder
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
            ['kode_template' => 'SKK'],
            [
                'kategori_id' => $kategori->id,
                'nama_template' => 'Surat Keterangan Kematian',
                'keterangan' => 'Template SK Kematian siap pakai dengan kop surat otomatis.',
                'content_header' => null,
                'content_body' => <<<'HTML'
<body style="font-family:'Times New Roman', serif; font-size:14px; line-height:1.6; margin:40px;">

    <!-- Judul -->
    <div style="text-align:center; font-weight:bold; text-transform:uppercase; text-decoration:underline; font-size:18px;">
        Surat Keterangan Kematian
    </div>

    <!-- Nomor -->
    <div style="text-align:center; margin-top:4px; font-size:14px; font-weight:bold;">
        <span style="text-decoration:underline;">Nomor :</span> {{nomor_surat}}
    </div>

    <br><br>

    <p style="text-align:justify;">
        Saya yang bertanda tangan di bawah ini, Kepala Desa Sumber Jaya Kecamatan Jati Agung Kabupaten Lampung Selatan
        dengan ini menerangkan bahwa :
    </p>

    <!-- Identitas Alm -->
    <table style="width:100%; margin-top:10px; line-height:1.6;">
        <tr>
            <td style="width:200px;">Nama</td>
            <td style="width:10px;">:</td>
            <td>{{nama_meninggal}}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{jenis_kelamin_meninggal}}</td>
        </tr>
        <tr>
            <td>Tempat Tanggal Lahir</td>
            <td>:</td>
            <td>{{tempat_lahir_meninggal}}, {{tanggal_lahir_meninggal}}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{agama_meninggal}}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{pekerjaan_meninggal}}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{nik_meninggal}}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{alamat_meninggal}}</td>
        </tr>
    </table>

    <br>

    <p style="text-align:justify;">
        Telah meninggal dunia pada :
    </p>

    <!-- Informasi Kematian -->
    <table style="width:100%; line-height:1.6;">
        <tr>
            <td style="width:200px;">Hari, Tanggal</td>
            <td style="width:10px;">:</td>
            <td>{{hari_meninggal}}, {{tanggal_meninggal}}</td>
        </tr>
        <tr>
            <td>Pukul</td>
            <td>:</td>
            <td>{{pukul_meninggal}} WIB</td>
        </tr>
        <tr>
            <td>Bertempat di</td>
            <td>:</td>
            <td>{{tempat_meninggal}}</td>
        </tr>
        <tr>
            <td>Dimakamkan di</td>
            <td>:</td>
            <td>{{dimakamkan_di}}</td>
        </tr>
    </table>

    <br>

    <p style="text-align:justify;">
        Surat Keterangan ini dibuat berdasarkan keterangan pelapor :
    </p>

    <!-- Identitas Pelapor -->
    <table style="width:100%; line-height:1.6;">
        <tr>
            <td style="width:200px;">Nama</td>
            <td style="width:10px;">:</td>
            <td>{{nama_pelapor}}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td>{{jenis_kelamin_pelapor}}</td>
        </tr>
        <tr>
            <td>Tempat Tanggal Lahir</td>
            <td>:</td>
            <td>{{tempat_lahir_pelapor}}, {{tanggal_lahir_pelapor}}</td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>:</td>
            <td>{{umur_pelapor}}</td>
        </tr>
        <tr>
            <td>Agama</td>
            <td>:</td>
            <td>{{agama_pelapor}}</td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{pekerjaan_pelapor}}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{alamat_pelapor}}</td>
        </tr>
        <tr>
            <td>Hubungan dengan yang meninggal</td>
            <td>:</td>
            <td>{{hubungan_pelapor}}</td>
        </tr>
    </table>

    <br>

    <p style="text-align:justify;">
        Demikian surat keterangan kematian ini dibuat dengan sebenar-benarnya agar dapat dipergunakan sebagaimana mestinya.
    </p>

</body>
HTML,
                'content_footer' => <<<'HTML'
<div style="text-align:right; margin-top:40px; font-family:'Times New Roman', serif; font-size:14px; line-height:1.6;">

    Sumberjaya, {{tanggal_surat}} <br>
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
                    'nama_desa',
                    'nama_meninggal',
                    'jenis_kelamin_meninggal',
                    'tempat_lahir_meninggal',
                    'tanggal_lahir_meninggal',
                    'agama_meninggal',
                    'pekerjaan_meninggal',
                    'nik_meninggal',
                    'alamat_meninggal',
                    'hari_meninggal',
                    'tanggal_meninggal',
                    'pukul_meninggal',
                    'tempat_meninggal',
                    'dimakamkan_di',
                    'nama_pelapor',
                    'jenis_kelamin_pelapor',
                    'tempat_lahir_pelapor',
                    'tanggal_lahir_pelapor',
                    'umur_pelapor',
                    'agama_pelapor',
                    'pekerjaan_pelapor',
                    'alamat_pelapor',
                    'hubungan_pelapor',
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
