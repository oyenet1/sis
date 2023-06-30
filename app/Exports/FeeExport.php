<?php

namespace App\Exports;

use App\Models\Fee;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class FeeExport implements FromQuery
{
    protected $fees;

    function __construct($fees)
    {
        $this->fees = $fees;
    }
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Fee::query()->whereKey($this->fees);
    }
}