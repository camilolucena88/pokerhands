<?php


namespace Tests\Unit;


use App\Http\Controllers\CardController;
use App\Http\Controllers\HandRankingSystemController;
use Tests\TestCase;

class HandRankingTest extends TestCase
{
    /**
     *
     */
    public function testGetScore()
    {
        $hand = ['TC', 'JC', 'KC', 'QC', 'AC'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 10;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testRoyalFlush()
    {
        $hand = ['TC', 'JC', 'KC', 'QC', 'AC'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isRoyalFlush($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 10;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testStraightFlush()
    {
        $hand = ['6C', '2C', '3C', '4C', '5C'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isStraightFlush($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 9;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testFourOfKind()
    {
        $hand = ['6H', '6S', '6D', '6C', '5C'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isFourOfKind($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 8;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testFullHouse()
    {
        $hand = ['4H', '5S', '4D', '4C', '5C'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isFullHouse($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 7;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testFlush()
    {
        $hand = ['5D', '4D', 'KD', 'QD', '7D'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isFlush($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 6;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testStraight()
    {
        $hand = ['2H', '3D', '4D', '5D', '6D'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isStraight($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 5;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testThreeOfKind()
    {
        $hand = ['4H', '4S', 'TD', '4C', '5C'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isThreeOfKind($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 4;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testTwoPair()
    {
        $hand = ['4H', '5S', 'TD', '4C', '5C'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isTwoPair($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 3;
        self::assertEquals($expected_score,$rankHand->score);
    }

    /**
     *
     */
    public function testOnePair()
    {
        $hand = ['AH', '3D', '4D', '4S', '2S'];
        $card = new CardController();
        $ranking = new HandRankingSystemController(1);
        $hand_by_id = $card->getHandIdByCard($hand);
        $this->assertTrue($ranking->isOnePair($hand_by_id));
        $rankHand = $ranking->getScore($hand_by_id);
        $expected_score = 2;
        self::assertEquals($expected_score,$rankHand->score);
    }
}
