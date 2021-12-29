<?php

namespace App\Jobs;

use App\Mail\CanceledClass as MailCanceledClass;
use App\Models\Classes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CanceledClass implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $users;
    public $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $data)
    {
        $this->users = User::whereIn('id', $users)->get();
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->users as $student) {
            $data = [
                'name' => $student->name,
                'date' => Carbon::parse($this->data['date'])->format('d/m/Y')
            ];
            
            try {
                Mail::to($student->email)->queue(new MailCanceledClass($data));
            } catch (\Exception $e) {
                Log::error('aqui agora'.$e->getMessage());
            }
        }
    }
}
