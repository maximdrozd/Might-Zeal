<?php
require_once("GameException.class.php");

class CardCollection {
	protected $cards;

	public function __construct(){
		$this->cards = array();
	}

	public function add($element){
		array_push($this->cards, $element);
		return $element;
	}

	public function remove($element){
		$card = $this->find($element);
		if($card !== GameException::CARD_NOT_FOUND){
			array_splice($this->cards, array_search($card, $this->cards, true), 1);
			return $card;
		} else {
			return GameException::CARD_NOT_FOUND;
		}
	}

	public function mix(){
		return shuffle($this->cards);
	}

	public function find($element){
		foreach ($this->cards as $card) {
			if($card->match($element)){
				return $card;
			}
		}
		return GameException::CARD_NOT_FOUND;
	}

	public function getAll(){
		return $this->cards;
	}

	public function size(){
		return count($this->cards);
	}
}