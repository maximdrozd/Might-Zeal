<?php

class Tokenizer {
	public function __construct(){

	}

	public function generateToken(){
		$timestamp = date('U');
		$random = rand(0,9999999);
		$token = md5(sha1($timestamp) . md5($random));
		return $token;
	}
}