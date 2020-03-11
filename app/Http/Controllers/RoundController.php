<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoundController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param $hands
     * @return void
     */
    public function create($hands)
    {
        foreach (array_chunk($hands, 10) as $hand){
            $round_id = DB::table('rounds')->insertGetId([
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $cards_player_1 = array_slice($hand, 0,5);
            foreach ($cards_player_1 as $card){
                DB::table('hands')->insert(
                    [
                        'round_id'=> $round_id,
                        'card_id' => $card,
                        'user_id' =>Auth::id(),
                    ]
                );
            }
            $cards_player_2 = array_slice($hand, 5,5);
            foreach ($cards_player_2 as $card){
                DB::table('hands')->insert(
                    [
                        'round_id'=> $round_id,
                        'card_id' => $card,
                        'user_id' => User::where('name','system')->first()->id,
                    ]
                );
            }
        }
        return redirect('/');
    }
}
