<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * List with email option.
 */
?>
<h1><?php echo _('list'); ?></h1>

<?php echo $title; ?>
<br />
<?php echo $counts; ?>
<br />
<br />
<?php echo $table; ?>

<?php if (isset($email_addresses)): ?>
<br />
<br />
<a href="mailto:?bcc=<?php echo $email_addresses; ?>">
<?php echo _('send an email to everybody in this list'); ?>
</a>
<?php endif; ?>
