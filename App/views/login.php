<h1>Login</h1>

<!--<form action="/login" method="post">-->
<!--    <label>Login</label><input type="text" name="login" value="--><?//=$login?><!--"/><br>-->
<!--    <label>Password</label><input type="text" name="password"><br>-->
<!--    <label></label><input type="submit">-->
<!--</form>-->
<h1>�����������</h1>
<form method="post">
    �����:
    <br/>
    <input name="login" type="text" value="<?=$login?>"/>
    <br/>
    ������:
    <br/>
    <input name="password" type="password"/>
    <br/>
<!--    <input type="checkbox" name="remember" /> ��������� ����-->
    <br/>
    <input type="submit" value="�����"/>
    <a href="/create">Create Account</a>
    <br/>
    <br/>
    <a href="/">������� ��������</a>
</form>

<?php
include "App/views/tpl/footer.tpl";
?>
