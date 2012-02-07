<?PHP
// Copyright © 2011 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');
require_once('../view/Missing.php');

echo '<h1>'._('entries without a form of address').'</h1>';
$from_with_get = 'mode=no_title';

$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('anrede_r = 1');

$missing = new Missing($filter, $from_with_get);
echo $missing->html();
?>
