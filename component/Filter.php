<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Gathers JOIN and WHERE commands for a MySQL query.
 */
class Filter {
	/**
	 * Creates a new filter for the given family member and group.
	 *
	 * @param int $fmg Family member ID.
	 * @param int $group Group ID.
	 */
	public function __construct($fmg = 0, $group = 0) {
		$this->snippets = array(
			"join" => array(),
			"where" => array(),
			"order" => array(),
		);

		if ($fmg != 0) {
			$this->snippets["join"][] = 'JOIN ad_flinks ON ad_flinks.person_lr = p_id';
			$this->snippets["where"][] = 'fmg_lr = '.$fmg;
		}

		if ($group != 0) {
			$this->snippets["join"][] = 'JOIN ad_glinks ON ad_glinks.person_lr = p_id';
			$this->snippets["where"][] = 'gruppe_lr = '.$group;
		}
	}

	/**
	 * Adds a new JOIN clause.
	 *
	 * @param string $join MySQL JOIN clause.
	 * @param bool $in_front Whether to add clause in front.
	 */
	public function add_join($join, $in_front = false) {
		if ($in_front) {
			array_unshift($this->snippets["join"], $join);
		}
		else {
			array_push($this->snippets["join"], $join);
		}
	}

	/**
	 * Adds a new WHERE clause.
	 *
	 * The new clause is used with an AND with the other clauses.
	 *
	 * @param string $where MySQL WHERE clause.
	 */
	public function add_where($where) {
		$this->snippets["where"][] = $where;
	}

	/**
	 * Returns all join commands.
	 *
	 * @return string Combined JOIN commands.
	 */
	public function join() {
		return implode(' ', $this->snippets["join"]);
	}

	/**
	 * Returns all where commands.
	 *
	 * @return string Combined WHERE commands.
	 */
	public function where() {
		if (count($this->snippets["where"]) > 0) {
			return implode(' && ', $this->snippets["where"]);
		}
		else {
			return "true";
		}
	}

	/**
	 * Adds the needed JOIN commands for the Address.
	 */
	public function add_address() {
		$this->add_join('LEFT JOIN ad_adressen ON adresse_r = ad_id');
		$this->add_join('LEFT JOIN ad_anreden ON anrede_r = a_id');
		$this->add_join('LEFT JOIN ad_laender ON land_r = l_id');
		$this->add_join('LEFT JOIN ad_orte ON ort_r = o_id');
		$this->add_join('LEFT JOIN ad_plz ON plz_r = plz_id');
		$this->add_join('LEFT JOIN ad_prafixe ON prafix_r = prafix_id');
		$this->add_join('LEFT JOIN ad_suffixe ON suffix_r = s_id');
	}

	/**
	 * Performs the query.
	 *
	 * @return mixed MySQL query result.
	 */
	public function get_erg() {
		$sql = 'SELECT * FROM ad_per '.$this->join().' WHERE '.$this->where().' ORDER BY '.$this->order().';';
		return mysql_query($sql);
	}

	public function add_order($key) {
		$this->snippets['order'][] = $key;
	}

	public function order() {
		$orders = array();

		if (count($this->snippets['order']) == 0) {
			$orders = array('nachname, vorname');
		}
		else {
			$orders = $this->snippets['order'];
		}

		return implode(', ', $orders);
	}
}
?>
