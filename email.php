<?php

require('auth.php');
require('adminaccess.php');

$sql = "SELECT * FROM `sip_contexts`";
$sth = $dbh->prepare($sql);
$sth->execute() or die( $sql );

$contexts = array();
$comments = array();
while ( $row=$sth->fetch() )
{
    $contexts[] = $row['contextname'];
    $comments[] = $row['contextnumber']." - ".$row['contextcomment']." (".$row['contextname'].")";
}
$smarty->assign('contextscomments', $comments);
$smarty->assign('contexts', $contexts);

if ( (isset($_GET['name'])) and ($_GET['name']!='') )
{
    $sql = "SELECT * FROM `sip_users` JOIN `sip_contexts` ON `sip_users`.`context` = `sip_contexts`.`contextname` WHERE `name` = ? LIMIT 1";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($_GET['name'])) or die( $sql );

    $row = $sth->fetch();
    list($surname, $shortname, $father) = split(" ", $row['fio']);
    $row['shortname'] = $shortname;

    $smarty->assign('user',$row);
    $smarty->assign('proxy',$proxy);
}
else
{
    $row = array();
    $smarty->assign('user',$row);
}
$smarty->display('email.tpl');

?>
