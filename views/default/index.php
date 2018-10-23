<h1>DEFAULT ACTION</h1>

<p><a href="/default/logout">Выйти</a></p>
<p>Ваш счет: <?=$user->getBalance();?></p>

<?php if (!empty($errors)) :?>
<div class="error">
    <ul>
    <?php foreach ($errors as $error) :?>
        <li><?=$error;?></li>
    <?php endforeach;?>
    </ul>
</div>
<?php endif;?>

<?php if($user->getBalance() > 0):?>
<form action="" method="POST">
    Сумма: <input type="text" name="balance">
    <input type="submit" value="Списать">
</form>
<?php endif;?>