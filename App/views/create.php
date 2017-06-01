<h1>Creare account</h1>
<p><?=$err_message?></p>
<form enctype="multipart/form-data" method="post">
    Login:
    <br/>
    <input name="login" type="text" value="<?=$login?>"/>
    <br/>
    Mail:
    <br/>
    <input name="email" type="text" value="<?=$email?>"/>
    <br/>
    Password:
    <br/>
    <input name="password" type="password"/>
    <br/>
    Password2:
    <br/>
    <input name="password-dublicate" type="password"/>
    <br/>
    <p><input type="file" name="avatar">
    <br/>
    <br/>
    <input type="submit" value="Register"/>
    <br/>
    <a href="/login">I have account</a>
</form>

<?php
include "App/views/tpl/footer.tpl";
?>