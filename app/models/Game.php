<?php
namespace Game\Models;

class Game {
	public $playingField;
	public $players;
	protected $currentTurn;

	public function __construct($players){
		$this->playingField = new PlayingField(null);
		foreach ($players as $player) {
			$this->players[] = new Player(array("name" => $player));
		}
		$this->currentTurn = rand(0, count($players) - 1);
	}

	public function getCurrentTurn(){
		return $this->currentTurn;
	}

	public function advanceCurrentTurn(){
		$this->currentTurn++;
		if($this->currentTurn >= count($this->players)){
			$this->currentTurn = 0;
		}
	}

	public function currentPlayer(){
		return $this->players[$this->currentTurn];
	}
}
