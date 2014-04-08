<?php
require_once("DefaultRequires.php");
require_once("Enum/CardRarity.enum.php");
require_once("Enum/CardType.enum.php");
require_once("Enum/HeroClass.enum.php");

class Card {
	protected $id; //game UNIQUE id
	protected $name;
	protected $description;
	protected $image;
	protected $hero;
	protected $cardBack;
	protected $suit;
	protected $rarity;
	protected $type;
	protected $subType;
	protected $cost;
	protected $attack;
	protected $life;
	protected $defense;
	protected $specialFlags;

	public function __construct($parameterMap){
		$this->id = rand(0, 10000); //fake, replace with param
		$this->name = initWithVar("name", $parameterMap, "Default Name");
		$this->description = initWithVar("description", $parameterMap, "Default Description can be rather long");
		$this->image = initWithVar("image", $parameterMap);
		$this->hero = initWithVar("hero", $parameterMap, HeroClass::ANY);
		$this->cardBack = initWithVar("cardBack", $parameterMap);
		$this->suit = initWithVar("suit", $parameterMap);
		$this->rarity = initWithVar("rarity", $parameterMap, CardRarity::UNKNOWN);
		$this->type = initWithVar("type", $parameterMap, CardType::UNKNOWN);
		$this->subType = initWithVar("subType", $parameterMap);
		$this->cost = initWithVar("cost", $parameterMap, 0);
		$this->attack = initWithVar("attack", $parameterMap, 0);
		$this->life = initWithVar("life", $parameterMap, 0);
		$this->defense = initWithVar("defense", $parameterMap, 0);
		$this->specialFlags = initWithVar("specialFlags", $parameterMap);
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