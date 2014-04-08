<?php

class CardRarity {
	const UNKNOWN = 0;
	const COMMON = 1;
	const UNCOMMON = 2;
	const RARE = 3;
	const EPIC = 4;
	const LEGENDARY = 5;

	private $colorByRarity = array("#CCCCCC", "#FFFFFF", "#00BB00", "#0000BB", "#BB00BB", "#FF9900");

	public function getRarityColor($rarity){
		if($rarity < count($this->colorByRarity)){
			return $this->colorByRarity[$rarity];
		} else {
			return $this->colorByRarity[0];
		}
	}
}