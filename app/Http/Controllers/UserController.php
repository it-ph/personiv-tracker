<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Hash;
use App\User;
use App\Notification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Mark notifications as read.
     *
     * @return void
     */
    public function markAsRead(Request $request)
    {
        $notification = Notification::find($request->id);

        if($notification->notifiable_id != $request->user()->id)
        {
            abort(403, 'Unauthorized action.');
        }

        Notification::where('id', $request->id)->update(['read_at' => Carbon::now()]);
    }

    /**
     * Mark all notifications as read.
     *
     * @return void
     */
    public function markAllAsRead(Request $request)
    {
        $user = User::find($request->user()->id);

        $user->unreadNotifications()->update(['read_at' => Carbon::now()]);
    }

    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        Auth::logout();
    }

    public function checkDefaultPassword(Request $request)
    {
        return response()->json(Hash::check('!welcome10', $request->user()->password));
    }

    /**
     * Changes the password of the authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        if($request->new == $request->confirm && $request->old != $request->new)
        {
            $user->password = Hash::make($request->new);
        }

        $user->save();
    }

    /**
     * Check if the input password of user is same with current password.
     *
     * @return bool
     */
    public function verifyPassword(Request $request)
    {
        return response()->json(Hash::check($request->old, $request->user()->password));
    }

    /**
     * Checks authenticated user.
     *
     * @return \Illuminate\Http\Response
     */
    public function check(Request $request)
    {
        $user = User::where('id', $request->user()->id)->with('department', 'immediateSupervisor', 'roles')->first();

        $user->unread_notifications = $user->unreadNotifications;

        return $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
