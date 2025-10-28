<?php
$var1;
echo('isset($var1): ');
echo(isset($var1));
echo($var1);

echo'<br>1--------------<br>';
$var1=null;// null
echo('isset($var1): ');
echo(isset($var1));

echo'<br>2-----------<br>';
$var1=''; 
echo('isset($var1): ');
echo(isset($var1));

echo'<br>3--------------<br>';
$var2='' ;//O, 'O', , null, false
echo('<br>empty($var2): ');
echo(empty($var2));
?>