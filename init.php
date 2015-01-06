<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;

$smarty->configLoad('app.conf','global');
$proxy = $smarty->getConfigVariable('proxy');
$salt = $smarty->getConfigVariable('salt');

$smarty->configLoad('app.conf','database');
$dbhost = $smarty->getConfigVariable('host');
$dbuser = $smarty->getConfigVariable('user');
$dbpass = $smarty->getConfigVariable('pass');
$dbname = $smarty->getConfigVariable('name');

$smarty->configLoad('app.conf','ami');
$ami_Host = $smarty->getConfigVariable('host');
$ami_Port = $smarty->getConfigVariable('port');
$ami_User = $smarty->getConfigVariable('user');
$ami_Pass = $smarty->getConfigVariable('pass');

$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");
$dbh->query('SET NAMES utf8');

require 'ami.php';
$ami = new AMI($ami_Host, $ami_Port, $ami_User, $ami_Pass);

$smarty->assign('sitename', "asterisk-users-admin @ ".gethostname());


require 'locations.php';

function ip2location($ip_my)
{
    global $locations;
    if ( $ip_my == '' ) return "";
    foreach ($locations as $ip => $location)
        if ( strpos($ip_my, $ip) !== false ) return "$location";
    return "Unknown";
}

?>
