<?php
namespace Game\Models;

use Game\Enum\CardRarity;
use Game\Enum\CardType;
use Game\Enum\HeroClass;

class Card {
	public $id; //game UNIQUE id
	public $name;
	protected $description;
	protected $image;
	protected $hero;
	protected $cardBack;
	protected $suit;
	protected $rarity;
	protected $type;
	protected $subType;
	public $cost;
	public $attack;
	protected $life;
	public $defense;
	protected $specialFlags;

	public function __construct($parameterMap){
		$this->id = initWithVar("id", $parameterMap, rand(0, 10000)); //fake, replace with param
		$this->name = initWithVar("name", $parameterMap, "Default Name");
		$this->description = initWithVar("description", $parameterMap, "Default Description can be rather long");
		$this->image = initWithVar("image", $parameterMap);
		$this->hero = initWithVar("hero", $parameterMap, HeroClass::ANY);
		$this->cardBack = initWithVar("cardBack", $parameterMap);
		$this->suit = initWithVar("suit", $parameterMap);
		$this->rarity = initWithVar("rarity", $parameterMap, CardRarity::UNKNOWN);
		$this->type = initWithVar("type", $parameterMap, CardType::UNKNOWN);
		$this->subType = initWithVar("subType", $parameterMap);
		$this->cost = initWithVar("cost", $parameterMap, rand(0,10));
		$this->attack = initWithVar("attack", $parameterMap, rand(1,5));
		$this->life = initWithVar("life", $parameterMap, 0);
		$this->defense = initWithVar("defense", $parameterMap, rand(0,4));
		$this->specialFlags = initWithVar("specialFlags", $parameterMap);
	}

	public function match($candidate){
		if(is_object($candidate) && $this === $candidate){
			return true;
		} else if ($this->id == $candidate){
			return true;
		} else {
			return false;
		}
	}
}
