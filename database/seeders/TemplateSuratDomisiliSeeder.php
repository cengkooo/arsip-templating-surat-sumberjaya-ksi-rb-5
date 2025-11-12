<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\TemplateSurat;
use Illuminate\Database\Seeder;

class TemplateSuratDomisiliSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori 'UMUM' ada
        $kategori = Kategori::firstOrCreate(
            ['kode' => 'UMUM'],
            [
                'nama' => 'Umum',
                'keterangan' => 'Kategori umum untuk berbagai jenis surat',
                'is_active' => true,
            ]
        );

        TemplateSurat::updateOrCreate(
            ['kode_template' => 'DOMISILI-UMUM-001'],
            [
                'kategori_id' => $kategori->id,
                'nama_template' => 'Surat Keterangan Domisili (Contoh)',
                'keterangan' => 'Template contoh domisili siap pakai (header default, isi, footer/TTD).',
                'content_header' => null,
                'content_body' => <<<HTML
<h2 class="text-center underline">SURAT KETERANGAN DOMISILI</h2>
<p class="text-center mb-20">Nomor: {{ nomor_surat }}</p>

<p>Yang bertanda tangan di bawah ini, Kepala Desa {{ desa }} Kecamatan {{ kecamatan }} Kabupaten {{ kabupaten }}, dengan ini menerangkan bahwa:</p>

<table class="mt-10 mb-10">
    <tr><td style="width:180px">Nama</td><td style="width:20px">:</td><td>{{ nama }}</td></tr>
    <tr><td>Tempat/Tgl Lahir</td><td>:</td><td>{{ ttl }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>{{ jenis_kelamin }}</td></tr>
    <tr><td>Pekerjaan</td><td>:</td><td>{{ pekerjaan }}</td></tr>
    <tr><td>Alamat</td><td>:</td><td>{{ alamat }}</td></tr>
    <tr><td>RT/RW</td><td>:</td><td>{{ rt_rw }}</td></tr>
    <tr><td>Dusun</td><td>:</td><td>{{ dusun }}</td></tr>
</table>

<p>Benar nama tersebut sampai saat ini berdomisili di alamat sebagaimana tersebut di atas dan merupakan warga Desa {{ desa }}.</p>

<p>Surat keterangan ini dibuat untuk keperluan: {{ keperluan }}.</p>

<p class="mt-20">Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
HTML,
                'content_footer' => <<<HTML
<table class="mt-30">
    <tr>
        <td style="width:60%"></td>
        <td class="text-center">
            <div>{{ desa }}, {{ tanggal_surat }}</div>
            <div>Kepala Desa {{ desa }}</div>
            <div style="height:70px"></div>
            <div class="underline">{{ nama_kepala_desa }}</div>
        </td>
    </tr>
</table>
HTML,
                'variables' => [
                    'nomor_surat','desa','kecamatan','kabupaten','nama','ttl','jenis_kelamin','pekerjaan','alamat','rt_rw','dusun','keperluan','tanggal_surat','nama_kepala_desa'
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
