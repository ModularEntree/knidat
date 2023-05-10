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
        <h2>Registrace uživatele</h2>
    </div>
    <div id="content">
        <form method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Základní informace</legend>
                <div>
                    <label for="realNameID">Jméno:</label>
                    <input type="text" id="realNameID" name="realName" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
                <div>
                    <label for="realSurnameID">Přijmení:</label>
                    <input type="text" id="realSurnameID" name="realSurname" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
                <div>
                    <label for="usernameID">Uživatelské jméno:</label>
                    <input type="text" id="usernameID" name="username" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
            </fieldset>
            <fieldset>
                <legend>Citlivé údaje</legend>
                <div>
                    <label for="dateOfBirthID">Datum narození:</label>
                    <input type="date" id="dateOfBirthID" name="dateOfBirth" required>
                </div>
                <div>
                    <label for="genderID">Pohlaví:</label>
                    <select name="gender" id="genderID" required>
                        <option value="">-- Vyberte --</option>
                        <option value="1">Muž</option>
                        <option value="2">Žena</option>
                        <option value="3">Ostatní</option>
                    </select>
                </div>
                <div>
                    <label for="countryID">Bydliště (země):</label>
                    <select name="country" id="countryID" required>
                        <option value="">-- Vyberte --</option>
                        <option value="1">Česká republika</option>
                        <option value="2">Japonsko</option>
                        <option value="3">Nigérie</option>
                    </select>
                </div>
                <div>
                    <label for="languageID">Jazyk (primární):</label>
                    <select name="language" id="languageID" required>
                        <option value="">-- Vyberte --</option>
                        <option value="1">Angličtina</option>
                        <option value="2">Čeština</option>
                        <option value="3">Japonština</option>
                    </select>
                </div>
            </fieldset>
            <fieldset>
                <legend>Biografie</legend>
                <div>
                    <label for="bioID">Biografie (není nutná):</label>
                    <input type="text" id="bioID" name="bio" maxlength="450" placeholder="Max. 450 znaků">
                </div>
            </fieldset>
            <fieldset>
                <legend>Profilová fotografie (musí být čtverec, max. 20 MB, pouze JPG)</legend>
                <div>
                    <input type="hidden" name="MAX_FILE_SIZE" value="20000000" required>
                    <input type="file" name="pfp" id="pfpID" accept="image/jpeg">
                </div>
            </fieldset>
            <fieldset>
                <legend>Heslo</legend>
                <div>
                    <label for="passwordID">Heslo:</label>
                    <input type="password" id="passwordID" name="password" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
                <div>
                    <label for="passwordAID">Heslo (znova):</label>
                    <input type="password" id="passwordAID" name="passwordA" maxlength="50" placeholder="Max. 50 znaků" required>
                </div>
            </fieldset>
            <div class="submit">
                <input type="submit" value="Potvrdit">
            </div>
            <p class="error">
                <?php
                $MAIN = new main("regUser",0);
                if (isset($_POST["dateOfBirth"])) {
                    echo "<script type=\"text/javascript\">
                        window.location.href = '/db/user/reg/';
                    </script>";
                }
                ?>
            </p>
            <p><a href="/db/user/log/">Máte již účet?</a></p>
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