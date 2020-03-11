<?php


namespace Tests\Unit;

use App\Http\Controllers\HandRankingSystemController;
use Tests\TestCase;


class CardsTest extends TestCase
{
    /**
     *
     */
    public function testRankingCardsByNumberLowerA()
    {
        $ranking = new HandRankingSystemController(1);
        $hand = ["A", "2", "3", "4", "5"];
        $ranked_hand = $ranking->rankingCardsByNumber($hand);
        $this->assertEquals(["1", "2", "3", "4", "5"], $ranked_hand);
    }

    /**
     *
     */
    public function testRankingCardsByNumberHighestA()
    {
        $ranking = new HandRankingSystemController(1);
        $hand = ["A", "K", "2", "3", "5"];
        $ranked_hand = $ranking->rankingCardsByNumber($hand);
        $this->assertEquals(["14", "13", "2", "3", "5"], $ranked_hand);
    }
}
