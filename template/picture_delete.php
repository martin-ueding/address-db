<?php
printf(_('Do you really want to remove the picture for %s?'), '<em>'.$person_loop['vorname'].' '.$person_loop['nachname'].'</em>');
echo '<br />';
echo '<br />';
echo '<a href="index.php?mode=Picture::delete&id='.$id.'&sure=true">'._('Yes, delete picture!').'</a>';
echo '<br />';
echo '<br />';
echo '<a href="?mode=Person::view&id='.$id.'">'._('cancel').'</a>';
?>
