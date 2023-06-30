<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;


class StudentExport implements FromQuery
{
    use Exportable;

    protected $students;

    function __construct($students)
    {
        $this->students = $students;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Student::query()->whereKey($this->students);
    }
}