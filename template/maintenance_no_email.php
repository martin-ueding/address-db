<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Checks for missing email.
 */

echo '<h1>'._('entries without an email address').'</h1>';
echo $missing->html();
?>
