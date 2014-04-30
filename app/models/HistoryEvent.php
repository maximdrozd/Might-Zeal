<?php
namespace Game\Models;

class HistoryEvent {
	public $owner;
	public $card;
	public $action;

	public function __construct($owner, $card, $action){
		$this->owner = $owner;
		$this->card = $card;
		$this->action = $action;	
	}
}