<?php
// Copyright © 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');
require_once('../view/Missing.php');

echo '<h1>'._('entries without an association').'</h1>';
$from_with_get = 'mode=no_association';

$filter = new Filter(0, $_SESSION['g']);
$filter->add_where('ad_flinks.person_lr IS NULL');
$filter->add_join('LEFT JOIN ad_flinks ON person_lr = p_id');

$missing = new Missing($filter, $from_with_get);
echo $missing->html();
?>
