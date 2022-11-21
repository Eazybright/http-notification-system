<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class NotifySubscribersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:subscriber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $topic = $this->ask('Enter your topic');
        echo 'start listening for published post on '. $topic .' topic' . PHP_EOL;

        Redis::subscribe($topic, function ($payload) {
          echo 'message received!' . PHP_EOL;
          // $blog = json_decode($payload);
          // $users = [
          //     [
          //         "name" => "John Doe",
          //         "email" => "jon@gmail.com",
          //         "topics" => ['sports', 'food']
          //     ],
          //     [
          //         "name" => "Jane Doe",
          //         "email" => "jane@gmail.com",
          //         "topics" => ['sports', 'fashion']
          //     ]
          // ];
          // foreach ($users as $user) {
          //     foreach ($user['topics'] as $topic) {
          //         if ($blog->topic === $topic) {
          //             echo 'New blog on "' . $topic . '" for "' . $user['name'] . '" with title => "' . $blog->title . PHP_EOL;
          //         }
          //     }
          // }
          var_dump($payload);
      });
    }
}
