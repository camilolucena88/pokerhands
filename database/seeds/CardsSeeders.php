<?php

use Illuminate\Database\Seeder;

class CardsSeeders extends Seeder
{
    /**
     * Run the database seeds for the Poker Playing cards.
     *
     * @return void
     */
    public function run()
    {
        $card_suits = ['C','D','H','S'];
        foreach ($card_suits as $suit){
            $cards = [
                [
                    'card' => '2'.$suit,
                ],
                [
                    'card' => '3'.$suit,
                ],
                [
                    'card' => '4'.$suit,
                ],
                [
                    'card' => '5'.$suit,
                ],
                [
                    'card' => '6'.$suit,
                ],
                [
                    'card' => '7'.$suit,
                ],
                [
                    'card' => '8'.$suit,
                ],
                [
                    'card' => '9'.$suit,
                ],
                [
                    'card' => 'T'.$suit,
                ],
                [
                    'card' => 'J'.$suit,
                ],
                [
                    'card' => 'Q'.$suit,
                ],
                [
                    'card' => 'K'.$suit,
                ],
                [
                    'card' => 'A'.$suit,
                ],
            ];

            DB::table('cards')->insert($cards);
        }

    }
}
