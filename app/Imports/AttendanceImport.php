<?php

namespace App\Imports;

use App\Models\attendance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class AttendanceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new attendance([
            'check_in' => $row['check_in'],
            'check_out' => $row['check_out'],
            'employee_id' => $row['employee_id'],
            'shedule_id' => $row['shedule_id'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ]);
    }
}
