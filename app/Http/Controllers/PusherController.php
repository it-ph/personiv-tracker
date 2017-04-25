<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Pusher;

class PusherController extends Controller
{
    public function auth(Request $request)
    {
    	// key, secret, app_id
    	$pusher = new Pusher('f4ec05090428ca64a977', 'f621b2351b88f263d71f', '322869');
    	
    	echo $pusher->socket_auth($request->channel_name, $request->socket_id);
    }
}
