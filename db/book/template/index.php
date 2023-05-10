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
            $infoBook = ($MAIN->__construct("infoBook", ($ID_User = explode("/",$_SERVER["REQUEST_URI"],PHP_INT_MAX))[($arr = count($ID_User)-2)]));
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
        <h2><?PHP echo $infoBook[0]["name"]; ?></h2>
    </div>
    <div id="content">
        <div id="sidebar">
            <div>
                <img src="book.jpg" alt="Book picture was not found">
            </div>
            <div>
                <div>
                    <h3>Status</h3>
                </div>
                <div>
                    <div>
                        <?php
                        $bookStatus = ($MAIN->__construct("bookStatus", 0));
                        ?>
                        <p>Status: <span class="spec"><?PHP echo $bookStatus[0]["status"]; ?></span></p>
                        <p>Dokončené kapitoly: <?PHP echo $bookStatus[0]["noChapCmpl"]; ?></p>
                        <p>Dokončené knihy: <?PHP echo $bookStatus[0]["noBookCmpl"]; ?></p>
                        <p>Hodnocení: <?PHP echo $bookStatus[0]["rating"]; ?></p>
                    </div>
                </div>
            </div>
            <div>
                <div>
                    <h3>Informace</h3>
                </div>
                <div>
                    <div>
                        <p>Původní název: <?PHP echo $infoBook[0]["origName"]; ?></p>
                        <p>Počet kapitol: <?PHP echo $infoBook[0]["noChap"]; ?></p>
                        <p>Počet knih: <?PHP echo $infoBook[0]["noBook"]; ?></p>
                        <p>Rok vydání: <?PHP echo $infoBook[0]["yearOfPublication"]; ?></p>
                        <p>Nakladatelství: <?PHP echo $infoBook[0]["publisher"]; ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div id="main-con">
            <div>
                <p>
                    <a href="/">Domů</a>
                    >
                    <a href="/db/book/">Knihy</a>
                    >
                    <a href="/db/book/<?PHP echo $infoBook[0]["ID_Book"]; ?>/"><?PHP echo $infoBook[0]["name"]; ?></a>
                </p>
            </div>
            <div class="rank">
                <div class="halfone">
                    <div>
                        <p class="spec">Hodnocení</p>
                    </div>
                    <div>
                        <p id="rat"><?PHP echo $infoBook[0]["avgRat"]; ?></p>
                    </div>
                </div>
                <div class="halftwo">
                    <div>
                        <p>Žebříček <strong>#
                                <?PHP
                                $top = ($MAIN->__construct("bookTop",$infoBook[0]["ID_Book"]));
                                echo $top["0"]["top"];
                                ?>
                            </strong></p>
                    </div>
                    <div>
                        <p><?PHP echo $infoBook[0]["yearOfPublication"]; ?> | Kniha | <?PHP echo $infoBook[0]["publisher"]; ?></p>
                    </div>
                </div>
            </div>
            <div class="form">
                <form method="post">
                    <label for="statusID" class="hidden"></label>
                    <select name="status" id="statusID">
                        <option value="">-- Vyberte --</option>
                        <option value="reading">Čtu</option>
                        <option value="completed">Dokončeno</option>
                        <option value="onHold">Dávám si pauzu</option>
                        <option value="dropped">Nedokončeno</option>
                        <option value="planToRead">Plánuji číst</option>
                    </select>
                    <label for="ratingID" class="hidden"></label>
                    <select name="rating" id="ratingID">
                        <option value="">-- Vyberte --</option>
                        <option value="ten">(10) Masterpiece</option>
                        <option value="nine">(9) Úžasné</option>
                        <option value="eight">(8) Velmi dobré</option>
                        <option value="seven">(7) Dobré</option>
                        <option value="six">(6) Ucházející</option>
                        <option value="five">(5) Průměr</option>
                        <option value="for">(4) Špatné</option>
                        <option value="three">(3) Velmi špatné</option>
                        <option value="two">(2) Příšerné</option>
                        <option value="one">(1) Urážka</option>
                    </select>
                    <label for="noBookID" class="hidden"></label>
                    <input type="number" name="noBook" id="noBookID" min="0" max="PocetKnih" placeholder="Max. PocetKnih">
                    <label for="noChapID" class="hidden"></label>
                    <input type="number" name="noChap" id="noChapID" min="0" max="PocetKapitol" placeholder="Max. PocetKapitol">
                    <input type="submit" id="submitID" value="Potvrdit">
                </form>
            </div>
            <div>
                <div>
                    <h3>Obsah</h3>
                </div>
                <div>
                    <?PHP echo $infoBook[0]["synopsis"]; ?>
                </div>
            </div>
            <div>
                <div>
                    <h3>Pozadí</h3>
                </div>
                <div>
                    <?PHP echo $infoBook[0]["background"]; ?>
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