<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\SendingMessageRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Message;
use Illuminate\Http\Request;

use App\Http\Requests;
use Hash;

class ProfileController extends Controller
{
    private $user;
    
    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index()
    {
        $messages = Message::with('sender')
                ->where('user_id', auth()->user()->id)
                ->orderBy('created_at', 'DESC')
                ->get();

        $profile = $this->user;

        return view('profile.index', compact('profile', 'messages'));
    }

    public function block()
    {
        $this->user->active = 0;

        $this->user->save();

        return redirect('logout');
    }

    public function postMessage(SendingMessageRequest $request)
    {
        $request['sender_id'] = $this->user->id;

        Message::create($request->all());

        \Session::flash('success', 'Your Message sent successfully!!');

        return back();
    }

    public function update(ProfileUpdateRequest $request, $id)
    {
        $this->user->update($request->all());

        \Session::flash('success', 'Profile settings changed successfully!');

        return back();
    }

    public function updatePassword(PasswordChangeRequest $request, $id)
    {

        $this->user->password = $request->input('password');

        $this->user->save();

        \Session::flash('success', 'Your Password changed successfully. In future login with new password!');

        return back();
    }

    public function destroyMessage(Message $message)
    {
        $message->delete();

        return response()->json(['success' => 'Message Deleted!']);
    }

    public function inbox()
    {
        $messages = Message::with('sender')
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $profile = $this->user;

        return view('profile.inbox', compact('profile', 'messages'));
    }
}
