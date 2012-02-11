<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

require_once('component/Filter.php');
require_once('controller/Controller.php');
require_once('helper/Table.php');
require_once('model/FamilyMember.php');
require_once('model/Group.php');

class ListController extends Controller {
	public function index() {
		$this->history_save();

		if (!empty($_GET['b'])) {
			$page_title = _('Address DB').': '.sprintf(_('letter &bdquo;%s&ldquo;'), $_GET['b']);
		}
		else if (!empty($_GET['f'])) {
			# XXX Use model.
			// get name for person
			$name_sql = 'SELECT fmg FROM ad_fmg WHERE fmg_id='.$_GET['f'].';';
			$name_erg = mysql_query($name_sql);
			if ($name = mysql_fetch_assoc($name_erg)) {
				$f_name = $name['fmg'];
			}
			$page_title = _('Address DB').': '.sprintf(_('entries for %s'), $f_name);
		}
		else {
			$page_title = _('Address DB').': '._('list');
		}

		$this->set_page_title($page_title);

		$template = new Template(__CLASS__, __FUNCTION__);

		$filter = new Filter($_SESSION['f'], $_SESSION['g']);

		/* Suche nach Buchstabe */
		if (!empty($_GET['b'])) {
			$filter->add_where('nachname like "'.$_GET['b'].'%"');
		}

		$sql = 'SELECT * FROM ad_per '.$filter->join().' WHERE '.$filter->where().' ORDER BY nachname, vorname;';

		/* Daten anzeigen */
		if (!empty($sql)) {
			$erg = mysql_query($sql);

			$title = '';

			if (!empty($_GET['b'])) {
				$title = sprintf(
					_('Last names starting with %s:'),
					'<em>'.$_GET['b'].'</em>', mysql_num_rows($erg)
				);
			}

			else if ($_SESSION['g'] != 0) {
				$title = sprintf(
					_('Group %s:'),
					'<em>'.Group::get_name($_SESSION['g']).'</em>', mysql_num_rows($erg)
				);
			}

			else if ($_SESSION['f'] != 0) {
				$title = sprintf(
					_('Member %s:'),
					'<em>'.FamilyMember::get_name($_SESSION['f']).'</em>', mysql_num_rows($erg)
				);
			}

			$template->set('title', $title);

			$counts = sprintf(
				ngettext(
					'%d entry:',
					'%d entries:', mysql_num_rows($erg)
				),
				mysql_num_rows($erg)
			);

			$template->set('counts', $counts);


			$table = new Table($erg);
			$template->set('table', $table->html());

			// Collect email address from everybody to send off a mass email.
			$erg = mysql_query($sql);
			while ($l = mysql_fetch_assoc($erg)) {
				if ($l['email_privat'] != "") {
					$emailadressen[] = $l['email_privat'];
				}
				else if ($l['email_arbeit'] != "") {
					$emailadressen[] = $l['email_arbeit'];
				}
				else if ($l['email_aux'] != "") {
					$emailadressen[] = $l['email_aux'];
				}
			}
		}

		$template->set('allow_export', empty($_GET['b']) && empty($_GET['g']) && !empty($_GET['f']));

		if (!empty($emailadressen)) {
			$template->set('email_addresses', implode(',', $emailadressen));
		}

		return $template->html();
	}
}
?>
