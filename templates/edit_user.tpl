{config_load file="app.conf" section="global"}
{include file="header.tpl" title="Edit user"}

<FORM ACTION="modify.php" METHOD=POST>
<INPUT TYPE="hidden" NAME="s" VALUE="user">
<table>

<INPUT TYPE="hidden" NAME="nameold" VALUE="{$user.name}">
{include file="inputbox.tpl" title="SIP ext"     name="name"        value=$user.name}
<tr><td>Reserved:</td><td><INPUT TYPE="checkbox" NAME="reserved" {if $reserved}checked{/if}/></td></tr>
{include file="inputbox.tpl" title="Full Name"   name="fullname"    value=$user.fullname}
{if not $reserved}
{include file="inputbox.tpl" title="FIO"         name="fio"         value=$user.fio}
<tr><td>Context:</td><td><SELECT NAME="context" ID="context">{html_options values=$contexts selected={$user.context} output=$contextscomments}</SELECT></td></tr>
{include file="inputbox.tpl" title="AccountCode" name="accountcode" value=$user.accountcode}
{include file="inputbox.tpl" title="Password (new)"    name="secretnew" value=''}
<tr>
<td>Secret (old):</td>
<td><INPUT SIZE=60 TYPE="text" READONLY NAME="secret" VALUE="{$user.secret}"></td>
</tr>
{/if}

</table>


<INPUT TYPE="submit" NAME="save" VALUE="Save and Apply">
</FORM>

<hr>

{include file="footer.tpl"}
