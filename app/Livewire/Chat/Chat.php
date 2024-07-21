
<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Notifications\MessageSentNotification;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public Conversation $conversation;
    public $receiver;
    public $body;
    public $loadedMessages;
    public $paginate_var = 10;

    function listenBroadcastedMessage($event)
    {
        $this->dispatch('scroll-bottom');

        $newMessage = Message::find($event['message_id']);

        $this->loadedMessages->push($newMessage);

        $newMessage->read_at = now();
        $newMessage->save();
    }

    function sendMessage()
    {
        $this->validate(['body' => 'required|string']);
        $createdMessage = Message::create([
            'conversation_id' => $this->conversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->receiver->id,
            'body' => $this->body
        ]);

        $this->dispatch('scroll-bottom');

        $this->reset('body');

        $this->loadedMessages->push($createdMessage);

        $this->conversation->updated_at = now();
        $this->conversation->save();

        $this->dispatch('refresh')->to(ChatList::class);

        $this->receiver->notify(new MessageSentNotification(
            auth()->user(),
            $createdMessage,
            $this->conversation
        ));
    }

    #[On('loadMore')]
    function loadMore()
    {
        $this->paginate_var += 10;
        $this->loadMessages();
        $this->dispatch('update-height');
    }

    function loadMessages()
    {
        $count = Message::where('conversation_id', $this->conversation->id)->count();

        $this->loadedMessages = Message::where('conversation_id', $this->conversation->id)
            ->skip($count - $this->paginate_var)
            ->take($this->paginate_var)
            ->get();

        return $this->loadedMessages;
    }

    function mount()
    {
        $this->receiver = $this->conversation->getReceiver();
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
