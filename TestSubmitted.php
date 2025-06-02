<?php

namespace App\Events;

use App\Models\TestAttempt;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $attempt;

    /**
     * Create a new event instance.
     */
    public function __construct(TestAttempt $attempt)
    {
        $this->attempt = $attempt;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('submissions.' . $this->attempt->test->subject->course->id),
        ];
    }

    public function broadcastWith()
    {
        return [
            'user' => $this->attempt->user->name,
            'test' => $this->attempt->test->title,
            'score' => $this->attempt->score,
            'completed_at' => $this->attempt->completed_at,
        ];
    }
}
