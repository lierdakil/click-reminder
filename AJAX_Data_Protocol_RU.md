# Введение #

Система строится на модели запрос-ответ: фронтенд ("клиент") посылает запросы, а бэкенд ("сервер"), в зависимости от данных, полученных в запросе, возвращает соответствующий ситуации ответ или сообщение об ошибке. При этом сервер не может слать запросы клиенту: это ограничение связано с техническими ограничениями парадигмы AJAX.

# Общий формат сообщений #

Запросы ДОЛЖНЫ содержать параметр `action`. Так же, в зависимости от параметра `action` запросы могут быть ДОЛЖНЫ содержать любые другие параметры.

В параметре `action` СЛЕДУЕТ передавать одну из следующих величин:

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

## Формат запросов и ожидаемые ответы ##

Запросы представляют из себя JSON-строки, передаваемые в теле запроса POST с заголовком content-type: application/json.

Ответы так же являются JSON-строками и передаются в теле HTTP-ответа с заголовком content-type: application/json.

| Action | Запрос | Ожидаемый ответ |
|:-------|:-------------|:------------------------------|
| `login` | `{action:login,user:"str",pass:"str")}` | `<sid>` |
| `logout` | `{action:logout,sid:<sid>}` | _null_ |
| `checkSID` | `{action:checkSID,sid:<sid>}` | `<timestamp>` |
| `getItemList` | `{action:getItemList,sid:<sid>}` | `[id1,...,idN]`<br>idN -- численный уникальный идентификатор N-того элемента <br>
<tr><td> <code>getUpdateList</code> </td><td> <code>{action:getItemList,sid:&lt;sid&gt;,time:&lt;timestamp&gt;}</code> </td><td> <code>{time:&lt;new_timestamp&gt;,items:[id1,...,idN]}</code><br>idN -- численный уникальный идентификатор N-того элемента </td></tr>
<tr><td> <code>getItemProps</code> </td><td> <code>{action:getItemProps,sid:&lt;sid&gt;,iid:&lt;item_id&gt;,props:[name1,...,nameN]}</code><br>где nameN -- название свойств, которые требуется получить </td><td> <code>{name1:"value1",...,nameN:"valueN"}</code> </td></tr>
<tr><td> <code>setItemProps</code> </td><td> <code>{action:setItemProps,sid:&lt;sid&gt;,iid:&lt;item_id&gt;,props:{name1:"value1",...,nameN:"valueN"}}</code><br>где nameN название свойства, которому должно быть присвоено значение valueN </td><td> <i>null</i> </td></tr>
<tr><td> <code>addItem</code> </td><td> <code>{action:addItem,sid:&lt;sid&gt;}</code> </td><td> <code>&lt;item_id&gt;</code> </td></tr>
<tr><td> <code>delItem</code> </td><td> <code>{action:delItem,sid:&lt;sid&gt;,iid:&lt;item_id&gt;}</code> </td><td> <i>null</i> </td></tr>
<tr><td> <code>registerUser</code> </td><td> <code>{action:registerUser,user:"str",email:"str",pass:"str"}</code> </td><td> <i>null</i> </td></tr>
<tr><td> <code>deleteUser</code> </td><td> <code>{action:deleteUser,sid:&lt;sid&gt;,user:"str",email:"str",pass:"str"}</code> </td><td> <i>null</i> </td></tr></tbody></table>

Здесь <code>&lt;sid&gt;</code> -- буквенно-цифровой уникальный идентификатор текущей сессии, переданный клиенту при логине и хранящийся в кукисах.<br>
<br>
<code>&lt;item_id&gt;</code> -- уникальный целочисленный идентификатор элемента, полученный клиентом в ответ на запрос <code>getItemList</code> или <code>addItem</code> и хранящийся в свойствах объекта, являющегося визуальным представлением элемента.<br>
<br>
<code>&lt;timestamp&gt;</code> -- UNIX-время на сервере (с точностью до 0.0001 сек), получаемое клиентом в ответ на запрос checkSID и передаваемое при запросе обновлений <code>getUpdateList</code>. В ответ на запрос обновлений возвращаются только элементы, время создания или изменения которых <i>позже</i> переданного в параметре timestamp.<br>
<br>
<code>"str"</code> -- некая строка.<br>
<br>
<h2>Сообщения об ошибках</h2>

Сообщения об ошибках передаются с использованием кодов статуса HTTP. Нормальный ответ сервера передается с кодом статуса 200 OK. Если же произошла ошибка, статус устанавливается в 500 Internal Server Error. При любых других статусах поведение клиента неопределено.<br>
<br>
Отчет об ошибке представляет собой JSON-строку в теле HTTP ответа с с заголовком content-type: application/json. Он ДОЛЖЕН содержать целочисленное поле <code>errcode</code>. В зависимости от значения <code>errcode</code> так же может содержать другие поля.<br>
Возможные коды ошибок с описанием приведены ниже.<br>
<br>
<table><thead><th> Название </th><th> Значение </th><th> Описание </th><th> Запросы, вызывающие </th></thead><tbody>
<tr><td>ERR_NO_MSG</td><td>1 </td><td>Запрос не является JSON-строкой или пуст</td><td> <i>any</i> </td></tr>
<tr><td>ERR_NO_ACT</td><td>2 </td><td>Запрос не имеет параметра <code>action</code></td><td> <i>any</i> </td></tr>
<tr><td>ERR_LOGIN</td><td>3 </td><td>Невозможно войти: пользователя не существует или неверный пароль</td><td> <code>login</code> </td></tr>
<tr><td>ERR_DB</td><td>4 </td><td>Ошибка при запросе к базе данных</td><td> <i>any</i> </td></tr>
<tr><td>ERR_NO_SID</td><td>5 </td><td>Идентификатор сессии истек, не существует или не был передан</td><td> except <code>login</code>, <code>registerUser</code> </td></tr>
<tr><td>ERR_NO_IID</td><td>6 </td><td>Идентификатор элемента не был передан</td><td> <code>getItemProps</code>, <code>setItemProps</code>, <code>delItem</code> </td></tr>
<tr><td>ERR_NO_USER</td><td>7 </td><td>Не передано имя пользователя</td><td> <code>login</code>, <code>registerUser</code>, <code>deleteUser</code> </td></tr>
<tr><td>ERR_NO_EMAIL</td><td>8 </td><td>Не передан email</td><td> <code>registerUser</code>, <code>deleteUser</code> </td></tr>
<tr><td>ERR_NO_PASS</td><td>9 </td><td>Не передан пароль</td><td> <code>login</code>, <code>registerUser</code>, <code>deleteUser</code> </td></tr>
<tr><td>ERR_NO_PROPS</td><td>10</td><td>Не указаны свойства для чтения или записи</td><td> <code>getItemProps</code>, <code>setItemProps</code> </td></tr>
<tr><td>ERR_USER_EXISTS</td><td>11</td><td>Указанный логин существует</td><td> <code>registerUser</code> </td></tr>
<tr><td>ERR_DELE_FAIL</td><td>12</td><td>Не удалось удалить пользователя, наиболее вероятны неверные данные</td><td> <code>deleteUser</code> </td></tr>