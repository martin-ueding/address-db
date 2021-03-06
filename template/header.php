<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Navigation.
 */

require_once('helper/Navigation.php');
?>

<div id="nav_mode">
<ul>
<li><b><?php echo _('mode'); ?></b></li>

<li>
<a href="?<?php echo $mode_all_request; ?>" class="<?php echo $mode_all_class; ?>">
<?php echo _('all'); ?>
</a>
</li>
<?php echo Navigation::spacer(); ?>
<?php foreach ($mode_links as $mode_link): ?>
<li>
<a href="?<?php echo $mode_link['request']; ?>" class="<?php echo $mode_link['class']; ?>">
<?php echo $mode_link['title']; ?>
</a>
</li>
<?php endforeach; ?>

</ul>
</div>

<div id="nav_groups">
<ul>
<li><b><?php echo _('groups'); ?></b></li>

<li>
<a href="?<?php echo $group_all_request; ?>" class="<?php echo $group_all_class; ?>">
<?php echo _('all'); ?>
</a>
</li>

<?php echo Navigation::spacer(); ?>

<?php foreach ($group_links as $group_link): ?>
<li>
	<a href="?<?php echo $group_link['request']; ?>" class="<?php echo $group_link['class']; ?>">
	<?php echo $group_link['title']; ?>
	</a>
</li>
<?php endforeach; ?>

</ul>
</div>

<div id="nav_actions">
<ul>
<?php
echo '<li><b>'._('views').'</b></li>';
echo Navigation::nav_action_link('List::index', $current_mode, _('show entries'));
echo Navigation::nav_action_link('Birthday::upcoming_birthdays', $current_mode, _('birthday view'));
echo Navigation::nav_action_link('Birthday::index', $current_mode, _('birthday list'));
echo Navigation::spacer();
echo '<li><b>'._('create').'</b></li>';
echo Navigation::nav_action_link('Person::create', $current_mode, _('create new entry'));
echo Navigation::spacer();
echo '<li><b>'._('export').'</b></li>';
echo '<li><a href="?mode=Export::kitchen">'._('kitchen list').'</a></li>';
echo '<li><a href="?mode=Export::vcard_multiple">'._('VCard').'</a></li>';
echo '<li><a href="?mode=Export::csv">'._('CSV').'</a></li>';
echo '<li><a href="?mode=Export::dayplanner">'._('dayplanner').'</a></li>';
echo '<li><a href="?mode=Export::birthday_calendar">'._('ICS birthday calendar').'</a></li>';
echo '<li><a href="?mode=Export::json">'._('JSON').'</a></li>';
echo Navigation::spacer();
echo '<li><b>'._('maintenance').'</b></li>';
echo Navigation::nav_action_link('Maintenance::no_title', $current_mode, _('no form of address'));
echo Navigation::nav_action_link('Maintenance::no_association', $current_mode, _('no association'));
echo Navigation::nav_action_link('Maintenance::no_group', $current_mode, _('no group'));
echo Navigation::nav_action_link('Maintenance::no_email', $current_mode, _('no email address'));
echo Navigation::nav_action_link('Maintenance::no_birthday', $current_mode, _('no birthday'));
echo Navigation::nav_action_link('Maintenance::integrity_check', $current_mode, _('database check'));
?>
</ul>
</div>

<div id="kartei">
<?php
$buchstaben = range('A', 'Z');
foreach ($buchstaben as $b) {
	if (in_array($b, $show_letters)) {
		echo '<a href="?mode=List::index&b='.$b.'">';
		echo $b;
		echo '</a>';
	}
	else {
		echo '<span>'.$b.'</span>';
	}
}
?>
</div>


<div id="search">
<form action="index.php" method="get"><input type="text" id="suche" name="suche" maxlength="100" /><input type="hidden" name="mode" value="Search::index" /></form>
</div>
