<?php

class DB {
    public function usersBooks($userIDPage):void {
        $datCon = $this->datCon();
        $SQL = "select book.name as bookName, bookstatus.rating as bookRat, bookstatus.noBookCmpl as noBookCmpl, bookstatus.noChapCmpl as noChapCmpl, status.name as status, book.noBook as noBook, book.noChap as noChap, book.ID_Book as ID_Book from userinfo, bookstatus, book, status where (userinfo.ID_User=" . $userIDPage . ") And (userinfo.ID_User=bookstatus.ID_User) And (book.ID_Book=bookstatus.ID_Book) And (status.ID_Stat=bookstatus.status);";
        $usersBooks = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($usersBooks as $row) {
            echo "<tr><th><a href='/db/book/" . $row["ID_Book"] . "/'>" . $row["bookName"] . "</a></th><th>" . $row["bookRat"] . "</th><th><p class='spec'>" . $row["status"] . "</p></th><th>" . $row["noBookCmpl"] . "/" . $row["noBook"] ."</th><th>" . $row["noChapCmpl"] . "/" . $row["noChap"] ."</th></tr>";

        }
        mysqli_close($datCon);
        return;
    }
    public function dbUsers():void {
        $datCon = $this->datCon();
        $SQL = "select book.ID_Book as ID_Book, book.name as lastUpdate, userinfo.username as username, userinfo.bio as bio, userinfo.ID_User as ID_User from userinfo left join book on book.ID_Book=userinfo.lastUpdate order by userinfo.username ASC;";
        $dbUsers = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($dbUsers as $row) {
            if (isset($row["lastUpdate"])) {
                echo "<div><div><a href='/db/user/" . $row["ID_User"] . "/'><img src='/db/user/" . $row["ID_User"] . "/pfp.jpg' alt='Profile picture was not found'></a></div><div><div><a href='/db/user/" . $row["ID_User"] . "/'><p>" . $row["username"] . "</p></a></div><div><p>Poslední změna: <a href='/db/book/" . $row["ID_Book"] . "/'> " . $row["lastUpdate"] . "</a></p></div><div>" . substr($row["bio"],0,130) . "..." . "</p></div></div></div>";
            }
            else
                echo "<div><div><a href='/db/user/" . $row["ID_User"] . "/'><img src='/db/user/" . $row["ID_User"] . "/pfp.jpg' alt='Profile picture was not found'></a></div><div><div><a href='/db/user/" . $row["ID_User"] . "/'><p>" . $row["username"] . "</p></a></div><div><p>Poslední změna: Žádná</p></div><div>" . substr($row["bio"],0,130) . "..." . "</p></div></div></div>";
        }
        mysqli_close($datCon);
        return;
    }
    public function dbBooks():void {
        $datCon = $this->datCon();
        $SQL = "select ID_Book, name, synopsis, avgRat from book order by name ASC;";
        $dbBooks = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($dbBooks as $row) {
            echo "<div><div><a href='/db/book/" . $row["ID_Book"] . "/'><img src='/db/book/" . $row["ID_Book"] . "/book.jpg' alt='Book picture was not found'></a></div><div><div><a href='/db/book/" . $row["ID_Book"] . "/'><p>" . $row["name"] . "</p></a></div><div><p>Hodnocení: " . $row["avgRat"] . "</p></div><div>" . substr($row["synopsis"],0,115) . "..." . "</p></div></div></div>";
        }
        mysqli_close($datCon);
        return;
    }
    public function recBooks():void {
        $datCon = $this->datCon();
        $SQL = "select ID_Book, lastUpdate, name from book order by lastUpdate DESC limit 2;";
        $recBooks = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($recBooks as $row) {
            echo "<div><a href='/db/book/" . $row["ID_Book"] . "/'><img src='/db/book/" . $row["ID_Book"] . "/book.jpg' alt='Book picture was not found'></a><p> | </p><a href='/db/book/" . $row["ID_Book"] . "/'><p>" . $row["name"] . "</p></a><p> | </p><p>" . date("d. m. Y - H:i:s",strtotime($row["lastUpdate"])) . "</p></div>";

        }
        mysqli_close($datCon);
        return;
    }
    public function recUsers():void {
        $datCon = $this->datCon();
        $SQL = "select userinfo.username as username, userinfo.ID_User as ID_User, book.name as lastUpdate, book.ID_Book as ID_Book, userinfo.lastUpdate_time as lastUpdate_time from userinfo, book where book.ID_Book=userinfo.lastUpdate order by lastUpdate_time DESC limit 3;";
        $recUsers = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($recUsers as $row) {
            echo "<div><a href='/db/user/" . $row["ID_User"] . "/'><img src='/db/user/" . $row["ID_User"] . "/pfp.jpg' alt='Profile picture was not found'></a><p> | </p><a href='/db/user/" . $row["ID_User"] . "/'><p>" . $row["username"] . "</p></a><p> | </p><a href='/db/book/" . $row["ID_Book"] . "/'><p>" . $row["lastUpdate"] . "</p></a></div>";

        }
        mysqli_close($datCon);
        return;
    }
    public function infoUserSpec($userIDPage):array {
        $datCon = $this->datCon();
        $SQL = "select DISTINCT userinfo.username as username, userinfo.name as name, userinfo.surname as surname, userinfo.dateOfBirth as dateOfBirth, userinfo.bio as bio, userinfo.avgRat as avgRat, userinfo.noBookAll as noBookAll, userinfo.noChapAll as noChapAll, book.name as lastUpdate, gender.name as gender, language.name as language, country.name as country, book.ID_Book as ID_Book, userinfo.ID_User as ID_User from userinfo, country, language, gender, book where (ID_User=" . $userIDPage . ")And(userinfo.gender=gender.ID_Gend)And(userinfo.language=language.ID_Lang)And(userinfo.country=country.ID_Coun)And(userinfo.lastUpdate=book.ID_Book);";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        if (!isset($info["0"]["name"])) {
            $SQL = "select DISTINCT userinfo.username as username, userinfo.name as name, userinfo.surname as surname, userinfo.dateOfBirth as dateOfBirth, userinfo.bio as bio, userinfo.avgRat as avgRat, userinfo.noBookAll as noBookAll, userinfo.noChapAll as noChapAll, book.name as lastUpdate, gender.name as gender, language.name as language, country.name as country, book.ID_Book as ID_Book, userinfo.ID_User as ID_User from userinfo, country, language, gender, book where (ID_User=" . $userIDPage . ")And(userinfo.gender=gender.ID_Gend)And(userinfo.language=language.ID_Lang)And(userinfo.country=country.ID_Coun);";
            $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
            $info["0"]["lastUpdate"] = "Chybí";
        }
        mysqli_close($datCon);
        return $info;
    }
    public function infoUser():array {
        $datCon = $this->datCon();
        $SQL = "select username from userinfo where ID_User=" . $_SESSION["ID_User"] . ";";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        echo "<div><p>".$info["0"]["username"]."</p></div><div><a href='/db/user/".$_SESSION["ID_User"] ."/'><img src='/db/user/".$_SESSION["ID_User"]."/pfp.jpg' alt='Profile picture was not found'></a></div><div><a href='/assets/php/unlog.php'><img src='/assets/images/logout.svg' alt='Ohlásit se.' class='invert'></a></div>";
        mysqli_close($datCon);
        return $info;
    }
    public function infoBook($userIDPage):array {
        $datCon = $this->datCon();
        $SQL = "select * from book where ID_Book=" . $userIDPage . ";";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        mysqli_close($datCon);
        return $info;
    }
    public function bookStatus($userIDPage):array {
        $datCon = $this->datCon();
        if(isset($_SESSION["ID_User"])) {
            $ID = $_SESSION["ID_User"];
        }
        else {
            $ID = 0;
        }
        $SQL = "select status.name as status, bookstatus.noBookCmpl as noBookCmpl, bookstatus.noChapCmpl as noChapCmpl, bookstatus.rating as rating from bookstatus, userinfo, status where (bookstatus.ID_User=" . $ID .") And (bookstatus.ID_Book=" . $userIDPage .") And (bookstatus.status=status.ID_Stat);";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        if (!isset($info["0"]["status"])) {
            $info[0]["status"] = "Nehodnoceno";
            $info[0]["noChapCmpl"] = "0";
            $info[0]["noBookCmpl"] = "0";
            $info[0]["rating"] = "Nehodnoceno";
        }
        mysqli_close($datCon);
        return $info;
    }
    public function changeOfStatus($ratYet):void {
        if (isset($_POST["ID_Book"])&&isset($_POST["ID_User"])&&isset($_POST["status"])&&isset($_POST["rating"])&&isset($_POST["noBook"])&&isset($_POST["noChap"])) {
            $datCon = $this->datCon();
            $ID_Book = $_POST["ID_Book"];
            $ID_User = $_POST["ID_User"];
            $status = $_POST["status"];
            $rating = $_POST["rating"];
            $noBook = $_POST["noBook"];
            $noChap = $_POST["noChap"];
            $SQL = "select noBook, noChap, avgRat from book where ID_Book =". $ID_Book .";";
            $book = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
            if ($ratYet != "Nehodnoceno") {
                if (($book["0"]["noChap"]<$noBook)||($book["0"]["noChap"]<$noChap)) {
                    echo "<script type=\"text/javascript\">
                            window.alert('Počet knih nebo kapitol je větší než stanovený limit.');
                        </script>";
                    return;
                }
                $SQL = "UPDATE bookstatus SET status = " . $status . ", noBookCmpl = " . $noBook . ", noChapCmpl = " . $noChap . ", rating = " . $rating . " where (ID_User = " . $ID_User . ") AND (ID_Book = " . $ID_Book . ");";
                mysqli_query($datCon, $SQL);
            }
            else {
                $SQL = "insert into bookstatus(ID_Book, ID_User, status, noBookCmpl, noChapCmpl, rating) values (".$ID_Book.",".$ID_User.",".$status.",".$noBook.",".$noChap.",".$rating.");";
                mysqli_query($datCon, $SQL);
            }
            $datetime=date("Y-m-d H:i:s",time());

            $SQL = "select sum(rating) as sum, count(ID_User) as count from bookstatus where ID_User=".$ID_User.";";
            $numUser = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC)["0"];

            $SQL = "select sum(rating) as sum, count(ID_Book) as count from bookstatus where ID_Book=".$ID_Book.";";
            $numBook = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC)["0"];

