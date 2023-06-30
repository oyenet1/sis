<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Models\Term;
use App\Models\Score;
use App\Models\Timetable;
use Livewire\Component;
use Livewire\WithPagination;

class Scores extends Component
{
    use WithPagination;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'scoreConfirm' => 'submitScores'
    ];


    public $term_id, $subject_id, $clas_id, $user_id, $cid, $sesion_id, $student_id, $ca1, $ca2, $pm, $em;
    public $update = false;
    public $form = false;

    public $sesion = '';
    public $term = '';

    public $activeClass = 0;

    public $currentClass = null;

    public $scores = [];

    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 25;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    function setProps($term, $subject, $sesion, $clas)
    {
        $this->term_id = $term;
        $this->subject_id = $subject;
        $this->sesion_id = $sesion;
        $this->clas_id = $clas;
        $this->user_id = currentUser()->id;
    }

    function refreshInputs()
    {
        $this->ca1 = '';
        $this->ca2 = '';
        $this->pm = '';
        $this->em = '';
        $this->form = false;
        $this->update = false;
        $this->checked = [];
    }

    function filterScores()
    {
        $data = $this->validate([
            'sesion' => 'required',
            'term' => 'required|not_in:null,'
        ]);
    }

    // create first score if not exist
    function selectClass($subject, $class, $id)
    {
        $this->currentClass = Timetable::find($id);
        $this->activeClass = $id;
        $term = Term::latest()->first();
        $class = Clas::find($class);




        $this->sesion_id = $term->sesion_id;

        $this->setProps($term->id, $subject, $term->sesion_id, $class->id);
        //create scores for students
        $this->createFirstScores($class->students);

        $scores = Score::where('clas_id', $this->clas_id)->where('subject_id', $this->subject_id)->where('term_id', $this->term_id)->orderBy('total', 'desc')->get();

        $this->scores = $scores;



        // $this->dispatchBrowserEvent('reload');
    }

    function submitScores()
    {
        $scores = Score::findMany($this->checked);

        $submit = $scores->each->update(['submitted' => true]);


        if ($submit) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Scores has been submiited, you won\'t be able to edit it again',
                'title' => 'Scores Submitted successfully',
                'timer' => 3000,
                'button' => false,
            ]);
        }

        return $this->dispatchBrowserEvent('reload');
    }

    function confirmSubmit()
    {
        $this->dispatchBrowserEvent('swal:score');
    }

    function createFirstScores($students)
    {
        foreach ($students as $key => $student) {
            Score::updateOrCreate(
                [
                    'clas_id' => $this->clas_id,
                    'subject_id' => $this->subject_id,
                    'term_id' => $this->term_id,
                    'student_id' => $student->id,
                    'sesion_id' => $this->sesion_id,
                ],
                [
                    'user_id' => currentUser()->id,
                ]
            );
        }
    }

    function add()
    {
        $this->update = false;
    }

    function editScore(Score $score)
    {
        $this->update = true;
        $this->form = true;
        $this->ca1 = $score->ca1;
        $this->ca2 = $score->ca2;
        $this->cid = $score->id;
        $this->em = $score->em;
        $this->pm = $score->pm;
    }
    protected $messages = [
        'ca1.max' => 'The score must not be greater than 10',
        'ca2.max' => 'The score must not be greater than 10',
        'pm.max' => 'The score must not be greater than 20',
        'em.max' => 'The score must not be greater than 40',
    ];

    function update()
    {
        $score = Score::findOrFail($this->cid);

        $data = $this->validate([
            'ca1' => 'nullable|numeric|max:10',
            'ca2' => 'nullable|numeric|max:10',
            'pm' => 'nullable|numeric|max:20',
            'em' => 'nullable|numeric|max:40',
        ]);

        $updatedScore = $score->update(array_merge($data, [
            'total' => totalSubjectScore($this->ca1, $this->ca2, $this->em, $this->pm),
        ]));

        if ($updatedScore) {
            $this->refreshInputs();
            session()->flash('success', 'Score updated successfully');
        }

        $this->dispatchBrowserEvent('reload');
    }



    public function render()
    {
        $scores = $this->scores;
        return view('livewire.scores', compact(['scores']))->layout('layouts.dashboard');
    }
}