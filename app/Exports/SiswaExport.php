<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SiswaExport implements FromCollection, WithHeadings, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $siswaData = Siswa::all();

        $formattedData = $siswaData->map(function ($siswa, $key) {
            return [
                'NO' => $key + 1,
                'NISN' => $siswa->nisn,
                'NIS' => $siswa->nis,
                'Nama Lengkap' => $siswa->namaSiswa,
                'Nama Panggilan' => $siswa->panggilan,
                'Tempat Lahir' => $siswa->tempatLahir,
                'Tanggal Lahir' => $siswa->tanggalLahir,
                'Jenis Kelamin' => $siswa->jenisKelamin,
                'Alamat' => $siswa->alamat,
                'Agama' => $siswa->agama,
                'Status Siswa' => $siswa->status,
                'Nama Ayah' => $siswa->namaAyah,
                'Pekerjaan Ayah' => $siswa->pekerjaanAyah,
                'No Telepon Ayah' => $siswa->noTlpAyah,
                'Alamat Ayah' => $siswa->alamatAyah,
                'NamaIbu' => $siswa->namaIbu,
                'Pekerjaan Ibu' => $siswa->pekerjaanIbu,
                'No Telepon Ibu' => $siswa->noTlpIbu,
                'Alamat Ibu' => $siswa->alamatIbu,
                'NamaWali' => $siswa->namaWali,
                'Pekerjaan Wali' => $siswa->pekerjaanWali,
                'No Telepon Wali' => $siswa->noTlpWali,
                'Alamat Wali' => $siswa->alamatWali,
            ];
        });

        return $formattedData;
    }
    public function headings(): array
    {
        return [
            'NO',
            'NISN',
            'NIS',
            'Nama Lengkap',
            'Nama Panggilan',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Agama',
            'Status Siswa',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'No Telepon Ayah',
            'Alamat Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No Telepon Ibu',
            'Alamat Ibu',
            'Nama Wali',
            'Pekerjaan Wali',
            'No Telepon Wali',
            'Alamat Wali',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Apply some basic styles to the header row
                $event->sheet->getStyle('A1:W1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'f2f2f2', // Header background color
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // Set column widths
                $event->sheet->getColumnDimension('A')->setWidth(5);
                $event->sheet->getColumnDimension('B')->setWidth(15);
                $event->sheet->getColumnDimension('C')->setWidth(15);
                $event->sheet->getColumnDimension('D')->setWidth(40);
                $event->sheet->getColumnDimension('E')->setWidth(20);
                $event->sheet->getColumnDimension('F')->setWidth(20);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(20);
                $event->sheet->getColumnDimension('I')->setWidth(25);
                $event->sheet->getColumnDimension('J')->setWidth(20);
                $event->sheet->getColumnDimension('K')->setWidth(20);
                $event->sheet->getColumnDimension('L')->setWidth(30);
                $event->sheet->getColumnDimension('M')->setWidth(20);
                $event->sheet->getColumnDimension('N')->setWidth(20);
                $event->sheet->getColumnDimension('O')->setWidth(25);
                $event->sheet->getColumnDimension('P')->setWidth(30);
                $event->sheet->getColumnDimension('Q')->setWidth(20);
                $event->sheet->getColumnDimension('R')->setWidth(20);
                $event->sheet->getColumnDimension('S')->setWidth(25);
                $event->sheet->getColumnDimension('T')->setWidth(30);
                $event->sheet->getColumnDimension('U')->setWidth(20);
                $event->sheet->getColumnDimension('V')->setWidth(20);
                $event->sheet->getColumnDimension('W')->setWidth(25);

                $event->sheet->getStyle('I')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('O')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('S')->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('W')->getAlignment()->setWrapText(true);

                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();

                for ($row = 1; $row <= $highestRow; $row++) {
                    for ($col = 'A'; $col <= $highestColumn; $col++) {
                        $cellValue = $event->sheet->getCell($col . $row)->getValue();

                        if ($cellValue !== null && $cellValue !== '') {
                            $event->sheet->getStyle($col . $row)->applyFromArray([
                                'borders' => [
                                    'outline' => [
                                        'borderStyle' => Border::BORDER_THIN,
                                        'color' => ['argb' => '000000'],
                                    ],
                                ],
                                'font' => [
                                    'name' => 'Times New Roman',
                                    'size' => 12
                                ]
                            ]);
                        }
                    }
                }

                $event->sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
