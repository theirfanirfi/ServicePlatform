<?php

namespace App\Notifications;

use App\Project;
use App\Ship;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectInvitation extends Notification
{
    use Queueable;
    protected $project;
    protected $user;

	/**
	 * Create a new notification instance.
	 *
	 * @param User $user
	 * @param Ship $ship
	 */
    public function __construct(User $user ,Project $project)
    {
        $this->project = $project;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

	/**
	 * Get the Database representation of the notification.
	 *
	 * @param $notifiable
	 *
	 * @return array
	 */
	public function toDatabase($notifiable)
	{
		return [
			'user' => $this->user,
			'project' => $this->project,

		];
	}

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
