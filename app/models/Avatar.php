<?php
namespace Game\Models;

use Game\Enum\HeroClass;

class Avatar {
	public $currentHP;
	public $maxHP;
	public $currentMP;
	public $maxMP;
	public $class; 
	private $classNamesAndColors;

	public function __construct(){
		$classes = array(HeroClass::MAGE, HeroClass::PRIEST, HeroClass::WARLOCK, HeroClass::DRUID, HeroClass::ROGUE, HeroClass::MONK,
			HeroClass::SHAMAN, HeroClass::HUNTER, HeroClass::DEATHKNIGHT, HeroClass::PALADIN, HeroClass::WARRIOR);
		shuffle($classes);
		$this->maxHP = rand(22,30);
		$this->currentHP = $this->maxHP;
		$this->maxMP = rand(8,10);
		$this->currentMP = 0;
		$this->class = $classes[0];
		$this->classNamesAndColors = array(
			HeroClass::MAGE => ["Magic Man", "cyan"], 
			HeroClass::PRIEST => ["Holy Dude", "white"], 
			HeroClass::WARLOCK => ["Emo Bro", "purple"], 
			HeroClass::DRUID => ["Tree Hugger", "brown"], 
			HeroClass::ROGUE => ["Scarborough Resident", "yellow"], 
			HeroClass::MONK => ["Kung Fu Panda", "light_green"],
			HeroClass::SHAMAN => ["Hurricane Chaser", "blue"], 
			HeroClass::HUNTER => ["Huntard", "green"], 
			HeroClass::DEATHKNIGHT => ["Noble Emo Dude", "red"], 
			HeroClass::PALADIN => ["Church Fanatic", "light_purple"], 
			HeroClass::WARRIOR => ["Hard Head", "dark_gray"]
		);
	}

	public function getClassName(){
		return $this->classNamesAndColors[$this->class][0];
	}

	public function getClassColor(){
		return $this->classNamesAndColors[$this->class][1];
	}
}
