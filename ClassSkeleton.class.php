<?php
//Class that represents a Game
class Game {
	public $playingField;
	public $players;

	public function __construct(){
		$this->playingField = new PlayingField();
		$this->players[] = new Player();
		$this->players[] = new Player();
	}
}
