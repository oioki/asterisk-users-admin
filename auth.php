<?php

require("authcommon.php");

if ( !isset($_COOKIE['auth']) ) Header('Location: login.html');

list($login,$pass) = split(":",$_COOKIE['auth']);
$userid = check_credentials($login,$pass);

if ( !$userid ) Header('Location: login.html');

$smarty->assign('admin',$admin);

?>
