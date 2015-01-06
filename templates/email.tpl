<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>E-mail for new user</title>
</head>

<body style='font-size: 16px'>

<b><pre>
SIP account {$user.name} for {$user.fio}
</pre></b>
<pre>
Dear {$user.shortname},
Here are credentials for your new SIP account.
---
Username:  {$user.name}
Password:  {$user.secret}
SIP proxy: {$proxy}
Access level: {$user.contextcomment}
---
Dialing rules:
Internal call        XX / XXX / XXXX
{if $user.contextlevel gt 0}City call            9 + XXXXXXX
{/if}
{if $user.contextlevel gt 1}Country call         9 + city code + XXXXXXX
{/if}
{if $user.contextlevel gt 2}International call   9 + 810 + country code + city code
{/if}
{if $user.contextlevel gt 0}Your contact number  +7 495 {$user.contextnumber} ext. {$user.name}
{else}
Your contact number  +7 495 0000000 ext. {$user.name}
{/if}
</pre>

<FORM><INPUT TYPE="BUTTON" VALUE="Go back" ONCLICK="history.go(-1)"></FORM>

</body>
</html>
