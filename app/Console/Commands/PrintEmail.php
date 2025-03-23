<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
class PrintEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'print:email {email} {phone}{--M|mmm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print My Email';

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
     * @return int
     */
    public function handle()
    {
        // $name = $this->confirm('is your name diana?');
        // dd($name);
        // $this->info('your name is '.$name);
        // $this->table(
        //     ['Name', 'Email'],
        //     User::all(['name', 'email'])->toArray()
        // );
$users =User::all();

$bar = $this->output->createProgressBar(count($users));

$bar->start();

foreach ($users as $user) {
    $this->info($user->name);
    $this->newLine();
    $bar->advance();
}

$bar->finish();
    }
}