            $SQL = "update book set lastUpdate='".$datetime."', avgRat=" . ($numBook["sum"]/$numBook["count"]) . " where ID_Book=".$ID_Book.";";
            mysqli_query($datCon, $SQL);

            $SQL = "update userinfo set lastUpdate=".$ID_Book.",lastUpdate_time='".$datetime."', avgRat=".($numUser["sum"]/$numUser["count"])." where ID_User=".$ID_User.";";
            mysqli_query($datCon, $SQL);
            mysqli_close($datCon);
        }
        return;
    }
    public function bookTop($userIDPage):array {
        $datCon = $this->datCon();
        $SQL = "WITH cBase AS ( SELECT book.ID_Book, ROW_NUMBER() OVER (ORDER BY book.avgRat DESC) AS top FROM book) SELECT * FROM cBase WHERE ID_Book=" . $userIDPage . ";";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        mysqli_close($datCon);
        return $info;
    }
    public function logUser():void {
        if(isset($_SESSION["ID_User"])) {
            echo "<script type=\"text/javascript\">
                        window.alert('Jste již přihlášen.');
                    </script>";
            echo "<script type=\"text/javascript\">window.location.href = '/';</script>";
            return;
        }
        else {
            if (!empty($_POST["username"])&&!empty($_POST["password"])) {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $datCon = $this->datCon();
                $SQL = "select count(case username when \"$username\" then 1 else null end) as noUser from userinfo;";
                $numUser = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
                if ($numUser["0"]["noUser"] != "1") {
                    echo "<script type=\"text/javascript\">
                            window.alert('Zadané uživatelské jméno neexistuje.');
                        </script>";
                    return;
                }
                $SQL = "select ID_User, password from userinfo where username=\"". $username ." \";";
                $passwd = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
                if (!password_verify($password, $passwd["0"]["password"])) {
                    echo "<script type=\"text/javascript\">
                            window.alert('Špatné heslo.');
                        </script>";
                    return;
                }
                echo "<script type=\"text/javascript\">
                            window.alert('Přihlášeno!');
                        </script>";
                $_SESSION["ID_User"] = $passwd["0"]["ID_User"];
                # setcookie("ID_User", $passwd["0"]["ID_User"], time() + (86400 * 30), "/");
                mysqli_close($datCon);
                return;
            }
            else {
                return;
            }
        }
    }
    public function regUser():void {
        if (!empty($_POST["realName"])&&!empty($_POST["realSurname"])&&!empty($_POST["username"])&&!empty($_POST["dateOfBirth"])&&!empty($_POST["gender"])&&!empty($_POST["country"])&&!empty($_POST["language"])&&!empty($_POST["password"])&&!empty($_POST["passwordA"])) {
            $realName = $_POST["realName"];
            $realSurname = $_POST["realSurname"];
            $username = $_POST["username"];
            $dateOfBirth = $_POST["dateOfBirth"];
            $gender = $_POST["gender"];
            $country = $_POST["country"];
            $language = $_POST["language"];
            $bio = $_POST["bio"];
            $password = $_POST["password"];
            $passwordA = $_POST["passwordA"];
            $MAX_FILE_SIZE = $_POST["MAX_FILE_SIZE"];
            # Databazova blbost
            if (mb_strlen($realName) > 50 && mb_strlen($realSurname) > 50 && mb_strlen($username) > 50 && mb_strlen($password) > 50 && mb_strlen($passwordA) > 50) {
                echo "<script type=\"text/javascript\">
                        window.alert('Max. 50 znaků');
                    </script>";
                return;
            }
            if (mb_strlen($bio) > 450) {
                echo "<script type=\"text/javascript\">
                        window.alert('Max. 200 znaků');
                    </script>";
                return;
            }
            if ($_FILES["pfp"]["size"] > $MAX_FILE_SIZE) {
                echo "<script type=\"text/javascript\">
                        window.alert('Max. 20 MB');
                    </script>";
                return;
            }
            if ($password != $passwordA) {
                echo "<script type=\"text/javascript\">
                        window.alert('Hesla se musí shodovat');
                    </script>";
                return;
            }
            list ($width, $height) = getimagesize($_FILES["pfp"]["tmp_name"]);
            if ($width != $height) {
                echo "<script type=\"text/javascript\">
                        window.alert('Profilová fotografie musí být čtverec');
                    </script>";
                return;
            }
            if ($_FILES["pfp"]["type"] != "image/jpeg") {
                echo "<script type=\"text/javascript\">
                        window.alert('Profilová fotografie musí být formátu .jpeg');
                    </script>";
                return;
            }
            $bio = "<p>".$bio."</p>";
            $password = password_hash($password, PASSWORD_DEFAULT);
            $datCon = $this->datCon();
            $SQL = "select username from userinfo";
            $users = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
            foreach($users as $row) {
                if ($row["username"] == $username) {
                    echo "<script type=\"text/javascript\">
                        window.alert('Uživatelské jméno již existuje.');
                    </script>";
                    return;
                }
            }
            $SQL = "insert into userinfo(username, name, surname, password, avgRat, noBookAll, noChapAll, dateOfBirth, gender, language, country, bio) values (\"" . $username . "\", \"" . $realName ."\", \"" . $realSurname ."\", \"" . $password ."\", 0.0, 0, 0, \"" . $dateOfBirth ."\", " . $gender .", " . $language .", " . $country .", \"" . $bio ."\");";
            mysqli_query($datCon, $SQL);
            $ID_User = mysqli_insert_id($datCon);
            mysqli_close($datCon);
            # Vytvoreni slozky a pfp
            mkdir($_SERVER['DOCUMENT_ROOT'] . "/db/user/".$ID_User."/");
            move_uploaded_file($_FILES["pfp"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . "/db/user/".$ID_User."/" . $_FILES["pfp"]["name"]);
            rename($_SERVER['DOCUMENT_ROOT'] . "/db/user/".$ID_User."/" . $_FILES["pfp"]["name"], $_SERVER['DOCUMENT_ROOT'] . "/db/user/".$ID_User."/" . "pfp.jpg");
            copy($_SERVER['DOCUMENT_ROOT'] . "/db/user/template/index.php", $_SERVER['DOCUMENT_ROOT'] . "/db/user/".$ID_User."/index.php");
            echo "<script type=\"text/javascript\">
                        window.alert('Účet vytvořen!');
                    </script>";
            return;
        }
        else {
            return;
        }
    }
    public function datCon() {
        $datCon = mysqli_connect("localhost", "root", "", "knidat");
        mysqli_set_charset($datCon, "UTF8");
        if ($datCon->connect_error) {
            die("Připojení k databázi se nezdařilo: " . $datCon->connect_error);
        }
        return $datCon;
    }
}
