<?php

namespace App\Exports;

use App\Models\Clas;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ClassExport implements FromQuery
{
    use Exportable;
    protected $classes;

    function __construct($classes)
    {
        $this->classes = $classes;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Clas::query()->whereKey($this->classes);
    }
}