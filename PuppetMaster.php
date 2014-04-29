
<?php
$loader = require __DIR__ . '/vendor/autoload.php';

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

// $com = (isset($argv[1])) ? $argv[1] : "CLI";
// $com = (isset($_REQUEST["com"])) ? $_REQUEST["com"] : $com;

use Game\Models\Card;
use Game\Models\Game;
use Game\Presenters\CLIPresenter;
use Game\System\Config;

$game = new Game(["MZ","BZ"]);
$presenter = new CLIPresenter($game);

while(1){
	if(PHP_SAPI != "cli") {
		echo "For now this is only runable from command line";
		exit();
	}
	$handle = fopen ("php://stdin","r");
	$comList = explode(" ", trim(fgets($handle)));

	switch (trim($comList[0])) {
		case 'init':
			//TODO: for time being it's ok to randomly generate dummy cards. This will be a database access in future.
			for ($i=0; $i < Config::MAX_CARD_SET_SIZE * 2; $i++) { 
				$player = $game->players[floor($i / Config::MAX_CARD_SET_SIZE)];
				$player->deck->add(new Card(array("id" => $i)));
				$player->deck->mix();
			}
			break;
		case "endTurn":
			$game->advanceCurrentTurn();
			break;
		case "play":
			$player = $game->currentPlayer();
			$player->playCard(trim($comList[1]));
			break;
		case "describe":
			$player = $game->currentPlayer();
			$presenter->autoClear = false;
			$presenter->describeCard(trim($comList[1]), $player);
			break;
		case 'exit':
			exit(0);
			break;
		default:
			echo "Everything seems OK";
			break;
	}
	$presenter->render();
	$presenter->autoClear = true;
}
