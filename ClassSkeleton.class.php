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

//Class that represents a Playing Field
class PlayingField {
	public $environment;

	public function __construct(){
		$envs = array('desert', 'city', 'forest');
		shuffle($envs);
		$this->environment = $envs[0];
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

//Class that represents a Deck
class Deck extends CardCollection {
	public function __construct(){
		parent::__construct();
		for ($i=0; $i < 40; $i++) { 
			$this->push(new Card());
		}
	}

	public function draw(){
		if($this->size() > 0){
			$card = $this->cards[0];
			$this->pop($card);
			return $card;
		}
		return null;
	}
}

//Class that represents a Hand
class Hand extends CardCollection {
}

//Crass that represents an Arena
class Arena extends CardCollection {
}

//Class that represents a Discard
class Discard extends CardCollection {
}

//Class that represents a collection of cards
class CardCollection {
	protected $cards;

	public function __construct(){
		$this->cards = array();
	}

	//push card to collection
	public function push($element){
		array_push($this->cards, $element);
		return $element;
	}

	//pop card from collection
	public function pop($element){
		$card = $this->find($element);
		//also remove from $this->cards
		array_splice($this->cards, array_search($card, $this->cards, true), 1); // ???
	}

	//shuffle collection
	public function mix(){
		return shuffle($this->cards);
	}

	//find element by Card object or id
	public function find($element){
		foreach ($this->cards as $card) {
			if($card->match($element)){
				return $card;
			}
		}
		return null;
	}

	//get all cards
	public function getAll(){
		return $this->cards;
	}

	public function size(){
		return count($this->cards);
	}
}

//Class that represents a simple playing card
class Card {
	protected $id;

	public function __construct(){
		$this->id = rand(0, 10000);
	}

	public function getId(){
		return $this->id;
	}

	public function match($candidate){
		if(is_object($candidate) && $this === $candidate){
			return true;
		} else if (is_integer($candidate) && $this->getId() == $candidate){
			return true;
		} else {
			return false;
		}
	}
}