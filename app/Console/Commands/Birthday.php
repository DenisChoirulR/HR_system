<?php

namespace App\Console\Commands;
use App\user;
use App\event;

use Illuminate\Console\Command;

class Birthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:year';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Birthday event yearly';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = user::all();
        foreach ($user as $u) {
            event::create([
                'date' => date("Y") . date("-m-d",strtotime($u->birth_date)),
                'type' => "birthday",
                'title' => "birthday",
                'note' => "Happy Birthday",
                'user_id' => $u->id,
                'created_by' => $u->id
            ]);
        }
        return $user;
    }
}
