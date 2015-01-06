<?php

$admin = 0;

include('init.php');

function md5crypt($password)
{
    // create a salt that ensures crypt creates an md5 hash
    $base64_alphabet='ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                    .'abcdefghijklmnopqrstuvwxyz0123456789+/';
    $salt='$1$';
    for($i=0; $i<9; $i++){
        $salt.=$base64_alphabet[rand(0,63)];
    }
    // return the crypt md5 password
    return crypt($password,$salt.'$');
}

function check_credentials($login,$plainpassword)
{
    global $dbh,$admin;

    $sql = "SELECT `id`,`pass`,`admin` FROM `sip_admins` WHERE `login` = ? LIMIT 1";
    $sth = $dbh->prepare($sql);
    $sth->execute(array($login)) or die( $sql );
    $row = $sth->fetch();

    $admin = $row['admin'];
    $hash = $row['pass'];

    $salt = substr($hash,0,12);
    $password = crypt($plainpassword,$salt);

    return ( $password == $hash ) ? $row['id'] : 0;
}

?>
