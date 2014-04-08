<?php
require_once("DefaultRequires.php");
require_once("Enum/EnvironmentType.enum.php");

class PlayingField {
	protected $environment;

	public function __construct($parameterMap){
		$this->environment = initWithVar("environment", $parameterMap, EnvironmentType::UNKNOWN);
	}
}