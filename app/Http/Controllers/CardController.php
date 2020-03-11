<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    /**
     * Get the ID of each card and return the hands with IDs
     *
     * @param $hand
     * @return mixed
     */
    public function getHandIdByCard($hand)
    {
        foreach ($hand as $key => $card){
            $hand[$key] = Card::where('card',$card)->first()->id;
        }
        return $hand;
    }


    /**
     * Get the suits of each card with the IDs and return the hands with suits only
     *
     * @param $hand
     * @return mixed
     */
    public function getSuitById($hand)
    {
        foreach ($hand as $key => $card_id){
            $hand[$key] = DB::table('cards')
                ->select(DB::raw("SUBSTRING(card, 2, 1) AS suits"))
                ->where('id',$card_id)
                ->first()->suits;
        }
        return $hand;
    }

    /**
     * Get the ranking number of each card and return the hands with these ranking numbers only
     *
     * @param $hand
     * @return mixed
     */
    public function getRankCardById($hand)
    {
        foreach ($hand as $key => $card_id){
            $hand[$key] = DB::table('cards')
                ->select(DB::raw("SUBSTRING(card, 1, 1) AS rank"))
                ->where('id',$card_id)
                ->first()->rank;
        }
        return $hand;
    }
}
