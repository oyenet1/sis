<?php

namespace App\Http\Livewire;

use App\Models\Profile;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class Upload extends Component
{
    public User $user;
    use WithFileUploads;
    public $image;


    function upload()
    {
        $data = $this->validate([
            'image' => 'required|image|max:500', // 500kb max
        ], ['image.image' => 'The image format is not allowed, supported format are png, jpg, jpeg and gif']);

        // $url = $this->image->store();
        $true = Profile::where('user_id', $this->user->id)->get();
        dd($true);
    }

    public function render()
    {
        return view('livewire.upload');
    }
}