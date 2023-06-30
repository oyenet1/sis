<?php

namespace App\Http\Livewire;

use App\Models\Sesion;
use App\Models\Term;
use Livewire\Component;
use Livewire\WithPagination;

class Session extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete'
    ];


    public $name, $start, $end, $cid, $dso, $sesion_id;
    public $update = false;
    public $form = false;
    public $activeSession;

    function mount()
    {
        if (latestTerm()) {
            $this->activeSession = latestTerm()->sesion_id;
        }
    }

    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    function add()
    {
        $this->update = false;
    }

    function showForm()
    {
        $this->form = true;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'perPage', 'selected', 'checked']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    function refreshInputs()
    {
        $this->name = '';
        $this->start = '';
        $this->end = '';
        $this->dso = '';
        $this->cid = '';
        $this->form = false;
        $this->update = false;
    }

    function addSession()
    {
        try {
            Sesion::create([
                'name' => date('Y') . '/' . date('Y') + 1,
            ]);

            session()->flash('success', 'Session created successfully');
        } catch (\Throwable $e) {
            session()->flash('error', 'Wait till this session ends before creating another session');
        }
        $this->dispatchBrowserEvent('reload');
    }

    protected $rules = [
        'name' => 'required#',
        'start' => 'required|date',
        'end' => "required|date|before:tomorrow",
        'dso' => "nullable|int",
    ];

    function save()
    {
        $term = $this->validate([
            'name' => 'required',
            'start' => 'required|date',
            'end' => "required|date|after:start",
            'dso' => "nullable|numeric",
        ]);

        $session = Sesion::find($this->activeSession);

        $true = $session->terms()->create($term);

        if ($true) {
            $this->refreshInputs();
            session()->flash('success', 'Term created successfully');
        }

        $this->dispatchBrowserEvent('reload');
    }
    function edit(Term $term)
    {
        $this->showForm();
        $this->cid = $term->id;
        $this->name = $term->name;
        $this->start = $term->start;
        $this->end = $term->end;
        $this->update = true;
        $this->dso = $term->dso;
    }
    function update()
    {
        $data = $this->validate([
            'name' => 'required',
            'start' => 'required|date',
            'end' => "required|date|after:start",
            'dso' => "nullable|numeric",
        ]);
        $term = Term::find($this->cid);
        $true = $term->update($data);

        if ($true) {
            $this->refreshInputs();
            session()->flash('success', 'Term updated successfully');
        }

        return redirect()->back();
    }

    protected $messages = [
        'name.unique' => "Session already existed",
        'dso.numeric' => 'Number of days school opened must be a real number',
    ];

    public function render()
    {
        $session = Sesion::with('terms')->find($this->activeSession);
        $sessions = Sesion::select(['name', 'id'])->latest()->get();
        return view('livewire.session', compact(['sessions', 'session']))->layout('layouts.dashboard');
    }
}