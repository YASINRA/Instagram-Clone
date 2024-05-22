<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{
    public Conversation $conversation;
    public $receiver;
    public $body = null;
    public $loadedMessages;
    public $paginate_var = 10;

    function sendMessage()
    {
        $this->validate(['body' => 'required|string']);
        $createdMessage = Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver->id,
            'body' => $this->body
        ]);
        $this->reset('body');
        #push the message
        $this->loadedMessages->push($createdMessage);
        #update conversation model -for sorting in chatlist
        $this->conversation->updated_at = now();
        $this->conversation->save();
        #dispatch refresh event to chatlist
        $this->dispatch('refresh')->to(ChatList::class);
    }

    public function loadMessages()
    {
        #get count
        $count = Message::where('conversation_id', $this->conversation->id)->count();
        #skip and query
        $this->loadedMessages = Message::where('conversation_id', $this->conversation->id)
            ->skip($count - $this->paginate_var)
            ->take($this->paginate_var)
            ->get();
        return $this->loadedMessages;
    }

    function mount()
    {
        $this->receiver =  $this->conversation->getReceiver();
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
