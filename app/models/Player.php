<?php
namespace Game\Models;

use Game\System\Config;
use Game\System\Exceptions\CardNotFoundException;
use Game\Utils\Tokenizer;

class Player {
	public $deck;
	public $hand;
	public $discard;
	public $arena;
	public $avatar;
	public $name;
	public $token;

	public function __construct($parameterMap){
		$this->deck = new Deck();
		$this->arena = new Arena();
		$this->discard = new Discard();
		$this->hand = new Hand();
		$this->avatar = new Avatar();
		$this->name = initWithVar("name", $parameterMap, "Name");
		$this->token = Tokenizer::generateToken();
	}

	public function triggerTurnStart(){
		$this->avatar->triggerTurnStart();
		$this->drawCard();
		$this->arena->triggerTurnStart();
	}

	public function activateCard($cardId, $target = null){
		try {
			$card = $this->arena->find($cardId);
			//apply card effects here
			//TODO: do something with target
			$card->canAct = false;
		} catch (CardNotFoundException $e) {
			//toast a message
		}
	}

	public function playCard($cardId, $target = null){
		try {
			$card = $this->hand->find($cardId);
			if ($this->arena->size() < Config::MAX_ARENA_SIZE) {
				$this->hand->remove($card); //remove card from hand
				$this->arena->add($card); //move card to arena
				//TODO: pay the cost of the card
				//TODO: call card play callback
			} else {
				//TODO: toast warning for hand size limit
			}
		} catch (CardNotFoundException $e) {
			//TODO: toast warning for card not found
			echo $e->getMessage();
		}
	}

	public function drawCard(){
		$card = $this->deck->draw();
		if (is_object($card) && $this->hand->size() < Config::MAX_HAND_SIZE) {
			$this->deck->remove($card);
			$this->hand->add($card);
		} else {
			//TODO: toast warning for hand size limit
		}
	}

	public function reshuffleDeck(){
		foreach ($this->discard->getAll() as $card) {
			$this->discard->remove($card);
			$this->deck->add($card);
		}
		return $this->deck->mix();
	}

	public function returnCardToHand($cardId){
		return $this->moveCard($cardId, $this->arena, $this->hand);
	}

	public function returnCardToDeck($cardId){
		return $this->moveCard($cardId, $this->arena, $this->deck);
	}

	public function discardCardFromHand($cardId){
		return $this->moveCard($cardId, $this->hand, $this->discard);
	}

	public function discardCardFromArena($cardId){
		return $this->moveCard($cardId, $this->arena, $this->discard);
	}

	private function moveCard($cardId, &$from, &$to){
		try {
			$card = $from->find($cardId);
			$from->remove($card);
			$to->add($card);
		} catch (CardNotFoundException $e) {
			// TODO: toast warning for card not found
		}
		return ReturnCodes::OK;
	}
}
