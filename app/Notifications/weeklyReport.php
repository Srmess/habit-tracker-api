<?php

declare(strict_types = 1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class weeklyReport extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Collection $habits)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())->subject('Habit weekly report')->markdown('mail.weekly-report', [

            'map' => $this->getMap(),

        ]);
    }

    public function getMap(): string
    {
        $habitNames = $this->habits->groupBy('habit_name')->keys()->map(fn ($name) => str($name)->limit(20) . " |")->implode(' ');
        $splitter   = $this->habits->groupBy('habit_name')->keys()->map(fn ($name) => " -----------: |")->implode(' ');
        $days       = $this->habits->groupBy('log_date')->map(function ($habit) {
            $day  = $habit->first()->log_date->format('D j');
            $logs = $habit->map(fn ($item) => ($item->completed ? '✓' : 'X') . ' |')->implode(' ');

            return <<<HTML
            | $day | $logs
            HTML;
        })->implode("\n");

        return <<<HTML
        |            | $habitNames
        | -------- | $splitter
        $days
        HTML;
    }
}
