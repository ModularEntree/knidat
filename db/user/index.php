<?php if(!isset($_COOKIE["ID_User"])) setcookie("ID_User", 0, time() + (86400 * 30), '/'); ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>KniDat</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/style/style.css" rel="stylesheet">
    <link href="/assets/style/style_db_hub.css" rel="stylesheet">
</head>
<body>
<header>
    <div class="start">
        <div class="logo">
            <p><a href="/">KniDat</a></p>
        </div>
        <div class="user">
            <?php
            require($_SERVER['DOCUMENT_ROOT'] . "/assets/php/main.php");
            $MAIN = new main(0, 0);
            if($_COOKIE["ID_User"]!=0) {
                $info = ($MAIN->__construct("infoUser", 0));
            }
            else
                echo '<div><p><a href="/db/user/log/">Přihlásit se</a> | <a href="/db/user/reg/">Zaregistrovat se</a></p></div>';
            ?>
        </div>
    </div>
    <nav>
        <ul>
            <li>
                <a href="/">Domů</a>
            </li>
            <li>
                <a href="/db/book/">Databáze knih</a>
            </li>
            <li>
                <a href="/db/user/">Databáze uživatelů</a>
            </li>
        </ul>
    </nav>
</header>
<main>
    <br>
    <div class="list">
        <?php
        $MAIN = new main(0, 0);
        $MAIN->__construct("dbUsers", 0);
        ?>
    </div>
    <br>
</main>
<footer>
    <p style="font-size: 1em">Toto je školní projekt.</p>
    <p style="font-size: .8em">Stránka není plně funkční a slouží pouze jako předvedení mých schopností.</p>
    <p style="font-size: .5em">Filip Bednář</p>
</footer>
</body>
</html>