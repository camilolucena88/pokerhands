<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Support\Facades\DB;

class HandRankingSystemController extends Controller
{
    /**
     * @var
     */
    public $score;
    /**
     * @var array
     */
    private $cardRanking;
    /**
     * @var array
     */
    private $suits;
    /**
     * @var
     */
    private $round_id;
    /**
     * @var bool
     */
    public $ranked_hand;

    /**
     * HandRankingSystemController constructor.
     * @param $round_id
     */
    public function __construct($round_id)
    {
        $this->cardRanking = $this->toArray(DB::table('cards')
            ->select(DB::raw("SUBSTRING(card, 1, 1) AS cardRanking"))
            ->groupBy('cardRanking')
            ->get(), 'cardRanking');
        $this->suits = $this->toArray(DB::table('cards')
            ->select(DB::raw("SUBSTRING(card, 2, 1) AS suits"))
            ->groupBy('suits')
            ->get(), 'suits');
        $this->round_id = $round_id;
    }

    /**
     * Get all the scores following the Hand Ranking
     *
     * @param $hand
     * @return $this
     */
    public function getScore($hand)
    {
        $card = new CardController();
        $this->ranked_hand = $this->rankingCardsByNumber($card->getRankCardById($hand));
        arsort($this->ranked_hand);
        $this->score = 0;
        if ($this->isRoyalFlush($hand)) {
            $this->score = 10;
            return $this;
        } elseif ($this->isStraightFlush($hand)) {
            $this->score = 9;
            return $this;
        } elseif ($this->isFourOfKind($hand)) {
            $this->score = 8;
            return $this;
        } elseif ($this->isFullHouse($hand)) {
            $this->score = 7;
            return $this;
        } elseif ($this->isFlush($hand)) {
            $this->score = 6;
            return $this;
        } elseif ($this->isStraight($hand)) {
            $this->score = 5;
            return $this;
        } elseif ($this->isThreeOfKind($hand)) {
            $this->score = 4;
            return $this;
        } elseif ($this->isTwoPair($hand)) {
            $this->score = 3;
            return $this;
        } elseif ($this->isOnePair($hand)) {
            $this->score = 2;
            return $this;
        }
        return $this;
    }

    /**
     * Check both if it is straight collection of cards and if it is not Straight Flush to avoid bad scoring
     *
     * @param  array  $hand
     * @return bool
     */
    public function isStraight($hand)
    {
        if ($this->checkStraight($hand) && !$this->isStraightFlush($hand)) {
            return true;
        }
        return false;
    }

