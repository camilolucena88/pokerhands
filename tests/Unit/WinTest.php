<?php


namespace Tests\Unit;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HandRankingSystemController;
use App\Http\Controllers\WinController;
use Tests\TestCase;


class WinTest extends TestCase
{
    /**
     *
     */
    public function testGetWinner()
    {
        $credential = [
            'email' => 'camilolucena88@gmail.com',
            'password' => 'password'
        ];
        $response = $this->post('login',$credential);
        $response->assertSessionHasNoErrors();
        $ranking = new CardController();
        $hand_player_1 = [
            ['TC', 'JC', 'KC', 'QC', 'AC'],
            ['6H', '6S', '6D', '6C', '5C'],
            ['4H', '5S', '4D', '4C', '5C'],
            ['5D', '4D', '2D', '3D', '7D'],
            ['2H', '3D', '4D', '5D', '6D'],
            ['4H', '4S', 'TD', '4C', '5C'],
            ['4H', '5S', 'TD', '4C', '5C'],
            ['AH', '3D', '4D', '4S', '2S'],
            ];
        $hand_player_2 = ['2C', '3S', '7H', '4C', '5C'];
        $hand_player_2 = $ranking->getHandIdByCard($hand_player_2);
        $round = 0;
        foreach ($hand_player_1 as $hands) {
            $round = $round+1;
            $new_hand_player_1 = $ranking->getHandIdByCard($hands);
            $win = new WinController($round);
            $win->getWinner($new_hand_player_1,$hand_player_2);
            $this->assertDatabaseHas('wins', [
                'round_id' => $round,
                'user_id' => 2
            ]);
        }
    }

    /**
     *
     */
    public function testTieBreaker()
    {
        $credential = [
            'email' => 'camilolucena88@gmail.com',
            'password' => 'password'
        ];
        $response = $this->post('login',$credential);
        $response->assertSessionHasNoErrors();
        $player_1_hand = [10,6,5,4,2];
        $player_2_hand = [9,6,5,4,3];
        $score_player_1 = 2;
        $score_player_2 = 2;
        $win = new WinController(1);
        $win->tieBreaker($player_1_hand,$player_2_hand,$score_player_1,$score_player_2);
        $this->assertDatabaseHas('wins', [
            'round_id' => 1,
            'user_id' => 2
        ]);
    }
}
