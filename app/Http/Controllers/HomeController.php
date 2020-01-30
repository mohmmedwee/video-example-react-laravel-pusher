<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Pusher\Pusher;
use Pusher\PusherException;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function authinticate(Request $request){
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;
        try {
            $pusher = new Pusher('a2adf1e44433ecf0d2e4', 'c689c3bd8ef7717abc17', '940006', [
                'cluster' => 'ap2',
                'encrypted' => true,
                'useTLS' => true

            ]);

            $presence_data= ['name'=>auth()->user()->name];
            $key= $pusher->presence_auth($channelName,$socketId,auth()->id(),$presence_data);
            return response($key);
        } catch (PusherException $e) {
            die(1);
        }

    }
}
