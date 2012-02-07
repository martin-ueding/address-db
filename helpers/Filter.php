<?php
# Copyright (c) 2012 Martin Ueding <dev@martin-ueding.de>

class Filter {
	public function __construct($fmg = 0, $group = 0) {
		$this->snippets = array(
			"join" => array(),
			"where" => array(),
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

	public function add_join($join) {
		$this->snippets["join"][] = $join;
	}

	public function add_where($where) {
		$this->snippets["where"][] = $where;
	}

	public function join() {
		return implode(' ', $this->snippets["join"]);
	}
	public function where() {
		return implode(' && ', $this->snippets["where"]);
	}
}
?>
