<?php

require('authcommon.php');

function do_login()
{
    $fd = fopen('logs/auth.log','a');
    fwrite($fd,date("Y-m-d H:i:s")." - ${_POST['login']} - ");
    if ( check_credentials($_POST['login'],$_POST['pass']) > 0 )
    {
        fwrite($fd,"OK\n");
        SetCookie("auth",$_POST['login'].":".$_POST['pass'],time()+3600*24);
        Header("Location: .");
    }
    else
    {
        fwrite($fd,"FAIL\n");
        Header("Location: login.html");
    }
    fclose($fd);
}

function do_logout()
{
    SetCookie("auth","",time()-3600);
    Header("Location: login.html");
}

if ( $_POST['action'] == 'login' )
{
    do_login();
}
else
if ( $_POST['action'] == 'logout' )
{
    do_logout();
}

?>
