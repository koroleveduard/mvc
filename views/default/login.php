<?php if (!empty($errors)) :?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error) :?>
                <li><?=$error;?></li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>

<form method="POST" action="?">
    Логин: <input type="text" name="login">
    Пароль: <input type="password" name="password">
    <input type="submit" value="Войти">
</form>