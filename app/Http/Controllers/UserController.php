<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Hash;
use Storage;
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
     * View user avatar and upload new avatar.
     *
     * @return \Illuminate\Http\Response
     */
    public function avatar($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();

        return response()->file(storage_path() .'/app/'. $user->avatar_path);
    }

    /**
     * Upload post photo.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadAvatar(Request $request, $id)
    {
        $user = User::where('id', $request->user()->id)->first();

        if($user->avatar_path)
        {
            Storage::delete($user->avatar_path);
        }

        $path = Storage::putFileAs('avatars', $request->file('file'), $request->user()->id);

        $user->avatar_path = $path;

        $user->save();

        return $user->avatar_path;
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
        $user = User::where('id', $request->user()->id)->with('department', 'account', 'immediateSupervisor', 'roles')->first();

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
