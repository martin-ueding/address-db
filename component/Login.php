<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Handles a MySQL Database login.
 *
 * It requires a database.ini to be present in the current directory.
 *
 * That file has to contain at least one section describing a database access.
 *
 * <code><pre>
 * [development]
 * server = 127.0.0.1
 * user = testing
 * password = testing
 * database = addresses
 * </pre></code>
 */
class Login {
	private $connections;
	private $errors = array();

	public function __construct($configfile) {
		if (!file_exists($configfile)) {
			$configfile = '../'.$configfile;
		}
		if (!file_exists($configfile)) {
			$configfile = '../'.$configfile;
		}
		if (!file_exists($configfile)) {
			die(_('Cannot open database.ini.'));
		}
		$this->connections = parse_ini_file($configfile, true);

		foreach ($this->connections as $connection) {
			$success = $this->try_connection($connection);

			# Quit here if a connection could be established.
			if ($success === true) {
				break;
			}
		}
	}

	private function try_connection($connection) {
		$dbh = @mysql_connect(
			$connection['server'],
			$connection['user'],
			$connection['password']
		);
		$this->errors[] = mysql_error();

		if ($dbh) {
			mysql_select_db($connection['database'], $dbh);
			$this->errors[] = mysql_error();
		}
		else {
			return false;
		}
	}

	public function get_errors() {
		return $this->errors;
	}
}

new Login('database.ini');
