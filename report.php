<?php

require 'auth.php';

$sql = "SELECT * FROM `sip_users` JOIN `sip_contexts` ON `sip_users`.`context` = `sip_contexts`.`contextname` WHERE `native`=1 ORDER BY `sip_users`.`name`";

$sth = $dbh->prepare($sql);
$sth->execute() or die( $sql );

$rows = array();
while ( $row = $sth->fetch() )
    $rows[] = $row;

$smarty->assign('users', $rows);

header("Content-Type: text/plain; charset=UTF-8");
$smarty->display('report.tpl');

?>
