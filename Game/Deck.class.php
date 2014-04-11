<?php
require_once("System/CardCollection.class.php");

class Deck extends CardCollection {
	public function __construct(){
		parent::__construct();
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