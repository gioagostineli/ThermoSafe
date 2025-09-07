<?php
const DB_HOST = 'db';        // em produção (Locaweb) será 'localhost'
const DB_USER = 'tsafe';
const DB_PASS = 'tsafe123';
const DB_NAME = 'thermosafe';

function db() {
	static $c = null;
	if ($c === null) {
		$c = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ($c->connect_error) { http_response_code(500); exit; }
		$c->set_charset('utf8mb4');
	}
	return $c;
}