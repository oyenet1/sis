<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;

class Messages extends Component
{
    public User $sender;
    public $search = '';
    public $type = 'member';
    public $member_type = 'role';
    public $cid = [];
    public $message,  $email, $phone, $role;
    public $code = "+234";

    // public User $staffs;

    public $update = false;
    public $form = false;


    function selectType($value)
    {
        $this->type = $value;
    }
    public function render()
    {
        $term = "%$this->search%";
        $messages = currentUser()->messages()->with(['sender', 'receivers'])
            ->where('type', $this->type)
            ->latest()
            ->get();
        return view('livewire.messages', compact(['messages']))->layout('layouts.dashboard');
    }
}