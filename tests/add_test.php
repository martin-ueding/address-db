<?php
// Copyright (c) 2011 Martin Ueding <dev@martin-ueding.de>

require_once('simpletest/autorun.php');
require_once('simpletest/web_tester.php');

class AddTest extends WebTestCase {
	function __construct() {
		$this->baseurl = "127.0.0.1".dirname(dirname($_SERVER['PHP_SELF']));
	}

	function verifyPageLoad() {
		$this->assertResponse(200);
	}

	function testBaseUrl() {
		$urlparts = explode('/', $this->baseurl);
		$lastpart = $urlparts[count($urlparts)-1];
		$this->assertFalse($lastpart == 'tests');
		$this->assertTrue($lastpart == 'trunk');
	}

	function testAdd() {
		$this->get($this->baseurl."/adressen/");
		$this->verifyPageLoad();
		$this->assertTrue($this->click('create new entry'));
		$this->verifyPageLoad();
		echo $this->getUrl();
		$this->assertPattern('$<h1>create a new entry</h1>$');

		$vorname = uniqid();
		$nachname = uniqid();

		$this->assertTrue($this->setField('vorname', $vorname));
		$this->assertTrue($this->setField('nachname', $nachname));
		$this->assertTrue($this->click('save'));

		$this->verifyPageLoad();

		$this->assertPattern("/$vorname/");
		$this->assertPattern("/$nachname/");
	}
}
