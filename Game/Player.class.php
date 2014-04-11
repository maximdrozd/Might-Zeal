<?php
require_once("System/Config.class.php");
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
		if($card && $this->arena->size() < Config::MAX_ARENA_SIZE){
			$this->hand->remove($card);
			$this->arena->add($card);
			//TODO: call card play callback
		}
	}

	public function drawCard(){
		$card = $this->deck->draw();
		if($card && $this->hand->size() < Config::MAX_HAND_SIZE){
			$this->hand->add($card);
		}
	}

	public function reshuffleDeck(){
		foreach ($this->discard->getAll() as $card) {
			$this->discard->remove($card);
			$this->deck->add($card);
		}
		$this->deck->mix();
	}

	public function returnCardToHand($cardId){
		$this->moveCard($cardId, $this->arena, $this->hand);
	}

	public function returnCardToDeck($cardId){
		$this->moveCard($cardId, $this->arena, $this->deck);
	}

	public function discardCardFromHand($cardId){
		$this->moveCard($cardId, $this->hand, $this->discard);
	}

	public function discardCardFromArena($cardId){
		$this->moveCard($cardId, $this->arena, $this->discard);
	}

	private function moveCard($cardId, &$from, &$to){
		$card = $from->find($cardId);
		if($card){
			$from->remove($card);
			$to->add($card);
		}
	}
}