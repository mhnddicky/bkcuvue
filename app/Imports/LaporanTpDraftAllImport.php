<?php

namespace App\Imports;

use Auth;
use App\LaporanTpDraft;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class LaporanTpDraftAllImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    public $timeout = 0;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new LaporanTpDraft([
            'id_user' => Auth::user()->getId(),
            'no_ba' => $row['no_ba'],
            'no_tp' => $row['no_tp'],
            'l_biasa' => $row['lelaki_biasa'],
            'l_lbiasa' => $row['lelaki_luar_biasa'],
            'p_biasa' => $row['perempuan_biasa'],
            'p_lbiasa' => $row['perempuan_luar_biasa'],
            'total_anggota_lalu' => $row['total_anggota_lalu'],
            'aset' => $row['aset'],
            'aset_lalu' => $row['aset_lalu'],
            'aset_masalah' => $row['aset_masalah'],
            'aset_tidak_menghasilkan' => $row['aset_tidak_menghasilkan'],
            'aset_likuid_tidak_menghasilkan' => $row['aset_likuid_tidak_menghasilkan'],
            'aktiva_lancar' => $row['aktiva_lancar'],
            'simpanan_saham' => $row['simpanan_saham'],
            'simpanan_saham_lalu' => $row['simpanan_saham_lalu'],
            'simpanan_saham_des' => $row['simpanan_saham_desember'],
            'nonsaham_harian' => $row['simpanan_non_saham_harian'],
            'nonsaham_unggulan' => $row['simpanan_non_saham_unggulan'],
            'hutang_spd' => $row['hutang_spd'],
            'hutang_tidak_berbiaya_30hari' => $row['hutang_tidak_berbiaya_30_hari'],
            'total_hutang_pihak3' => $row['total_hutang_pihak_ke_3'],
            'piutang_beredar' => $row['piutang_beredar'],
            'piutang_anggota' => $row['piutang_anggota'],
            'piutang_lalai_1bulan' => $row['piutang_lalai_1_12_bulan'],
            'piutang_lalai_12bulan' => $row['piutang_lalai_lebih_dari_12_bulan'],
            'dcr' => $row['dcr'],
            'dcu' => $row['dcu'],
            'dana_gedung' => $row['dana_gedung'],
            'donasi' => $row['donasi'],
            'bjs_saham' => $row['bjs_saham'],
            'beban_penyisihan_dcr' => $row['beban_penyisihan_dcr'],
            'investasi_likuid' => $row['investasi_likuid'],
            'total_pendapatan' => $row['total_pendapatan'],
            'total_biaya' => $row['total_biaya'],
            'shu' => $row['shu'],
            'shu_lalu' => $row['shu_lalu'],
            'rata_aset' => $row['rata_rata_aset'],
            'laju_inflasi' => $row['laju_inflasi'],
            'harga_pasar' => $row['harga_pasar'],
            'periode' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['periode']),
            'created_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_buat']),
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
