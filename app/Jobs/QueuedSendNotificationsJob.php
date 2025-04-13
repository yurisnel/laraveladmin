<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class QueuedSendNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $users;
    protected $notificationInstance;

    /**
     * Create a new job instance.
     */
    public function __construct($users, $notificationInstance)
    {
        $this->users = $users;
        $this->notificationInstance = $notificationInstance;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //$this->user->notify(new PostCreatedNotificaction($this->post));
        Notification::send($this->users, $this->notificationInstance);
    }

    public static function dispatchIfEnableWork(...$arguments)
    {
        if (env('QUEUE_WORKER_ENABLED', false)) {
            return self::dispatch(...$arguments);
        } else {
            return self::dispatchSync(...$arguments);
        }
    }
}
