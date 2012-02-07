<?PHP	
// Copyright (c) 2011-2012 Martin Ueding <dev@martin-ueding.de>

require_once('../helper/Filter.php');
require_once('../report/Missing.php');

echo '<h1>'._('without a birthday').'</h1>';
$from_with_get = 'mode=no_birthday';

$filter = new Filter($_SESSION['f'], $_SESSION['g']);
$filter->add_where('(geb_t = 0 || geb_m = 0)');
$filter->add_where('anrede_r != 4');


$missing = new Missing($filter, $from_with_get);
echo $missing->html();
?>
