<?php
//Class that represents a Game
class Game {
	public $playingField;
	public $players;

	public function __construct(){
		$this->playingField = new PlayingField();
		$this->players[] = new Player();
		$this->players[] = new Player();
		$this->players[0]->isMyTurn = true;
		$this->players[1]->isMyTurn = true;
		$this->players[0]->drawCard();
	}
}

//Class that represents a Player
class Player {
	public $deck;
	public $hand;
	public $discard;
	public $arena;
	public $avatar;
	public $isMyTurn;

	public function __construct(){
		$this->deck = new Deck();
		$this->arena = new Arena();
		$this->discard = new Discard();
		$this->hand = new Hand();
		$this->avatar = new Avatar();
		$this->isMyTurn = false;
	}

	//Plays a card from Hand. Applies any effects (eventually)
	public function playCard($cardId){
		$card = $this->hand->find($cardId);
		if($card && $this->isMyTurn){
			$this->hand->pop($card);
			$this->arena->push($card);
		}
	}

	//Draws a new card from Deck
	public function drawCard(){
		if($this->isMyTurn){
			$card = $this->deck->draw();
			if($card){
				$this->hand->push($card);
			}
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

//Class that represents an Avatar
class Avatar {
	protected $currentHP;
	protected $maxHP;
	protected $currentMP;
	protected $maxMP;
	public $class; 

	public function __construct(){
		$classes = array('Warrior', 'Mage', 'Thief', 'Cleric');
		shuffle($classes);
		$this->maxHP = rand(22,30);
		$this->currentHP = $this->maxHP;
		$this->maxMP = rand(8,10);
		$this->currentMP = 0;
		$this->class = $classes[0];
	}
}