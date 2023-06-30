<?php

namespace App\Exports;

use App\Models\Visitor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class VisitorExport implements FromQuery
{
    use Exportable;
    protected $students;

    function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {
        return Visitor::query()->whereKey($this->students);
    }
}