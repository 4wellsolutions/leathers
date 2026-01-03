<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendContactEmail implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send email to admin
        \Illuminate\Support\Facades\Mail::to(config('mail.from.address'))
            ->send(new \App\Mail\ContactFormMail($this->data));
    }
}
