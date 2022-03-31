<?php

namespace App\Jobs;


use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use stdClass;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    private $toEmail = '';
    private $listCakes = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->toEmail = $data['email'];
        $this->listCakes = $data['cakes'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('max_execution_time', '0');#adicionado somente para testes, essa é uma configuração que deve ser feita no php
        Mail::to($this->toEmail)->send(new \App\Mail\SendMail($this->listCakes));
    }
}
