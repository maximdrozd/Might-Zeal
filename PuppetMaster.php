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
	$comList = explode(" ", trim(fgets($handle)));

	switch (trim($comList[0])) {
		case 'init':
			//TODO: for time being it's ok to randomly generate dummy cards. This will be a database access in future.
			for ($i=0; $i < Config::MAX_CARD_SET_SIZE * 2; $i++) { 
				$game->players[floor($i / Config::MAX_CARD_SET_SIZE)]->deck->add(new Card(array("id" => $i)));
			}
			break;
		case "draw":
			$player = $game->currentPlayer();
			$player->drawCard();
			$game->advanceCurrentTurn();
			break;
		case "play":
			$player = $game->currentPlayer();
			$player->playCard(trim($comList[1]));
			break;
		case "shuffle":
			$player = $game->currentPlayer();
			$player->deck->mix();
			break;
		case 'exit':
			exit(0);
			break;
		default:
			echo "Everything seems OK";
			break;
	}
	$presenter->render();
}