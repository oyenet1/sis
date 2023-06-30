<?php

namespace App\Http\Livewire\Profiles;

use App\Models\Fee;
use App\Models\Finance;
use App\Models\Payment;
use App\Models\Student;
use Livewire\Component;
use App\Models\Guardian;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class StudentProfile extends Component
{
    public $first_name, $clas_id, $last_name, $gender, $dob, $phone, $email, $blood, $result, $religion, $disability,  $password, $new_password,  $fee_id;

    public $hobbies = [];
    public $options = ['singing', 'swimming', 'drawing', 'watching', 'drumming', 'painting', 'organist', 'cooking', 'gardening', 'teach'];

    public $profile = 'personal'; //personal, bio, guardian, auth
    public $update = false;
    use WithFileUploads;
    public  $student;
    public Guardian $parent;
    public $session_id;

    protected $listeners = [
        'deleteConfirm' => 'delete',
        'deleteMutipleConfirm' => 'buckDelete',
        'payFee',
    ];


    public $form = false;
    public $src = '/img/avatar-1.jpg';

    function openForm()
    {
        $this->form = true;
    }

    // get student details
    function getStudentDetails()
    {
        $this->first_name = $this->student->first_name;
        $this->last_name = $this->student->last_name;
        $this->dob = $this->student->dob;
        $this->phone = $this->student->phone;
        $this->email = $this->student->email;
        $this->blood = $this->student->blood;
        $this->result = $this->student->result;
        $this->religion = $this->student->religion;
        $this->disability = $this->student->disability;
        $this->hobbies = $this->student->hobbies;
        $this->gender = $this->student->gender;
        if ($this->student->clas) {
            $this->clas_id = $this->student->clas->id;
        }
    }

    public $image;

    protected $messages = [
        'image.required' => 'The image cannot be empty',
        'image.max' => 'The image size must not greater than 300kb',
        'image.mimes' => 'The image file must be in the format png, jpg, jpeg',
        'image.dimensions' => 'The image must be in passport format(i.e height and width must be thesame) and less than 100px resolution',
        'clas_id.required' => 'Invalid selection, kindly select a class'
    ];

    function payFee($res)
    {
        $fee = Fee::find($this->fee_id);
        $payment = Payment::create([
            'fee_id' => $this->fee_id,
            'student_id' => $this->student->id,
            'method_id' => 3,
            'status' => 'success'
        ]);
        $done = $payment->fee->increment('total', $fee->amount);
        if ($done) {
            Finance::create();
            session()->flash('success', 'Payment made succesfully');
        }
    }


    function mount(Student $student)
    {
        $this->student = $student;
    }
    public function refreshInputs()
    {
        $this->form = false;
        $this->update = false;
        $this->image = null;
    }

    function changeProfile($value)
    {
        $this->profile = $value;
    }

    function edit()
    {
        $this->getStudentDetails();
        $this->update = !$this->update;
    }

    function updatePassword()
    {
        $password = $this->validate([
            'password' => ['nullable', 'current_password'],
            'new_password' => ['required', 'confirmed', 'min:3', 'max:20']
        ]);

        dd(Hash::make($password['new_password']));
    }

    public function resetImage()
    {
        $this->image = '';
        $this->result = '';
    }

    function pay(Fee $fee)
    {
        $this->fee_id = $fee->id;
        $meta = [
            'fee_id' => $fee->id,
            'student_id' => $this->student->id,
            'method' => 'paystack'
        ];
        $data = [
            'first_name' => $fee->id,
            'last_name' => $this->student->id,
            'email' => $this->student->guardian->email,
            'amount' => $fee->amount,
            'metadata' => $meta,

        ];
        $this->dispatchBrowserEvent('paystack', $data);
    }

    function updateBio()
    {
        $data = $this->validate(
            [
                'blood' => 'nullable',
                'clas_id' => 'nullable',
                'religion' => ['required', Rule::notIn(['select', 'religion', null, ''])],
                'disability' => 'required',
                'hobbies' => ['nullable', Rule::notIn(['select', 'hobbies', null, ''])],
                'result' => ['nullable', 'required_with:blood', 'mimes:png,jpg,jpeg,pdf,doc,docx', 'max:300'],
            ],
            ['disability.required' => 'Select none if the child is without disability']
        );
        // dd($data);

        $updated = $this->student->update($data);

        if ($updated && $this->result) {
            if ($this->result) {
                $this->uploadBloodTestResult();
            }
            $this->update = true;
            session()->flash('success', 'Student bio-data updated successfully');
        }
    }

    function save()
    {
        if ($this->profile == 'personal') {
            $data = $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'dob' => 'required|before_or_equal:today',
                'email' => ['nullable', 'email', 'unique:students,email, ' . $this->student->id],
                'phone' => ['nullable', 'numeric', 'digits_between:10,11', 'unique:students,phone, ' . $this->student->id],
                'gender' => ['required', Rule::notIn(['select', 'gender', null, '']),]
            ]);

            $updated = $this->student->update($data);

            // create an account for him if email addresss is present

            if ($updated) {
                $this->update = true;
                session()->flash('success', 'Student personal info updated successfully');
            }
        }
        return redirect()->back();
    }
    protected $rules = ['image' => 'required|mimes:png,jpg,jpeg,max:300'];


    // toggle between personal, bio, auth, and other profile
    function changeProfileUpdateParam($value)
    {
        $this->profile = $value;
    }

    function changeProfileImage()
    {
        $done = '';
        $image = $this->validate(['image' => 'required|mimes:png,jpg,jpeg,max:300']);
        try {
            $media = $this->student->addMedia($this->image->getRealPath())
                ->usingName(str_replace("/", '-', $this->student->student_id))
                ->toMediaCollection('student');
            $media[0]->file_name = $image['image'];
            $done = $media[0]->save();
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        if ($done) {
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Profile Image uploded',
                'title' => 'Updated Successfully',
                'timer' => 3000,
            ]);
        }
        return session()->flash('success', 'Profile image updated succesfully');
    }


    public function render()
    {
        $faith = ['Christian', 'Muslim', 'Judaism', 'others'];
        $disabilities = ['None', 'Dyslexia', 'Dysgraphia', 'Dyscalculia', 'Auditory processing disorder', 'Language processing disorder', 'Nonverbal learning disabilities', ' Visual perceptual/visual motor deficit'];
        $paid = Payment::where('student_id', $this->student->id)->select(['id', 'fee_id'])->get();
        $paid = oTA($paid);
        $fees = Fee::where('clas_id', $this->student->clas_id)->latest()->get();
        $payments = $this->student->payments;
        return view('livewire.profiles.student-profile', compact(['payments', 'faith', 'fees', 'disabilities', ['paid']]))->layout('layouts.dashboard');
    }
}