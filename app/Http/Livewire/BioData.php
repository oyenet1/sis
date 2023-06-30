<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Models\Student;
use App\Models\User;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class BioData extends Component
{
    use WithFileUploads;
    public $clas_id, $blood, $result, $religion, $disability, $hobbies,  $password, $new_password,  $fee_id;

    public $profile = 'bio';
    public Student $student;
    public Parent $parent;

    // get student details

    function studentData(): array
    {
        $data = [
            'email' => $this->student->email,
            'first_name' => $this->student->first_name,
            'last_name' => $this->student->last_name,
            'phone' => $this->student->phone,
        ];
        return $data;
    }


    protected $messages = [
        'result.required' => 'The image cannot be empty',
        'result.max' => 'The image size must not greater than 300kb',
        'result.mimes' => 'The image file must be in the format png, jpg, jpeg',
        'result.dimensions' => 'The image must be in passport format(i.e height and width must be thesame) and less than 100px resolution',
        'clas_id.required' => 'Invalid selection, kindly select a class'
    ];

    function updateBio()
    {
        $data = $this->validate([
            'clas_id' => 'required',
            'blood' => 'nullable',
            'religion' => 'required',
            'disability' => 'required',
            'hobbies' => ['nullable', Rule::notIn(['select', 'hobbies', ''])],
            'result' => ['nullable',  'mimes:png,jpg,jpeg,pdf,doc,docx', 'max:300'],
        ]);
        if ($this->result) {
            $data['result'] = $this->result->store('blood');
        }
        $this->student->update($data);

        // create an account for student in secondary school if not have an account yet

        if (!$this->student->studentAccount && $this->isSecondarySchoolStudent($this->clas_id) && $this->student->email) {
            // dd($this->studentData());
        }

        $this->update = true;
        session()->flash('success', 'Student bio-data updated successfully');
    }

    // upload blood result
    function uploadBloodTestResult()
    {
        try {
            $media = $this->student->addMedia($this->image->getRealPath())
                ->usingName(str_replace("/", '-', $this->student->student_id))
                ->toMediaCollection('blood');
            $media[0]->file_name = str_replace("/", '-', $this->student->student_id);
            $media[0]->save();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    function createAccountForStudent()
    {
        $data = [
            'first_name' => $this->student->first_name,
            'last_name' => $this->student->last_name,
            'email' => $this->student->email,
            'phone' => $this->student->phone,
        ];
        try {
            if ($this->student->email && $this->student->phone) {

                // create user account and assigned role
                $user = User::create($data);
                $user->attachRole(10);
                // update student use relationship
                $true = $this->student->update([
                    'user_id' => $user->id
                ]);

                if ($true) {
                    $this->dispatchBrowserEvent('swal:success', [
                        'icon' => 'success',
                        'text' => 'Student can now login with his/her email/student_id and password',
                        'title' => 'Student account created successfully',
                        'timer' => 5000,
                    ]);
                }
            } else {
                $this->dispatchBrowserEvent('swal:success', [
                    'icon' => 'error',
                    'text' => 'Student must have a valid email address and phone number',
                    'title' => 'Update student Email',
                    'timer' => 5000,
                ]);
            }
        } catch (\Throwable $e) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'info',
                'text' => 'It look like the student email address or phone number is already in use, try and change the phone number or email',
                'title' => 'Error',
            ]);
        }
    }

    public function mount($student)
    {
        $this->blood = $student->blood;
        $this->result = $student->result;
        $this->religion = $student->religion;
        $this->disability = $student->disability;
        $this->hobbies = $student->hobbies;
        if ($student->clas) {
            $this->clas_id = $student->clas->id;
        }
    }

    public function render()
    {
        $faith = ['Christian', 'Muslim', 'Judaism', 'others'];
        $disabilities = ['None', 'Dyslexia', 'Dysgraphia', 'Dyscalculia', 'Auditory processing disorder', 'Language processing disorder', 'Nonverbal learning disabilities', ' Visual perceptual/visual motor deficit'];
        $options = ['singing', 'swimming', 'drawing', 'watching', 'drumming', 'painting', 'organist', 'cooking', 'gardening', 'teach'];
        return view('livewire.bio-data', compact(['faith', 'disabilities', 'options']))->layout('layouts.dashboard');
    }

    function isSecondarySchoolStudent($classId): bool
    {
        $ss = Clas::find($classId);

        return in_array($ss->school_id, [1, 2]);
    }
}