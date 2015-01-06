<?php

require 'auth.php';
require 'adminaccess.php';


function modify_user()
{
    global $dbh,$ami;
    $name = $_POST['name'];
    $nameold = $_POST['nameold'];

    if ( !preg_match('/^[0-9]{3,4}/', $name) ) return;

    $args = array($name,              $name,          $name,
                  $_POST['fullname'], $_POST['fio'],  $_POST['context'], $_POST['accountcode']);

    if ( $nameold != '' )
    {
        $sql = "UPDATE `sip_users` SET
                    `name`     = ?, `defaultuser` = ?, `cid_number` = ?,
                    `fullname` = ?, `fio`         = ?, `context`    = ?, `accountcode` = ?";

        if ( $_POST['secretnew'] != '' )
        {
            $sql .= ",`secret` = ? ";
            $args[] = $_POST['secretnew'];
        }

        $sql .= "WHERE `name` = ?";
        $args[] = $nameold;
    }
    else
    {
        $sql = "INSERT INTO `sip_users` (`name`,`defaultuser`,`cid_number`,`fullname`,`fio`,`context`,`accountcode`,`secret`) VALUES(?,?,?,?,?,?,?,?)";
        $args[] = $_POST['secretnew'];
    }
    $sth = $dbh->prepare($sql);
    $sth->execute($args) or die( $sql );

    $ami->login();
    $r = $ami->sendCommand("Action: Command\r\nCommand: sip prune realtime peer $nameold\r\n\r\n");
    $r = $ami->sendCommand("Action: Command\r\nCommand: sip show peer $name load\r\n\r\n");

    Header("Location: .");
}

function modify_extension()
{
    global $dbh;
    $name = $_POST['name'];
    $nameold = $_POST['nameold'];

    if ( !preg_match('/^[0-9]{3,4}/', $name) ) return;

    $args = array($name, $_POST['fullname']);

    if ( $nameold != '' )
    {
        $sql = "UPDATE `sip_extensions` SET `name` = ?, `comment` = ? WHERE `name` = ?";
        $args[] = $nameold;
    }
    else
    {
        $sql = "INSERT INTO `sip_extensions`(`name`,`comment`) VALUES(?,?)";
    }
    $sth = $dbh->prepare($sql);
    $sth->execute($args) or die( $sql );

    Header("Location: .");
}

if ( $_POST['reserved'] == 'on' )
    modify_extension();
else
    modify_user();

?>
