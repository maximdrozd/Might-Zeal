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
		$player = $this->currentPlayer();
		$player->triggerTurnStart();
	}

	public function currentPlayer(){
		return $this->players[$this->currentTurn];
	}

	public function getEnemiesForPlayer($player){
		$enemies = array();
		foreach ($this->players as $potentialEnemy) {
			if($player !== $potentialEnemy){
				$enemies[] = $potentialEnemy;
			}
		}
		return $enemies;
	}

	//this is dumb auth. Each player keeps own token 
	//and this is how they can get their player object.
	//this should be for internal use by PuppetMaster
	public function getPlayerByToken($token){
		foreach ($this->players as $player) {
			if($player->token == $token){
				return $player;
			}
		}
		return null;
	}

	public function activateCard($player, $cardId, $target){
		if($player === $this->currentPlayer()){ // legal thing to do, play on your turn
			$card = $player->arena->find($card);
			if($card){
				//apply card effects here
				//TODO: do something with target
				$card->canAct = false;
			}
		}
	}
}
