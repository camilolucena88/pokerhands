<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WinController extends Controller
{
    /**
     * @var
     */
    private $round_id;

    /**
     * WinController constructor.
     * @param $round_id
     */
    public function __construct($round_id)
    {
        $this->round_id = $round_id;
    }

    /**
     * Get the winner of each round and store it on the database if it is a win
     *
     * @param $hand_1
     * @param $hand_2
     */
    public function getWinner($hand_1, $hand_2)
    {
        $rankings = new HandRankingSystemController($this->round_id);
        $score_1 = $rankings->getScore($hand_1);
        $score_player_1 = $score_1->score;
        $ranked_hand_player_1 = $score_1->ranked_hand;
        $score_2 = $rankings->getScore($hand_2);
        $score_player_2 = $score_2->score;
        $ranked_hand_player_2 = $score_2->ranked_hand;
        $this->playerOneWon($score_player_1,$score_player_2,$ranked_hand_player_1,$ranked_hand_player_2);
    }

    /**
     * Store the values or get the Tie Breaker
     *
     * @param $score_player_1
     * @param $score_player_2
     * @param $ranked_hand_player_1
     * @param $ranked_hand_player_2
     */
    public function playerOneWon($score_player_1,$score_player_2,$ranked_hand_player_1,$ranked_hand_player_2)
    {
        if($score_player_1 > $score_player_2){
            $win_array = [
                'round_id' => $this->round_id,
                'user_id' => Auth::user()->id,
                'score_player_1' => $score_player_1,
                'score_player_2' => $score_player_2,
            ];
            DB::table('wins')->insert([
                $win_array
            ]);
        }elseif($score_player_1 == $score_player_2) {
            $this->tieBreaker($ranked_hand_player_1,$ranked_hand_player_2,$score_player_1,$score_player_2);
        }
    }

    /**
     * Tie breaker for equal scores
     *
     * @param $player_1_hand
     * @param $player_2_hand
     * @param $score_player_1
     * @param $score_player_2
     * @return bool
     */
    public function tieBreaker($player_1_hand,$player_2_hand,$score_player_1,$score_player_2)
    {
        foreach ($player_1_hand as $key => $card){
            if($card > $player_2_hand[$key]){
                $win_array = [
                    'round_id' => $this->round_id,
                    'user_id' => Auth::user()->id,
                    'score_player_1' => $score_player_1,
                    'score_player_2' => $score_player_2,
                ];
                DB::table('wins')->insert([
                    $win_array
                ]);
                return true;
            }
        }
        return false;
    }
}
