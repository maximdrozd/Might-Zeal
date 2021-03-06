<?php
namespace Game\Models;

class Deck extends CardCollection {
	public function __construct(){
		parent::__construct();
	}

	public function draw(){
		if($this->size() > 0){
			return $this->find($this->cards[0]);
		}
		return null;
	}
}
