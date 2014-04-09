<?php
require_once("Player.class.php");
require_once("PlayingField.class.php");

class Game {
	public $playingField;
	public $players;

	public function __construct(){
		$this->playingField = new PlayingField(null);
		$this->players[] = new Player(array("name" => "MZ"));
		$this->players[] = new Player(array("name" => "BZ"));
	}
}