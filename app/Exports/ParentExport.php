<?php

namespace App\Exports;

use App\Models\Guardian;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ParentExport implements FromQuery
{
    use Exportable;

    protected $parents;

    function __construct($parents)
    {
        $this->parents = $parents;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        return Guardian::query()->whereKey($this->parents);
    }
}