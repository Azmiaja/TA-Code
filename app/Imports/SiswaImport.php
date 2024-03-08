<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $tanggalLahir = Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d');

        return new Siswa([
            'nisn' => $row['nisn'],
            'nis' => $row['nis'],
            'namaSiswa' => $row['nama_lengkap'],
            'panggilan' => $row['nama_panggilan'],
            'tempatLahir' => $row['tempat_lahir'],
            'tanggalLahir' => $tanggalLahir,
            'jenisKelamin' => $row['jenis_kelamin'],
            'agama' => $row['agama'],
            'alamat' => $row['alamat'],
            'namaAyah' => $row['nama_ayah'],
            'pekerjaanAyah' => $row['pekerjaan_ayah'],
            'noTlpAyah' => $row['telepon_ayah'],
            'alamatAyah' => $row['alamat_ayah'],
            'namaIbu' => $row['nama_ibu'],
            'pekerjaanIbu' => $row['pekerjaan_ibu'],
            'noTlpIbu' => $row['telepon_ibu'],
            'alamatIbu' => $row['alamat_ibu'],
            'namaWali' => $row['nama_wali'],
            'pekerjaanWali' => $row['pekerjaan_wali'],
            'noTlpWali' => $row['telepon_wali'],
            'alamatWali' => $row['alamat_wali'],
        ]);
    }
}
