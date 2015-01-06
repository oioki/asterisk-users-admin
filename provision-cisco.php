<?php

if ( $_SERVER['PATH_INFO'] == '' )
{
    require('auth.php');
    require('adminaccess.php');

    $ip = $_POST['ip'];
    $name = $_POST['name'];

    $sql = "SELECT * FROM `sip_users` WHERE `name` = ?";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($name)) or die( $sql );
    $row = $sth->fetch();
    $fullname = $row['fullname'];
    $secret = $row['secret'];

    $smarty->assign('name',$name);
    $smarty->assign('proxy',$proxy);
    $smarty->assign('fullname',$fullname);
    $smarty->assign('secret',$secret);

    $data = $smarty->fetch("provision-cisco.xml");
    $hash = uniqid();
    $filename = md5("$salt/$hash.xml");
    file_put_contents("cache/$filename", $data);

    $href = "http://$ip/admin/resync?http://$proxy${_SERVER['PHP_SELF']}/$hash.xml";
    $smarty->assign('href', $href);

    $smarty->display("provision-cisco.tpl");
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
