<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use \App\Events\LiveScore as LiveScoreEvent;


class LiveScore extends Controller
{
    var $pusher;
    public function __construct()
    {
        //$this->pusher = Pusher;
    }

    public function getLiveScore(){

        $activity = [
            'text' => ' has visited the page',
            'username' => 'jam',
            'avatar' => 'sdsdfsd',
            'id' => '23333'
        ];

//        $result = $this->pusher->trigger('score-board', 'get-live-score', $activity);
        $result =  event(new LiveScoreEvent($activity));
        dd($result);
    }

    public function upcommingMatches(){

        try {
            $data = [
                'completedlimit' => 5,
                'inprogresslimit' => 5,
                'upcomingLimit' => 5
            ];
            $response = $this->get('matches.php',$data)->getResponse();


            $data = [
                'success' => true,
                'response'=> $response,
            ];
            return response($data);

        } catch (\Exception $exp){

            $data = [
                'success' => false,
                'data'=> [],
                'exception'=> $exp->getMessage(),
            ];
        }

    }
}
