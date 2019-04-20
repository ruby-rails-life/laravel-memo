<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Project;
use App\User;
use App\Mail\ProjectCreatedMail;

class SendEmails extends Command
{
    /**
     * コンソールコマンドの名前と引数、オプション
     *
     * @var string
     */
    protected $signature = 'email:send
                           {user : The ID of the user}
                           {--queue= : Whether the job should be queued}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send e-mails to a user';

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
     * コンソールコマンドの実行
     *
     */
    public function handle()
    {
        // $name = $this->ask('What is your name?');
        // $password = $this->secret('What is the password?');
        // if ($this->confirm('Do you wish to continue?')) {
        //     //
        // }

        // $name = $this->anticipate('What is your name?', ['Grace', 'Tom']);
        // $name = $this->choice('What is your name?', ['Grace', 'Tom'], 0);

        //$this->info('Display this on the screen');
        //$this->error('Something went wrong!');
        //$this->line('Display this on the screen');

        $userId = $this->argument('user');
        $queueName = $this->option('queue');

        $user = User::find($userId);

        $headers = ['ProjectID', 'ProjectName'];
        $projects = Project::all(['id', 'project_name']);
        $array_projects = $projects->toArray();
        $this->table($headers, $array_projects);

        $bar = $this->output->createProgressBar(count($projects));

        $bar->start();

        foreach ($projects as $project) {
            //$this->performTask($project);
            //\Mail::to($user->email)->queue(new ProjectCreatedMail($project));
            \Mail::to($user->email)->send(new ProjectCreatedMail($project));

            $bar->advance();
        }

        $bar->finish();

    }
}
