<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Leave;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\LeaveApproveNotification;

class LeaveAction extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 25;
    public $update = false;
    public $message, $leave, $user, $cid;
    public $form = false;

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'selected', 'checked', 'leave', 'cid']);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    function refreshInputs()
    {
        $this->cid = null;
        $this->form = false;
    }
    function view($id)
    {
        $leave = Leave::findorFail($id);
        $this->leave = $leave;
        $this->cid = $leave->id;
        $this->form = true;
    }

    function accept()
    {
        $accepted = Leave::where('id', $this->cid)->update(['status' => 'approved']);
        $receiver = User::where('id', $this->leave->user_id)->first();
        if ($accepted) {
            // send approve notification to the staff who request for leave
            $receiver->notify(new LeaveApproveNotification($this->leave));

            $this->refreshInputs();
            $this->resetPage();
        }
    }

    function decline()
    {
        $decline = Leave::where('id', $this->cid)->update(['status' => 'decline']);
        $receiver = User::where('id', $decline->user_id)->first();
        if ($decline) {
            // send approve notification to the staff who request for leave
            $receiver->notify(new LeaveApproveNotification($decline));

            $this->cid = null;
            $this->form = false;
        }
    }

    public function render()
    {
        $term = "%$this->search%";
        $leaves = Leave::with(['user'])
            ->having('status', 'awaiting approval')
            ->where('message', 'LIKE', $term)
            ->orWhereHas('user', function (Builder $query) {
                $term = "%$this->search%";
                $query->where('first_name', 'LIKE', $term)
                    ->orWhere('school_id', 'LIKE', $term)
                    ->orWhere('last_name', 'LIKE', $term);
            })->latest()
            ->paginate($this->perPage);
        return view('livewire.leave-action', compact(['leaves']))->layout('layouts.dashboard');
    }
}