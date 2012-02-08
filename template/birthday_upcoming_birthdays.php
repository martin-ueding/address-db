<table id="geburtstag">
<tr>
<td colspan="4"><b><?php echo _('birthdays'); ?></b></td>
</tr>
<tr>
<td colspan="3">&nbsp;<br /><?php echo _('this month'); ?>:</td>
</tr>

<?php foreach ($this_persons as $person): ?>
<tr class="data">
<td>
<a href="?<?php echo $person['link']; ?>">

<?php if ($person['has_birthday']): ?>
<em>
<?php elseif ($person['had_birthday']): ?>
<span class="graytext">
<?php endif; ?>

<?php echo $person['first_name'].' '.$person['last_name']; ?>

<?php if ($person['has_birthday']): ?>
</em>
<?php elseif ($person['had_birthday']): ?>
</span>
<?php endif; ?>

</a> </td>
<td><?php echo $person['day'].'.'.$person['month']; ?>.</td>
<td><?php echo $person['age']; ?></td>
</tr>
<?php endforeach; ?>

<tr>
<td colspan="3">&nbsp;<br />
<?php echo _('next month'); ?>:</td>
</tr>


<?php foreach ($next_persons as $person): ?>
	<tr class="data">
	<td>
<a href="?<?php echo $person['link']; ?>">
<?php echo $person['first_name'].' '.$person['last_name']; ?>
</a>
</td>
<td><?php echo $person['day'].'.'.$person['month']; ?>.</td>

	<td><?php echo $person['age']; ?></td>
	</tr>
<?php endforeach; ?>
</table>
