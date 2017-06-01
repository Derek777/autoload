<h1>Login</h1>

<!--<form action="/login" method="post">-->
<!--    <label>Login</label><input type="text" name="login" value="--><?//=$login?><!--"/><br>-->
<!--    <label>Password</label><input type="text" name="password"><br>-->
<!--    <label></label><input type="submit">-->
<!--</form>-->
<h1>Авторизация</h1>
<form method="post">
    Логин:
    <br/>
    <input name="login" type="text" value="<?=$login?>"/>
    <br/>
    Пароль:
    <br/>
    <input name="password" type="password"/>
    <br/>
<!--    <input type="checkbox" name="remember" /> запомнить меня-->
    <br/>
    <input type="submit" value="Войти"/>
    <a href="/create">Create Account</a>
    <br/>
    <br/>
    <a href="/">Главная страница</a>
</form>

<?php
include "App/views/tpl/footer.tpl";
?>
