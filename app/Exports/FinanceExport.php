<?php

namespace App\Exports;

use App\Models\Finance;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class FinanceExport implements FromQuery
{
    protected $finances;
    use Exportable;

    function __construct($finances)
    {
        $this->finances = $finances;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Finance::query()->whereKey($this->finances);
    }
}