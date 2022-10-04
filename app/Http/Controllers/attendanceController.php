<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\attendance;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;


class attendanceController extends Controller
{

    public function store(Request $request)
    {

        $the_file = $request->file('uploaded_file');

        try {

            $spreadsheet = IOFactory::load($the_file->getRealPath());
            $sheet        = $spreadsheet->getActiveSheet();
            $sheet->getStyle("A:Z")->getNumberFormat()->setFormatCode("YYYY-MM-DD");
            $row_limit    = $sheet->getHighestDataRow();
            $column_limit = $sheet->getHighestDataColumn();
            $row_range    = range(2, $row_limit);
            $column_range = range('F', $column_limit);
            $data = array();

            foreach ($row_range as $row) {

                date_default_timezone_set('Africa/Abidjan'); // your user's timezone
                $check_in_ex = $sheet->getCell('A' . $row)->getFormattedValue();
                $check_in = date('Y-m-d H:i:s', strtotime("$check_in_ex UTC"));

                $check_out_ex = $sheet->getCell('B' . $row)->getFormattedValue();
                $check_out = date('Y-m-d H:i:s', strtotime("$check_out_ex UTC"));

                $data[]  = [
                    'check_in' => $check_in,
                    'check_out' => $check_out,
                    'employee_id' => $sheet->getCell('C' . $row)->getValue(),
                    'shedule_id' => $sheet->getCell('D' . $row)->getValue(),
                ];
            }
            DB::table('attendances')->insert($data);
            return response()->json("success");
        } catch (Exception $e) {
            return back()->withErrors('There was a problem uploading the data!');
        }
    }


    public function view($id)
    {
        $data = attendance::join('employees', 'employees.id', '=', 'attendances.employee_id')
            // ->where('attendances.employee_id', $id)  for an employee
            ->select(
                'attendances.check_in',
                'attendances.check_out',
                'employees.name',
            )
            ->get();


        foreach ($data as $item) {

            $to = Carbon::createFromFormat('Y-m-d H:s:i', $item->check_in);
            $from = Carbon::createFromFormat('Y-m-d H:s:i', $item->check_out);

            $diff_in_hours = $to->diffInHours($from);
            $item->working_hours = $diff_in_hours;
        }

        return $data;
    }
}
