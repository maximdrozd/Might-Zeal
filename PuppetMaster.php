
<?php
$loader = require __DIR__ . '/vendor/autoload.php';

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
date_default_timezone_set("America/Toronto");

// $com = (isset($argv[1])) ? $argv[1] : "CLI";
// $com = (isset($_REQUEST["com"])) ? $_REQUEST["com"] : $com;

use Game\Models\Card;
use Game\Models\Game;
use Game\Presenters\CLIPresenter;
use Game\System\Config;

$game = new Game(["MZ","BZ"]);
$presenter = new CLIPresenter($game);
$firstLoop = true;

while(1){
	if(PHP_SAPI != "cli") {
		echo "For now this is only runable from command line";
		exit();
	}

	//just so you don't have to type init each time
	if($firstLoop){
		$comList[0] = 'init';
		$firstLoop = false;
	} else {
		$handle = fopen("php://stdin","r");
		$comList = explode(" ", trim(fgets($handle)));
	}
	
	switch (trim($comList[0])) {
		case 'init':
			//TODO: for time being it's ok to randomly generate dummy cards. This will be a database access in future.
			for ($i=0; $i < Config::MAX_CARD_SET_SIZE * 2; $i++) { 
				$player = $game->players[floor($i / Config::MAX_CARD_SET_SIZE)];
				$player->deck->add(new Card(array("id" => $i)));
				$player->deck->mix();
			}
			$game->currentPlayer()->triggerTurnStart();
			break;
		case "endTurn":
			$game->advanceCurrentTurn();
			break;
		case "play":
			$player = $game->currentPlayer();
			$game->playCard($player, trim($comList[1]), trim($comList[2]));
			break;
		case "describe":
			$player = $game->currentPlayer();
			$presenter->autoClear = false;
			$presenter->describeCard(trim($comList[1]), $player);
			break;
		case "token":
			$presenter->autoClear = false;
			echo $game->currentPlayer()->token;
			break;
		case "player":
			$player = $game->getPlayerByToken($comList[1]);
			$presenter->autoClear = false;
			var_dump($player);
			break;
		case "commands":
			echo "init - initializes the game, doesn't create a new game object\n";
			echo "endTurn - ends current player's turn\n";
			echo "play X - plays card id X\n";
			echo "describe X - gives additional information about card X\n";
			echo "token - outputs current player's secure token\n";
			echo "player XXXX - dumps player object responding to token XXXX\n";
			echo "commands - outputs this list\n";
			echo "exit - quits the script\n";
			break;
		case "exit":
			exit(0);
			break;
		default:
			echo "Everything seems OK";
			break;
	}
	$presenter->render();
	$presenter->autoClear = true;
}
