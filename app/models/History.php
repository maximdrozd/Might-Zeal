<?php
namespace Game\Models;

class History {
	private $events;

	public function __construct(){
		$this->events = array();
	}

	public function add($event){
		$this->events[] = $event;
	}

	public function addRaw($owner, $card, $action){
		$event = new HistoryEvent($owner, $card, $action);
		$this->add($event);
	}

	public function getAll(){
		return $this->events;
	}
}