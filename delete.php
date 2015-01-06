<?php

require 'auth.php';
require 'adminaccess.php';

$name = $_GET['name'];

if ( !preg_match('/^[0-9]{3,4}/', $name) ) return;

switch( $_GET['s'] )
{
    case 'user':
        $sql = "INSERT INTO `sip_deleted` SELECT `name`,`fullname`,`fio`,`context`,`secret` FROM `sip_users` WHERE `name` = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($name)) or die( $sql );

        $sql = "DELETE FROM `sip_users` WHERE `name` = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($name)) or die( $sql );

        $ami->login();
        $r = $ami->sendCommand("Action: Command\r\nCommand: sip prune realtime peer $nameold\r\n\r\n");

        Header("Location: .");
        break;

    case 'ext':
        $sql = "DELETE FROM `sip_extensions` WHERE `name` = ?";
        $sth = $dbh->prepare($sql);
        $sth->execute(array($name)) or die( $sql );
        Header("Location: .");
        break;

    default:
        break;
}

?>
