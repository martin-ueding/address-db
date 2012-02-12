<?php
# Copyright © 2012 Martin Ueding <dev@martin-ueding.de>

/**
 * Checks for missing group association.
 */

echo '<h1>'._('entries without a group').'</h1>';
echo $missing->html();
?>
