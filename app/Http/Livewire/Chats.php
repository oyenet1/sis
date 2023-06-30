<?php

namespace App\Http\Livewire;

use App\Models\Chat;
use App\Models\User;
use Livewire\Component;
use App\Models\Conversation;
use Livewire\WithPagination;

class Chats extends Component
{
    public $selectedRole = null;
    public ?array $checked = [];
    public $perPage = 7;
    public $sortField = 'id';
    public $sortAsc = true;
    public $search = '';
    public $selectPage = false;

    // active conversation
    public $activeChat = 0;
    public $showMessage = false;

    public function setActiveChat($index)
    {
        $this->activeChat = $index;
        $this->showMessage = true;
    }

    use WithPagination;


    // readmore pages

    public function readMore()
    {
        $this->perPage += 10;
    }

    public function render()
    {
        $messages = Chat::with(['user'])->where('conversation_id', $this->activeChat)->get();
        // $staff = User::with(['roles'])->whereHas('roles');
        // $conversation = Conversation::with(['chats'])->where('id', $this->activeChat)->select('id')->get();
        // $messages = $conversation->chats;
        $conversations = Conversation::with(['sender', 'chats'])->where('user_two', currentUser()->id)->paginate($this->perPage); //list of conversation
        return view('livewire.chats', compact(['conversations', 'messages']))->layout('layouts.dashboard');
    }
}