<?php

namespace App\Http\Livewire;

use App\Notifications\UserLeaveNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Leave extends Component
{
    use WithPagination;
    public $message;
    public $search = '';
    function save()
    {
        $data = $this->validate([
            'message' => ['required', 'min:100', 'max:100000'],
        ]);


        $leave = currentUser()->leaves()->create(array_merge($data, [
            'status' => 'awaiting approval'
        ]));


        try {

            if ($leave) {
                // welcome email to the users
                // $user->notify(new UserLeaveNotification($leave));

                // send notifications to users(admins)
                // sendNotifyToAdmin($user);

                $this->form = false;
                session()->flash('success', 'Leave Request submitted successully');
                $this->message = '';
            }
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }



        return redirect()->back();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $term = "%$this->search%";
        $leaves = currentUser()->leaves()->with(['user'])
            ->where('status', 'LIKE', $term)
            ->orWhere('message', 'LIKE', $term)
            ->orWhereHas('user', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('first_name', 'LIKE', $term)
                    ->orWhere('school_id', 'LIKE', $term)
                    ->orWhere('last_name', 'LIKE', $term);
            })
            ->having('user_id', currentUser()->id)
            ->latest()
            ->get();
        return view('livewire.leave', compact(['leaves']))->layout('layouts.dashboard');
    }
}