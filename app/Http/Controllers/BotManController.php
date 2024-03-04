<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
// use App\Bot\Conversations\WelcomeConversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class BotManController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
        $botman->hears('{message}', function (BotMan $bot) {
            // dd($bot);
            // $bot->reply('Hi, welcome to our platform!');
            $this->askForOptions($bot);
        });

        // $botman->hears('{message}', function ($botman, $message) {
        //     // if ($message == '') {
        //     // } else {
        //     //     $botman->replay('write hi');
        //     // }
        // });
        // $botman->startConversation(new WelcomeConversation());

        $botman->listen();
    }

    protected function askForOptions(BotMan $bot)
    {
        $bot->ask('Please select an option:', function (IncomingMessage $message) use ($bot) {
            dd($message);
            $selectedOption = $message->getText();
            // Process the selected option and reply with related links or options
            // Example logic:
            switch ($selectedOption) {
                case 'Option 1':
                    $bot->reply('Here are the links related to Option 1...');
                    break;
                case 'Option 2':
                    $bot->reply('Here are the links related to Option 2...');
                    break;
                    // Add more cases for other options...
                default:
                    $bot->reply('Invalid option. Please select again.');
            }
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
