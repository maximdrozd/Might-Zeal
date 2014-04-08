<?php
require_once("Enum/CardRarity.enum.php");

class Card {
	protected $id;
	protected $name;
	protected $description;
	protected $image;
	protected $suit;
	protected $rarity;
	protected $type;
	protected $attack;
	protected $life;
	protected $defense;
	protected $specialFlags;

	public function __construct($parameterMap){
		$this->id = rand(0, 10000); //fake, replace with param
		$this->name = ($parameterMap->name) ? $parameterMap->name : "unknown";
		$this->description = ($parameterMap->description) ? $parameterMap->description : "unknown";
		$this->image = ($parameterMap->image) ? $parameterMap->image : "unknown";
		$this->suit = ($parameterMap->suit) ? $parameterMap->suit : "unknown";
		$this->rarity = ($parameterMap->rarity) ? $parameterMap->rarity : CardRarity::UNKNOWN;
		$this->type = ($parameterMap->type) ? $parameterMap->type : "unknown";
		$this->attack = ($parameterMap->attack) ? $parameterMap->attack : "unknown";
		$this->life = ($parameterMap->life) ? $parameterMap->life : "unknown";
		$this->defense = ($parameterMap->defense) ? $parameterMap->defense : "unknown";
		$this->specialFlags = ($parameterMap->specialFlags) ? $parameterMap->specialFlags : "unknown";
	}

	public function match($candidate){
		if(is_object($candidate) && $this === $candidate){
			return true;
		} else if (is_integer($candidate) && $this->id == $candidate){
			return true;
		} else {
			return false;
		}
	}
}