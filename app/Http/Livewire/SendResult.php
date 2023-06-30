<?php

namespace App\Http\Livewire;

use App\Models\Clas;
use App\Notifications\ReportCard;
use Livewire\Component;
use Illuminate\Support\Facades\Notification;


class SendResult extends Component
{
    public $term_id, $clas_id, $status;

    function send($clas)
    {
        $count = 0;
        $delay = now()->addMinutes(1);
        
        try {
            $guardians = guardianByStudentClass($clas);
            // send emails of report card to parent
            foreach ($guardians as $guardian) {
                $count++;
                $guardian->notify(new ReportCard($guardian))->delay($delay); //delay by 1 minutes
            }

            // Notification::send($guardians, new ReportCard($guardians));

        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
        }

        if($count == count($guardians)){
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'All Parent should receive notification of his/her child(ren).',
                'title' => 'Full Email Sent',
                'button' => false,
            ]);
        }elseif($count < count($guardians) && $count != 0){
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'success',
                'text' => 'Some email sent, while some are still processing and will be sending in background',
                'title' => 'Partial Email sent',
                'button' => false,
            ]);
        }else{
            $this->dispatchBrowserEvent('swal:success', [
                'icon' => 'warning',
                'text' => 'some errors occur, thereby message may experience delay',
                'title' => 'Email not sent',
                'button' => false,
            ]);
        }
    }
    public function render()
    {
        return view('livewire.send-result')->layout('layouts.dashboard');
    }
}