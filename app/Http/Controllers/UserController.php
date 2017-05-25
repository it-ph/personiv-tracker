<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use Hash;
use App\User;
use App\Notification;
use App\Traits\Enlist;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;

class UserController extends Controller
{
    use Enlist;
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
     * Reset to default password.
     *
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request, User $user)
    {
      $this->authorize('update', $user);
      $user->password = bcrypt('!welcome10');
      $user->save();
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
        $user = User::where('id', $request->user()->id)->with('department', 'immediateSupervisor', 'roles', 'subordinates')->first();

        $user->unread_notifications = $user->unreadNotifications;

        return $user;
    }

    /**
     * Display a listing of the resource with parameters.
     *
     * @return \Illuminate\Http\Response
     */
     public function enlist(Request $request)
     {
       $this->model = User::query();

       if($request->has('withTrashed'))
       {
         $this->model->withTrashed();
       }

       $this->populate($request);

       if($request->first)
       {
           return $this->model->first();
       }

       if($request->paginate)
       {
           return $this->model->paginate($request->paginate);
       }

       return $this->model->get();
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
    public function store(StoreUser $request)
    {
        $user = new User;
        $user->checkDuplicate();
        $user->prepare();
        $user->save();

        return $user->id;
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
    public function update(UpdateUser $request, User $user)
    {
        $user->checkDuplicate();
        $user->prepare();
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
    }
}
