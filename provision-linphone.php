<?php

if ( $_SERVER['PATH_INFO'] == '' )
{
    require('auth.php');
    require('adminaccess.php');

    if ( (isset($_GET['name'])) and ($_GET['name']!='') )
    {
        $sql = "SELECT * FROM `sip_users` WHERE `name` = ? LIMIT 1";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($_GET['name'])) or die( $sql );

        $row = $sth->fetch();
        $smarty->assign('user',$row);
    }
    else
    {
        $row = array();
        $smarty->assign('user',$row);
    }

    $smarty->assign('proxy', $proxy);
    $data = $smarty->fetch("provision-linphone.xml");

    $hash = uniqid();
    $filename = md5("$salt/$hash.xml");
    file_put_contents("cache/$filename", $data);
    $href = "http://$proxy${_SERVER['PHP_SELF']}/$hash.xml";
    $smarty->assign('href', $href);

    $smarty->display('provision-linphone.tpl');
}
else
{
    require 'init.php';

    $hash = $_SERVER['PATH_INFO'];
    $filename = md5($salt.$hash);

    header('Content-Type: text/xml');

    echo file_get_contents("cache/$filename");

    unlink("cache/$filename");
}

?>
