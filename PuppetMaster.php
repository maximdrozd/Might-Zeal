<?php
require_once("ClassSkeleton.class.php");

$game = new Game();

$command = (isset($_REQUEST["com"])) ? $_REQUEST["com"] : null;

switch ($command) {
	case 'show':
		# code...
		break;
	
	default:
		# code...
		break;
}

echo "<pre>";
var_dump($game);
echo "</pre>";