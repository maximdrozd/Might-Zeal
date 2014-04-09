<?php
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

	public function __construct(){
		$this->deck = new Deck();
		$this->arena = new Arena();
		$this->discard = new Discard();
		$this->hand = new Hand();
		$this->avatar = new Avatar();
	}

	//Plays a card from Hand. Applies any effects (eventually)
	public function playCard($cardId){
		$card = $this->hand->find($cardId);
		if($card){
			$this->hand->pop($card);
			$this->arena->push($card);
		}
	}

	//Draws a new card from Deck
	public function drawCard(){
		$card = $this->deck->draw();
		if($card){
			$this->hand->push($card);
		}
	}

	public function reshuffleDeck(){
		foreach ($this->discard->getAll() as $card) {
			$this->discard->pop($card);
			$this->deck->push($card);
		}
		$this->deck->mix();
	}

	public function returnCardToHand(){

	}

	public function returnCardToDeck(){

	}

	public function discardCardFromHand(){

	}

	public function discardCardFromArena(){

	}
}