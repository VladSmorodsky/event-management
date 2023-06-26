<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class EventReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:event-reminder-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending event reminders for attendees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('start_at', [now(), now()->addDay()]);

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info("Found $eventCount $eventLabel");

        $events->each(fn($event) => $event->attendees->each(
            fn($attendee) => $this->info("Notifying the user {$attendee->user->id}"))
        );

        $this->info('Sending is successful');
    }
}
