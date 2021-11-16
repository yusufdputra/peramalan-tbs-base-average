<?php

namespace App\Imports;

use App\Datasets;
use Maatwebsite\Excel\Concerns\ToModel;
use Ramsey\Uuid\Type\Integer;

class DataActualImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        try {
            return new Datasets([
                'tanggal' => $this->transformDate($row[0]),
                'tbs_olah' => $row[1],
            ]);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
