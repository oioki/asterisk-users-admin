<?php

require('auth.php');
require('adminaccess.php');

$smarty->assign('section',$_GET['s']);
$smarty->assign('reserved', 0);

switch($_GET['s'])
{
    case 'ext':
        if ( (isset($_GET['name'])) and ($_GET['name']!='') )
        {
            $sql = "SELECT * FROM `sip_extensions` WHERE `name` = ? LIMIT 1";
            $sth = $dbh->prepare($sql);
            $sth->execute(array($_GET['name'])) or die( $sql );
            $row = $sth->fetch();
            if ( $row )
            {
                $smarty->assign('reserved', 1);
                $row['fullname'] = $row['comment'];
            }
        }
        else
        {
            $row = array();
        }
        $smarty->assign('user', $row);

        $smarty->display('edit_user.tpl');
        break;

    case 'user':
        $sql = "SELECT * FROM `sip_contexts` ORDER BY `contextnumber`,`contextlevel`";
        $sth = $dbh->prepare($sql);
        $sth->execute() or die( $sql );

        $contexts = array();
        $comments = array();
        while ( $row=$sth->fetch() )
        {
            $contexts[] = $row['contextname'];
            $comments[] = "${row['contextnumber']} - ${row['contextcomment']} (${row['contextname']})";
        }
        $smarty->assign('contextscomments', $comments);
        $smarty->assign('contexts', $contexts);

        if ( (isset($_GET['name'])) and ($_GET['name']!='') )
        {
            $sql = "SELECT * FROM `sip_users` WHERE `name` = ? LIMIT 1";
            $sth = $dbh->prepare($sql);
            $sth->execute(array($_GET['name'])) or die( $sql );
            $row = $sth->fetch();
        }
        else
        {
            $row = array();
        }
        $smarty->assign('user',$row);

        $smarty->display('edit_user.tpl');
        break;
    default:
        Header('Location: .');
}

?>
