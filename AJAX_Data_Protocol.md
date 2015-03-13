# Protocol #
Request MUST have parameters `action`, `sid` (with exception of login action) and MAY have any number of additional parameters.
Sid is a current session identifier. It is generated on login and stored in cookies.
Action SHOULD be assigned the following values:
  * `login`
  * `logout`
  * `checkSID`
  * `getItemList`
  * `getUpdateList`
  * `getItemProps`
  * `setItemProps`
  * `addItem`
  * `delItem`
  * `registerUser`
  * `deleteUser`

Depending on action, additional parameters MAY be reqired.

## Normal Operation ##

Depending on the request, corresponding reply is formed. Parameters and normal replies are listed in table below. Reply and request are listed in JSON.
Request messages are in JSON and passed in POST body with content-type application/json .
Reply messages are also in JSON and are passed in HTTP body with content-type application/json.

| Action | Request | Normal reply |
|:-------|:--------|:-------------|
| `login` | `{action:login,user:"str",pass:"str")}` | `<sid>` |
| `logout` | `{action:logout,sid:<sid>}` | _null_ |
| `checkSID` | `{action:checkSID,sid:<sid>}` | `<timestamp>` |
| `getItemList` | `{action:getItemList,sid:<sid>}` | `[id1,...,idN]`<br>where idN is id of N-th item for a given user <br>
<tr><td> <code>getUpdateList</code> </td><td> <code>{action:getItemList,sid:&lt;sid&gt;,time:&lt;timestamp&gt;}</code> </td><td> <code>{time:&lt;new_timestamp&gt;,items:[id1,...,idN]}</code><br>where idN is id of N-th item for a given user </td></tr>
<tr><td> <code>getItemProps</code> </td><td> <code>{action:getItemProps,sid:&lt;sid&gt;,iid:&lt;item_id&gt;,props:[name1,...,nameN]}</code><br>where nameN is property name to be acquired </td><td> <code>{name1:"value1",...,nameN:"valueN"}</code> </td></tr>
<tr><td> <code>setItemProps</code> </td><td> <code>{action:setItemProps,sid:&lt;sid&gt;,iid:&lt;item_id&gt;,props:{name1:"value1",...,nameN:"valueN"}}</code><br>where nameN is property name to be set </td><td> <i>null</i> </td></tr>
<tr><td> <code>addItem</code> </td><td> <code>{action:addItem,sid:&lt;sid&gt;}</code> </td><td> <code>&lt;item_id&gt;</code> </td></tr>
<tr><td> <code>delItem</code> </td><td> <code>{action:delItem,sid:&lt;sid&gt;,iid:&lt;item_id&gt;}</code> </td><td> <i>null</i> </td></tr>
<tr><td> <code>registerUser</code> </td><td> <code>{action:registerUser,user:"str",email:"str",pass:"str"}</code> </td><td> <i>null</i> </td></tr>
<tr><td> <code>deleteUser</code> </td><td> <code>{action:deleteUser,sid:&lt;sid&gt;,user:"str",email:"str",pass:"str"}</code> </td><td> <i>null</i> </td></tr></tbody></table>

<h2>Error reporting</h2>

Error reporting MAY be done using HTTP status codes. Normal reply is expected if status code is 200 OK, and error report if status is 500 Internal Server Error. Else, client SHOULD throw an error and stop.<br>
Error report reply MUST contain an integer field <code>errcode</code>. It also MAY contain one or more additional fields, depending on <code>errcode</code> value.<br>
Possible error codes are listed below along with description.<br>
<br>
<table><thead><th> Name </th><th> Value </th><th> Description </th></thead><tbody>
<tr><td>ERR_NO_MSG</td><td>1 </td><td>Returned when there is no 'message' parameter in POST</td></tr>
<tr><td>ERR_NO_ACT</td><td>2 </td><td>Returned when message does not have 'action' property</td></tr>
<tr><td>ERR_LOGIN</td><td>3 </td><td>Returned if login is failed: user/pass do not match or there is no requested user at all</td></tr>
<tr><td>ERR_DB</td><td>4 </td><td>Returned whenever there are database problems on server</td></tr>
<tr><td>ERR_NO_SID</td><td>5 </td><td>Sid expired, never existed, or was not provided at all</td></tr>
<tr><td>ERR_NO_IID</td><td>6 </td><td>No itemID provided</td></tr>
<tr><td>ERR_NO_USER</td><td>7 </td><td>No username provided</td></tr>
<tr><td>ERR_NO_EMAIL</td><td>8 </td><td>No email provided</td></tr>
<tr><td>ERR_NO_PASS</td><td>9 </td><td>No password provided</td></tr>
<tr><td>ERR_NO_PROPS</td><td>10</td><td>No props to set or read specified</td></tr>
<tr><td>ERR_USER_EXISTS</td><td>11</td><td>On registration, such username already exists</td></tr>
<tr><td>ERR_DELE_FAIL</td><td>12</td><td>Failed to delete user. Invalid data most probable</td></tr>