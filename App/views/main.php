<?php


//$input					- ����� ��� ��������������
//$result					- ���������
//$canUseSecretFunctions	- ����� �� ������ ��������� ��������������
?>
<h1>������!</h1>
<form method="post">
    ����� ��� ��������������:
    <br/>
    <input name="input" type="text" value="<?=$input?>"/>
    <br/>
    <? if ($result != null): ?>
    ���������: <b><?=$result?></b>
<br/>
    <? endif ?>
        <input type="submit" name="normal" value="������� ��������������"/>
        <br/>
<!--    --><?//print_r($vars)?>
    <? if ($canUseSecretFunctions): ?>
        <input type="submit" name="secret" value="��������� ��������������"/>
    <? else: ?>
        <input type="submit" value="��������� ��������������" disabled="disabled" />
        <em>�������� �� ����</em>
    <? endif ?>
    <br/>
    <br/>
    <a href="/login">����� �����������</a>
</form>


<?php //echo $user['email']; ?><!--</p>-->



<?php
include "App/views/tpl/footer.tpl";
?>