    /**
     * Check if the numbers are straight/in order one after the other
     *
     * @param $hand
     * @return bool
     */
    public function checkStraight($hand)
    {
        $card = new CardController();
        $ranked_hand = $this->rankingCardsByNumber($card->getRankCardById($hand));
        if (sort($ranked_hand)) {
            if ($this->checkConsecutiveCards($ranked_hand)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check both if it is straight collection of cards, example (3,4,5,6,7) and if it is flush, this means the same
     * suit.
     *
     * @param  array  $hand
     * @return bool
     */
    public function isStraightFlush(array $hand)
    {
        if ($this->checkStraight($hand) && $this->checkFlush($hand) && !$this->isRoyalFlush($hand)) {
            return true;
        }
        return false;
    }

    /**
     * Check if the hand is a Royal Flush, this means last 5 values (10,J,Q,K,A) with a same suit.
     * Convert Hand into $ranked_hand to be able to check the consecutive numbers (Convert from T,J,Q... -> 10,11,12...)
     * Check also, if it is royal, this means that it will check if the sum is the following 10+11+12+13+14 = 60.
     *
     * @param  array  $hand
     * @return bool
     */
    public function isRoyalFlush(array $hand)
    {
        $card = new CardController();
        $ranked_hand = $this->rankingCardsByNumber($card->getRankCardById($hand));
        if (sort($ranked_hand)) {
            if ($this->checkConsecutiveCards($ranked_hand, true) && $this->checkFlush($hand)) {
                return true;
            }
        }
        return false;
    }

    /**
     * In order to make easier the ranking system, the rank system will give a number to each card independently of
     * their own suit.
     *
     * @param  array  $rank_hands
     * @return array
     */
    public function rankingCardsByNumber(array $rank_hands)
    {
        foreach ($rank_hands as $key => $card_number) {
            if (!intval($card_number)) {
                switch ($card_number) {
                    case 'T':
                        $rank_hands[$key] = "10";
                        break;
                    case 'J':
                        $rank_hands[$key] = "11";
                        break;
                    case 'Q':
                        $rank_hands[$key] = "12";
                        break;
                    case 'K':
                        $rank_hands[$key] = "13";
                        break;
                    case 'A':
                        if ($this->inArrayOfAnArray(array("2", "3", "4", "5"), $rank_hands)) {
                            $rank_hands[$key] = "1";
                        } else {
                            $rank_hands[$key] = "14";
                        }
                        break;
                }
            }
        }
        return $rank_hands;
    }

    /**
     * Get an array and compare if the numbers into that array are all into the main array
     *
     * @param $array_to_compare
     * @param $main_array
     * @return bool
     */
    public function inArrayOfAnArray($array_to_compare, $main_array)
    {
        foreach ($array_to_compare as $value_to_check) {
            if (!in_array($value_to_check, $main_array)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if the Cards are consecutive one after the other
     *
     * @param $hand
     * @param  bool  $check_royal
     * @return bool
     */
    public function checkConsecutiveCards($hand, $check_royal = false)
    {
        for ($i = 0; $i < count($hand); $i++) {
            $next_value = isset($hand[$i + 1]);
            if ($next_value && ($hand[$i] + 1 != $hand[$i + 1])) {
                return false;
            }
        }
        if (array_sum($hand) == 60 && $check_royal) {
            return true;
        } elseif ($check_royal) {
            return false;
        }
        return true;
    }

    /**
     * 4 of Kind check
     *
     * @param $hand
     * @return bool
     */
    public function isFourOfKind($hand)
    {
        if ($this->checkDuplicatePairsByCount($hand, 1, 4)) {
            return true;
        }
        return false;
    }

    /**
     * 3 of Kind check
     *
     * @param $hand
     * @return bool
     */
    public function isThreeOfKind($hand)
    {
        if ($this->checkDuplicatePairsByCount($hand, 1, 3)) {
            return true;
        }
        return false;
    }

    /**
     * 2 Pairs check
     *
     * @param $hand
     * @return bool
     */
    public function isTwoPair($hand)
    {
        if ($this->checkDuplicatePairsByCount($hand, 2, 4)) {
            return true;
        }
        return false;
    }

    /**
     * One Pair Check
     *
     * @param $hand
     * @return bool
     */
    public function isOnePair($hand)
    {
        if ($this->checkDuplicatePairsByCount($hand, 1, 2)) {
            return true;
        }
        return false;
    }

    /**
     * Full house Check
     *
     * @param $hand
     * @return bool
     */
    public function isfullHouse($hand)
    {
        if ($this->checkDuplicatePairsByCount($hand, 2, 5)) {
            return true;
        }
        return false;
    }

    /**
     * Check if there are duplicates with helpers (cound and sum)
     *
     * @param $hand
     * @param $count
     * @param $sum
     * @return bool
     */
    public function checkDuplicatePairsByCount($hand, $count, $sum)
    {
        $card = new CardController();
        $rankCards = $this->array_count_duplicate($card->getRankCardById($hand));
        if (count($rankCards) == $count && array_sum($rankCards) == $sum) {
            return true;
        }
        return false;
    }

    /**
     * Helper to check for duplicates
     *
     * @param $rankCards
     * @return array
     */
    public function array_count_duplicate($rankCards)
    {
        $similarHand = [];
        foreach (array_count_values($rankCards) as $key => $similarCards) {
            if ($similarCards > 1) {
                $similarHand[$key] = $similarCards;
            }
        }
        return $similarHand;
    }

    /**
     * Get if it is flush, checking that it is not Straight Flush or Royal Flush
     *
     * @param $hand
     * @return bool
     */
    public function isFlush($hand)
    {
        if ($this->checkFlush($hand) && !$this->isStraightFlush($hand) && !$this->isRoyalFlush($hand)) {
            return true;
        }
        return false;
    }

    /**
     * Only check General Flush
     *
     * @param $hand
     * @return bool
     */
    public function checkFlush($hand)
    {
        $card = new CardController();
        if ($this->areCardsAllSameSuit($card->getSuitById($hand))) {
            return false;
        }
        return true;
    }

    /**
     * Get if are the same suit
     *
     * @param $suits
     * @return bool
     */
    public function areCardsAllSameSuit($suits)
    {
        if (count(array_unique($suits)) > 1) {
            return true;
        }
        return false;
    }

    /**
     * Convert and Object into an array with certain keys
     *
     * @param $objs
     * @param $key
     * @return array
     */
    public function toArray($objs, $key)
    {
        $new_array = [];
        foreach ($objs as $obj) {
            $new_array[] = $obj->$key;
        }
        return $new_array;
    }
}
