<?php
require_once("Enum/HeroClass.enum.php");

class Avatar {
	protected $currentHP;
	protected $maxHP;
	protected $currentMP;
	protected $maxMP;
	protected $class; 

	public function __construct(){
		$classes = array(HeroClass::MAGE, HeroClass::PRIEST, HeroClass::WARLOCK, HeroClass::DRUID, HeroClass::ROGUE, HeroClass::MONK,
			HeroClass::SHAMAN, HeroClass::HUNTER, HeroClass::DEATHKNIGHT, HeroClass::PALADIN, HeroClass::WARRIOR);
		shuffle($classes);
		$this->maxHP = rand(22,30);
		$this->currentHP = $this->maxHP;
		$this->maxMP = rand(8,10);
		$this->currentMP = 0;
		$this->class = $classes[0];
	}
}