<?php
require_once("System/Config.class.php");
require_once("System/GameException.class.php");
require_once("DefaultRequires.php");
require_once("Hand.class.php");
require_once("Deck.class.php");
require_once("Discard.class.php");
require_once("Arena.class.php");
require_once("Avatar.class.php");

class Player {
	public $deck;
	public $hand;
	public $discard;
	public $arena;
	public $avatar;
	public $name;

	public function __construct($parameterMap){
		$this->deck = new Deck();
		$this->arena = new Arena();
		$this->discard = new Discard();
		$this->hand = new Hand();
		$this->avatar = new Avatar();
		$this->name = initWithVar("name", $parameterMap, "Name");
	}

	public function playCard($cardId){
		$card = $this->hand->find($cardId);
		if($card !== GameException::CARD_NOT_FOUND && $this->arena->size() < Config::MAX_ARENA_SIZE){
			$this->hand->remove($card);
			$this->arena->add($card);
			//TODO: call card play callback
		} else {
			if($card === GameException::CARD_NOT_FOUND){
				//TODO: toast warning for card not found
			} else {
				//TODO: toast warning for hand size limit
			}
		}
	}

	public function drawCard(){
		$card = $this->deck->draw();
		if($card !== GameException::CARD_NOT_FOUND && $this->hand->size() < Config::MAX_HAND_SIZE){
			$this->deck->remove($card);
			$this->hand->add($card);
		} else {
			if($card === GameException::CARD_NOT_FOUND){
				//TODO: toast warning for card not found
			} else {
				//TODO: toast warning for hand size limit
			}
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
		$card = $from->find($cardId);
		if($card !== GameException::CARD_NOT_FOUND){
			$from->remove($card);
			$to->add($card);
			return GameException::OK;
		}
		return GameException::CARD_NOT_FOUND;
	}
}