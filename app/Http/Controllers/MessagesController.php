<?php

namespace App\Http\Controllers;
// use App\User;

use App\Models\MessageImage;
use App\Models\User;
use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MessagesController extends Controller
{
    /**
     * Show all of the message threads to the user.
     *
     * @return mixed
     */
    public function index()
    {
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();
        // return $threads;
        // All threads that user is participating in
        // $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();
        $threads = Thread::inbox(Auth::id())->latest('updated_at')->get();
        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();
        return view('messenger.index', compact('threads'));
    }
    public function outbox()
    {
        // All threads, ignore deleted/archived participants
        // $threads = Thread::getAllLatest()->get();
        // return $threads;
        // All threads that user is participating in
        // $threads = Thread::forUser(Auth::id())->latest('updated_at')->get();
        $threads = Thread::outbox(Auth::id())->latest('updated_at')->get();
        // All threads that user is participating in, with new messages
        // $threads = Thread::forUserWithNewMessages(Auth::id())->latest('updated_at')->get();
        return view('messenger.index', compact('threads'));
    }

    /**
     * Shows a message thread.
     *
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $thread = Thread::find($id);
        $messages = $thread->messages; // Retrieve all messages related to the thread

        // return $messages;
        $previousUrl = url()->previous();

        // Match the previous URL to a route
        $previousRoute = app('router')->getRoutes()->match(app('request')->create($previousUrl));

        // Get the name of the previous route
        $routeName = $previousRoute->getName();


        // Get the name of the current route
        // $routeName = \Route::currentRouteName();

        // Check the route and return the corresponding view
        // return $routeName;



        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('messages');
        }

        // show current user in list if not a current participant
        // $users = User::whereNotIn('id', $thread->participantsUserIds())->get();

        // don't show the current user in list
        $userId = Auth::id();
        $users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

        $thread->markAsRead($userId);

        // return $thread;
        // $galleryImages = MessageImage::where('thread_id', $thread->id)->get();


        if ($routeName == 'messages.index') {
            return view('messenger.inbox.show', compact('thread', 'users',  'messages'));
        } elseif ($routeName == 'messages.outbox') {
            return view('messenger.outbox.show', compact('thread', 'users',  'messages'));
        } else {
            // Fallback or error view
            return abort(404);
        }

        // return view('messenger.show', compact('thread', 'users','galleryImages'));
    }

    /**
     * Creates a new message thread.
     *
     * @return mixed
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        return view('messenger.create', compact('users'));
    }

    /**
     * Stores a new message thread.
     *
     * @return mixed
     */
    public function store(Request $request)
    {
        // $input = Request::all();

        // return $request;
        // return $request->input('bcc');
        if ($request->has('bcc')) {
            // return $request->input('bcc');
            // Step 1: Get the Bcc string from the request
            $bccJson = $request->input('bcc'); // This should be a JSON string
            $bccArray = json_decode($bccJson, true); // Decode JSON to PHP array

            // Now you should have an array of objects
            $emails = array_map(function ($item) {
                return $item['value']; // Extract the email from each object
            }, $bccArray);

            // return $emails;

            // Step 4: Retrieve user IDs corresponding to the email addresses
            $recipients = User::whereIn('email', $emails)->pluck('id')->toArray();

            // return $recipients;
            // Step 5: Store the user IDs in the request's 'recipients' field
            $request->merge(['recipients' => $recipients]);

            // Now you can access $request->recipients as an array of user IDs
        }

        // return $request->input('recipients');

        $thread = Thread::create([
            'subject' => $request->subject,
        ]);

        // Message
        $message = Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->message,
        ]);

        // Sender
        Participant::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'last_read' => new Carbon(),
        ]);

        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant($request->recipients);
        }
        if ($request->hasfile('inspiration_images')) {

            foreach ($request->file('inspiration_images') as $file) {
                $extention = $file->getClientOriginalExtension();
                $imageName = rand() . '.' . $extention;
                $directory = 'assets/frontend/message/inspiration-images/';
                $imageUrl = $directory . $imageName;
                // session()->push('galleryImage', $imageUrl);
                $file->move($directory, $imageName);
                $image = MessageImage::create(
                    [
                        'message_id' => $message->id,
                        'thread_id' => $thread->id,
                        'image_url' => $imageUrl,
                    ]
                );

                // $name = time() . '_' . $file->getClientOriginalName();
                // // return $name;
                // // Store the file in the public storage
                // $path = $file->storeAs('public/inspiration_images', $name);
                // // Add the file path to the array
                // $imagePaths[] = Storage::url($path);

            }
        }

        return redirect()->route('messages.index')->with('message', 'Mail sent successfully!');
    }

    public function autocomplete(Request $request)
    {
        $query = $request->get('term', '');

        $emails = User::where('email', 'LIKE', '%' . $query . '%')->pluck('email');

        return response()->json($emails);
    }

    public function reply(Thread $id, Request $request)
    {
        // return $id;
        // $input = Request::all();

        // return $request;
        // $thread = Thread::create([
        //     'subject' => $id->subject,
        // ]);

        // $thread = Thread::find($id);
        // return $thread;
        // $messages = $thread->messages; // Retrieve all messages related to the thread


        // Message
        $message = Message::create([
            'thread_id' => $id->id,
            'user_id' => Auth::id(),
            'body' => $request->message,
        ]);
        // $thread->messages()->save($message);

        // Sender
        // Participant::create([
        //     'thread_id' => $id->id,
        //     'user_id' => Auth::id(),
        //     'last_read' => new Carbon(),
        // ]);

        if ($request->hasfile('inspiration_images')) {

            foreach ($request->file('inspiration_images') as $file) {
                $extention = $file->getClientOriginalExtension();
                $imageName = rand() . '.' . $extention;
                $directory = 'assets/frontend/message/inspiration-images/';
                $imageUrl = $directory . $imageName;
                // session()->push('galleryImage', $imageUrl);
                $file->move($directory, $imageName);
                $image = MessageImage::create(
                    [
                        'message_id' => $message->id,
                        'thread_id' => $id->id,
                        'image_url' => $imageUrl,
                    ]
                );
            }
        }

        // Recipients
        if ($request->has('recipients')) {
            $id->addParticipant($request->recipients);
        }

        return redirect()->route('messages.index');
    }

    /**
     * Adds a new message to a current thread.
     *
     * @param $id
     * @return mixed
     */
    public function update($id, Request $request)
    {
        try {
            $thread = Thread::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            Session::flash('error_message', 'The thread with ID: ' . $id . ' was not found.');

            return redirect()->route('messages');
        }

        $thread->activateAllParticipants();

        // Message
        Message::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'body' => $request->message,
        ]);

        // Add replier as a participant
        $participant = Participant::firstOrCreate([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
        ]);

        $participant->last_read = new Carbon();
        $participant->save();

        // Recipients
        if ($request->has('recipients')) {
            $thread->addParticipant($request->recipients);
        }

        return redirect()->route('messages.show', $id);
    }
}
