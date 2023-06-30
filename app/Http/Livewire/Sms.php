<?php

namespace App\Http\Livewire;

use Exception;
use Livewire\Component;
use Twilio\Rest\Client;

class Sms extends Component
{

    public ?array $receivers;
    public $message, $receiver;

    public function resetFilters()
    {
        $this->reset('message');
        // Will only reset the search property.

        $this->reset(['message', 'receiver']);
        // Will reset both the search AND the isActive property.

        // $this->resetExcept('search');
        // // Will only reset the isActive property (any property but the search property).
    }


    public function sendSingle()
    {
        $data = $this->validate([
            'receiver' => 'required|digits:10',
            'message' => 'required|min:5|max:160'
        ]);


        $this->receiver = '+234' . $data['receiver'];
        $this->message = $data['message'];

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($this->receiver, [
                'from' => $twilio_number,
                'body' => $this->message
            ]);
            dd('message sent successfully');
            // session()->flash('success', 'Message sent successfully');
        } catch (Exception $e) {
            dd('Error: ' . $e->getMessage());
            // session()->flash('success', $e->getMessage());
        }
    }

    public function sendS()
    {

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.sendchamp.com/api/v1/sms/create-sender-id', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer null',
                'Content-Type' => 'application/json',
            ],
        ]);

        echo $response->getBody();
    }

    public function render()
    {
        return view('livewire.sms');
    }
}