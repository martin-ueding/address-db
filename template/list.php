<h1><?php echo _('list'); ?></h1>

<?php echo $title; ?>
<br />
<?php echo $counts; ?>
<br />
<br />
<?php echo $table; ?>

<?php if ($allow_export): ?>
<br />
<br />
<a href="export/vcard_fmg.php">
<?php _('export this list as a VCard'); ?>
</a>
<br />
<a href="export/export812_fmg.php">
<?php echo _('export this list as a LaTeX for day planner sheets'); ?>
</a>
<?php endif; ?>

<?php if (isset($email_addresses)): ?>
<br />
<br />
<a href="mailto:?bcc=<?php echo $email_addresses; ?>">
<?php echo _('send an email to everybody in this list'); ?>
</a>
<?php endif; ?>
