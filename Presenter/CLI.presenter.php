<?php
require_once("Utils/Colors.class.php");

class CLIPresenter {

	protected $game;
	protected $color;

	public function __construct($game){
		$this->game = $game;
		$this->color = new Colors();
	}

	public function render(){
		echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
		$out =  $this->renderPlayerHand($this->game->players[0], true);
		$out .= $this->renderPlayerAvatar($this->game->players[0]);
		$out .= $this->renderPlayerDeck($this->game->players[0]);
		$out .= $this->renderPlayerArena($this->game->players[0]);
		$out .= str_pad("", 43, "-")."\n";
		$out .= $this->renderPlayerArena($this->game->players[1]);
		$out .= $this->renderPlayerDeck($this->game->players[1]);
		$out .= $this->renderPlayerAvatar($this->game->players[1]);
		$out .=  $this->renderPlayerHand($this->game->players[1], false);
		echo $out."\n\n";
	}

	private function renderPlayerAvatar($player){
		$avatar = $player->avatar;
		$out = $this->color->getColoredString("(" . $avatar->currentHP . "/" . $avatar->maxHP . ")", "red", null);
		$out .= $this->color->getColoredString(str_pad($player->name . " <" . $avatar->getClassName() . ">", 30, " ", STR_PAD_BOTH), $avatar->getClassColor(), null);
		$out .= $this->color->getColoredString("(" . $avatar->currentMP . "/" . $avatar->maxMP . ")", "blue", null);
		return  $out."\n";
	}

	private function renderPlayerDeck($player){
		$deck = $player->deck;
		$out = "[" . $deck->size() . "]";
		if($deck->size() > 10) $out .= "]";
		if($deck->size() > 20) $out .= "]";
		return str_pad($out, 43, " ", STR_PAD_LEFT)."\n";
	}

	private function renderPlayerHand($player, $isHidden){
		$out = "|";
		$hand = $player->hand;
		if($hand->size() == 0) return "\n";
		if($isHidden){
			for ($i=0; $i < $hand->size(); $i++) { 
				$out .= "@|";
			}
		} else {
			foreach ($hand->getAll() as $card) {
				$out .= $card->id . "|";
			}
		}
		return str_pad($out, 43, " ", STR_PAD_BOTH)."\n";
	}

	private function renderPlayerArena($player){
		$out = "";
		$arena = $player->arena;
		foreach ($arena->getAll() as $card) {
			$out .= "{" . $card->id . "}";
		}
		return str_pad($out, 43, " ", STR_PAD_BOTH)."\n";
	}
}