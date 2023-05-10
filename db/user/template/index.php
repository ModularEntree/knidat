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
            $info = ($MAIN->__construct("infoUserSpec", ($ID_User = explode("/",$_SERVER["REQUEST_URI"],PHP_INT_MAX))[($arr = count($ID_User)-2)]));
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
        <h2><?php echo $info["0"]["username"]; ?></h2>
    </div>
    <div id="content">
        <div id="sidebar">
            <div>
                <img src="pfp.jpg" alt="Profile picture was not found">
            </div>
            <div>
                <div>
                    <h3>Status</h3>
                </div>
                <div>
                    <div>
                        <p>Poslední úprava:
                            <?php
                            if($info["0"]["lastUpdate"]!="Chybí")
                                echo '<a href="/db/book/' . $info["0"]["ID_Book"].'/">'.$info["0"]["lastUpdate"].'</a>';
                            else
                                echo 'Žádná';
                            ?>
                        </p>
                        <p>Průměrné hodnocení: <?php echo $info["0"]["avgRat"]; ?></p>
                        <p>Pocet knih: <?php echo $info["0"]["noBookAll"]; ?></p>
                        <p>Pocet kapitol: <?php echo $info["0"]["noChapAll"]; ?></p>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <h3>Informace</h3>
                </div>
                <div>
                    <div>
                        <p>Pravé jméno: <?php echo $info["0"]["name"] . " " . $info["0"]["surname"]; ?></p>
                        <p>Datum narození: <?php echo date("d. m. Y", strtotime($info["0"]["dateOfBirth"])); ?></p>
                        <p>Pohlaví: <?php echo $info["0"]["gender"]; ?></p>
                        <p>Jazyk: <?php echo $info["0"]["language"]; ?></p>
                        <p>Bydliště: <?php echo $info["0"]["country"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div id="main-con">
            <div>
                <p>
                    <a href="/">Domů</a>
                    >
                    <a href="/db/user/">Uživatelé</a>
                    >
                    <a href="/db/user/<?PHP echo $info["0"]["ID_User"]; ?>/"><?php echo $info["0"]["username"]; ?></a>
                </p>
            </div>
            <div>
                <div>
                    <h3>Biografie</h3>
                </div>
                <div>
                    <?php if(!($info["0"]["bio"] == "<p></p>")) echo $info["0"]["bio"]; else echo "<p>Žádná biografie nebyla zapsána.</p>"; ?>
                </div>
            </div>
            <div>
                <div>
                    <h3>Knihy</h3>
                </div>
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Název knihy</th>
                                <th>Hodnocení</th>
                                <th>Status</th>
                                <th>Počet knih</th>
                                <th>Počet kapitol</th>
                            </tr>
                        </thead>
                        <?php
                        $MAIN = new main(0, 0);
                        $usersID = ($ID_User = explode("/",$_SERVER["REQUEST_URI"],PHP_INT_MAX))[($arr = count($ID_User)-2)];
                        $MAIN->__construct("usersBooks", $usersID);
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>
    <p style="font-size: 1em">Toto je školní projekt.</p>
    <p style="font-size: .8em">Stránka není plně funkční a slouží pouze jako předvedení mých schopností.</p>
    <p style="font-size: .5em">Filip Bednář</p>
</footer>
</body>
</html>