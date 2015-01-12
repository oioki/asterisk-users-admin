{config_load file="app.conf" section="global"}
{include file="header.tpl" title="users"}

<script type="text/javascript">
function confirmDel(name) { return confirm("Are you sure you want to delete this extension?\n«"+name+"»"); }
function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}
function provision(name) {
  ip = prompt('Please enter phone IP address');
  console.debug(ip)
  if ( ip )
  {
    post_to_url('provision-cisco.php', { 'ip' : ip, 'name' : name });
  }
}
</script>

<table class="info">
<thead>
<td width="2%">Ext</td>
<td width="16%">Displayed CallerID</td>
<td width="20%">Full name of user</td>
<td width="18%">Context</td>
<td>AccountCode</td>
<td>Address</td>
<td>Location</td>
<td>User Agent</td>
<td>Registered Since</td>
<td width=100>Actions</td>
</thead>
<tbody>
{foreach from=$users item=item}
{if $item.type eq 'ext'}
<tr class="header">
<td>{$item.name}</td><td colspan="8">{$item.comment}</td>
<td nowrap>
<a href="edit.php?s=ext&name={$item.name}"><img src="static/edit.png"/></a>
<a style="float:right" href="delete.php?s=ext&name={$item.name}" onclick="return confirmDel('{$item.comment}')"><img src="static/delete.png"/></a>
</td>
{else}
<tr{if $item.native eq '0'} class="nonnative"{/if}>
<td><center>{$item.name}</center></td>
<td>{$item.fullname}</td>
<td>{$item.fio}</td>
<td>{$item.contextnumber} - {$item.contextcomment}</td>
<td>{$item.accountcode}</td>
<td class="static">{if $item.ipaddr}
{if $item.host ne 'dynamic'}<b>{/if}
{if $item.interip}
{$item.ipaddr}:{$item.port}<br/>
<a href="http://{$item.interip}/admin/advanced">{$item.interip}:{$item.port}</a>
{else}
<a href="http://{$item.ipaddr}/admin/advanced">{$item.ipaddr}:{$item.port}</a>
{/if}
{if $item.host ne 'dynamic'}</b>{/if}
{else}
not registered<br>
{/if}
</td>
<td class="static">{$item.location}</td>
<td class="static">{$item.useragent}</td>
<td class="static">{if $item.regseconds}{$item.regtime}{else}Unknown{/if}</td>
<td nowrap>
<a href="edit.php?s=user&name={$item.name}"><img src="static/edit.png"/></a>
<a href="email.php?name={$item.name}"><img src="static/mail.png"/></a>
<a href="#" onclick="provision({$item.name})"><img src="static/provision.png"/></a>
<a href="provision-linphone.php?name={$item.name}"><img src="static/linphone.png"/></a>
<a href="delete.php?s=user&name={$item.name}"  onclick="return confirmDel('{$item.fio}')"><img src="static/delete.png"/></a>
</td>
{/if}
</tr>
{/foreach}
</tbody>
</table>

<hr>

<FORM ACTION="edit.php" METHOD=GET>
<INPUT TYPE="hidden" NAME="s" VALUE="user">
<INPUT TYPE="submit" VALUE="Add user">
</FORM>

<hr>

{include file="footer.tpl"}
