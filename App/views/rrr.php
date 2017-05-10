<?php


//$input					- текст для преобразования
//$result					- результат
//$canUseSecretFunctions	- можно ли делать секретное преобразование
?>
<h1>Привет!</h1>
<form method="post">
    Текст для преобразования:
    <br/>
    <input name="input" type="text" value="<?=$input?>"/>
    <br/>
    <? if ($result != null): ?>
    Результат: <b><?=$result?></b>
<br/>
    <? endif ?>
        <input type="submit" name="normal" value="Обычное преобразование"/>
        <br/>
    <? if ($canUseSecretFunctions): ?>
        <input type="submit" name="secret" value="Секретное преобразование"/>
    <? else: ?>
        <input type="submit" value="Секретное преобразование" disabled="disabled" />
        <em>доступно не всем</em>
    <? endif ?>
    <br/>
    <br/>
    <a href="/login">Форма авторизации</a>
</form>
<?php
include "App/views/tpl/footer.tpl";
?>