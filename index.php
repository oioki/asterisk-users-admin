<?php
////////////////////////////////////////////////////
// Web interface for managing SIP users
//  by Tarasov Alexander aka oioki
// Requirements: pdo-mysql, smarty
////////////////////////////////////////////////////

#ini_set('display_errors',1);
#error_reporting(E_ALL);

require('auth.php');

$smarty->debugging = false;
$smarty->caching = false;


$sql = "SELECT *, FROM_UNIXTIME(`regseconds`) AS `regtime`
FROM `sip_users` JOIN `sip_contexts` ON `sip_users`.`context` = `sip_contexts`.`contextname` ORDER BY `sip_users`.`name`";

$sth = $dbh->prepare($sql);
$sth->execute() or die( $sql );

$rows = array();

while ( $row = $sth->fetch() )
{
    $row['location'] = ip2location($row['ipaddr']);
    preg_match('/^sip:\d{3,4}@(\d*\.\d*\.\d*.\d*)/', $row['fullcontact'], $m);
    $row['interip'] = ($m[1]==$row['ipaddr']) ? '' : $m[1];
    $rows[] = $row;
}


$sql = "SELECT * FROM `sip_extensions` ORDER BY `name`";
$sth = $dbh->prepare($sql);
$sth->execute() or die( $sql );

while ( $row = $sth->fetch() )
{
    $row['type'] = 'ext';
    $rows[] = $row;
}

function cmp($a, $b)
{
    return ( $a['name'] > $b['name'] );
}
usort($rows, "cmp");

$smarty->assign('users', $rows);
$smarty->display('index.tpl');

?>
