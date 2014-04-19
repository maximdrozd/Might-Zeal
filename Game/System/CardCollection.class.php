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
		try {
			$card = $this->find($element);
			array_splice($this->cards, array_search($card, $this->cards, true), 1);
			return $card;
		} catch (CardNotFoundException $e) {
			// Re-raise the exception.
			throw new CardNotFoundException("Cannot find card with id: " . $element . "\n");
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
		throw new CardNotFoundException("Cannot find card with id: " . $element . "\n");
	}

	public function getAll(){
		return $this->cards;
	}

	public function size(){
		return count($this->cards);
	}
}
