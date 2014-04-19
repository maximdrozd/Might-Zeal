<?php
require_once("Utils/Colors.class.php");
require_once("Game/System/GameException.class.php");

class CLIPresenter {

	protected $game;
	protected $color;
	public $autoClear;

	public function __construct($game){
		$this->game = $game;
		$this->color = new Colors();
		$this->autoClear = true;
	}

	public function render(){
		if($this->autoClear) echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
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

	public function describeCard($cardId, $player){
		// Search for the card in the arena first.
		try {
			$card = $player->arena->find($cardId);
		} catch (CardNotFoundException $e) {
			// Fall back to the player's hand.
			try {
				$card = $player->hand->find($cardId);
			} catch (CardNotFoundException $e) {
				echo $e->getMessage();
				return;
			}
		}

		$out = "";
		$out .= "{".$card->cost."}---------------+\n";
		$out .= " |                |\n";
		$out .= " |" . str_pad($card->name, 16, " ", STR_PAD_BOTH) . "|\n"; //16
		$out .= " |" . str_pad($card->id, 16, " ", STR_PAD_BOTH) . "|\n";
		$out .= " |                |\n";
		$out .= " |                |\n";
		$out .= " |                |\n";
		$out .= " |                |\n";
		$out .= "(".$card->attack.")--------------[".$card->defense."]\n";
		echo $out."\n\n";
	}

	private function renderPlayerAvatar($player){
		$avatar = $player->avatar;
		$turnPrefix = "";
		if($player == $this->game->currentPlayer()){
			$turnPrefix = "*";
		}
		$out = $this->color->getColoredString("(" . $avatar->currentHP . "/" . $avatar->maxHP . ")", "red", null);
		$out .= $this->color->getColoredString(str_pad($turnPrefix . $player->name . " <" . $avatar->getClassName() . ">", 30, " ", STR_PAD_BOTH), $avatar->getClassColor(), null);
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
