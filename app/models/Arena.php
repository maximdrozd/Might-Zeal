<?php
namespace Game\Models;

class Arena extends CardCollection {
	public function __construct(){
		parent::__construct();
	}

	public function triggerTurnStart(){
		foreach ($this->cards as $card) {
			$card->canAttack = true;
		}
	}
}
