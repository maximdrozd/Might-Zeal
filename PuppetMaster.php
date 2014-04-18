<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

require_once("Game/Game.class.php");
require_once("Game/Card.class.php");
require_once("Presenter/CLI.presenter.php");
require_once("Game/System/Config.class.php");

// $com = (isset($argv[1])) ? $argv[1] : "CLI";
// $com = (isset($_REQUEST["com"])) ? $_REQUEST["com"] : $com;


$game = new Game(["MZ","BZ"]);
$presenter = new CLIPresenter($game);

while(1){
	$handle = fopen ("php://stdin","r");
	$com = fgets($handle);

	switch (trim($com)) {
		case 'init':
			for ($i=0; $i < Config::MAX_CARD_SET_SIZE * 2; $i++) { 
				$game->players[floor($i / Config::MAX_CARD_SET_SIZE)]->deck->add(new Card(array("id" => $i)));
			}
			//$game->players[0]->drawCard();
			//$game->players[0]->playCard(1);
			//$game->players[0]->returnCardToHand(1);
			//var_dump($game);
			break;
		case "draw":
			$player = $game->currentPlayer();
			$player->drawCard();
			$game->advanceCurrentTurn();
			break;
		case 'exit':
			exit(0);
		default:
			echo "Everything seems OK";
			break;
	}
	$presenter->render();
}