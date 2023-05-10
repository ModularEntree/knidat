<?php if(!isset($_SESSION["ID_User"])) {session_start();}; ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <title>KniDat</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/assets/style/style.css" rel="stylesheet">
    <link href="/assets/style/style_temp.css" rel="stylesheet">
    <link href="/assets/style/style_reg.css" rel="stylesheet">
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
            if(isset($_SESSION["ID_User"])) {
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
    <div class="header">
        <h2>Přihlášení uživatele</h2>
    </div>
    <div id="content">
        <form method="post">
            <fieldset>
                <legend>Přihlašovací údaje</legend>
                <div>
                    <label for="usernameID">Uživatelské jméno:</label>
                    <input type="text" id="usernameID" name="username" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
                <div>
                    <label for="passwordID">Heslo:</label>
                    <input type="password" id="passwordID" name="password" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
            </fieldset>
            <div class="submit">
                <input type="submit" value="Potvrdit">
            </div>
            <p class="error">
                <?php
                $MAIN = new main("logUser",0);
                if (isset($_POST["username"])) {
                    echo "<script type=\"text/javascript\">window.location.href = '/';</script>";
                }
                ?>
            </p>
            <p><a href="/db/user/reg/">Nemáte účet?</a></p>
        </form>
    </div>
</main>
<footer>
    <p style="font-size: 1em">Toto je školní projekt.</p>
    <p style="font-size: .8em">Stránka není plně funkční a slouží pouze jako předvedení mých schopností.</p>
    <p style="font-size: .5em">Filip Bednář</p>
</footer>
</body>
</html>