<?php

namespace App\Http\Controllers;

use App\Card;
use App\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HandController extends Controller
{
    /**
     * HandController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return array|void
     */
    public function create(Request $request)
    {
        $this->upload($request);
        $round = Round::all();
        return view('hands',['round' => $round]);
    }

    /**
     * Show the hands view to upload or to play.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $round = Round::all();
        return view('hands',['round' => $round]);
    }

     /**
     * Upload file with hands per player.
     *
     * @param  $request
     * @return void
     */
    public function upload($request)
    {
        $hands = $this->validateHand($request);
        $hand = new RoundController();
        $hand->create($hands);
    }


    /**
     * Validate file input before store it.
     *
     * TODO: Check if the hands are valid or if there are other values that are not valid
     *
     * @param  $request
     * @return array|void
     */
    public function validateHand($request)
    {
        $hands = File::get($request->file('hands'));
        return $this->decode($hands);
    }

    /**
     * Decode the file, in order to delete spaces and to check if which id are.
     *
     * @param $hands
     * @return array
     */
    public function decode($hands)
    {
        $cards = preg_split("/[\s.]+/", $hands);
        $cards_decoded = [];
        foreach ($cards as $key => $card){
            if(!empty($card))
                $cards_decoded[] = Card::where('card','=',$card)->first()->id;
        }
        return $cards_decoded;
    }

    /**
     * Run the rounds and get the winner, after return the view.
     *
     * @param  Request  $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function play(Request $request)
    {
        $rounds = Round::all();
        $user_id = Auth::user()->id;
        $system = DB::table('users')->where('name', 'system')->first()->id;
        foreach ($rounds as $round){
            $hand_player_1 = $this->getHandsPerPlayer($round, $user_id);
            $hand_player_2 = $this->getHandsPerPlayer($round, $system);
            $win = new WinController($round->id);
            $win->getWinner($hand_player_1,$hand_player_2);
        }
        return view('home');
    }

    /**
     * Get player 1 and player 2 rounds and return hands
     *
     * @param $round
     * @param $player_id
     * @return array
     */
    public function getHandsPerPlayer($round,$player_id)
    {
        $cards = DB::table('hands')
            ->where('round_id', $round->id)
            ->where('user_id', $player_id)
            ->take(5)
            ->get();
        foreach ($cards as $card){
            $hand[] = $card->card_id;
        }
        sort($hand);
        return $hand;
    }
}
