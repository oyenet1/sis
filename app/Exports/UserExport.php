<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class UserExport implements FromQuery
{
    use Exportable;
    protected $users;

    function __construct($users)
    {
        $this->users = $users;
    }

    public function query()
    {
        return User::query()->whereKey($this->users);
    }
}