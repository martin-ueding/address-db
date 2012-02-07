<?PHP
// Copyright (c) 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');
require_once('../report/Missing.php');

echo '<h1>'._('entries without a group').'</h1>';
$from_with_get = 'mode=no_group';

$filter = new Filter($_SESSION['f'], 0);
$filter->add_where('ad_glinks.person_lr IS NULL');
$filter->add_join('LEFT JOIN ad_glinks ON ad_glinks.person_lr = gl_id');

$missing = new Missing($filter, $from_with_get);
echo $missing->html();
?>
