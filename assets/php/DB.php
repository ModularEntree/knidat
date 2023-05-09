<?php

class DB {
    public function usersBooks($userIDPage) {
        $datCon = $this->datCon();
        $SQL = "select book.name as bookName, bookstatus.rating as bookRat, bookstatus.noBookCmpl as noBookCmpl, bookstatus.noChapCmpl as noChapCmpl, status.name as status, book.noBook as noBook, book.noChap as noChap, book.ID_Book as ID_Book from userinfo, bookstatus, book, status where (userinfo.ID_User=" . $userIDPage . ") And (userinfo.ID_User=bookstatus.ID_User) And (book.ID_Book=bookstatus.ID_Book) And (status.ID_Stat=bookstatus.status);";
        $usersBooks = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($usersBooks as $row) {
            echo "<tr><th><a href='/db/book/" . $row["ID_Book"] . "/'>" . $row["bookName"] . "</a></th><th>" . $row["bookRat"] . "</th><th><p class='spec'>" . $row["status"] . "</p></th><th>" . $row["noBookCmpl"] . "/" . $row["noBook"] ."</th><th>" . $row["noChapCmpl"] . "/" . $row["noChap"] ."</th></tr>";

        }
        mysqli_close($datCon);
        return;
    }
    public function dbUsers() {
        $datCon = $this->datCon();
        $SQL = "select book.ID_Book as ID_Book, book.name as lastUpdate, userinfo.username as username, userinfo.bio as bio, userinfo.ID_User as ID_User from userinfo, book where (book.ID_Book=userinfo.lastUpdate) order by userinfo.username ASC;";
        $dbUsers = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($dbUsers as $row) {
            echo "<div><div><a href='/db/user/" . $row["ID_User"] . "/'><img src='/db/user/" . $row["ID_User"] . "/pfp.jpg' alt='Profile picture was not found'></a></div><div><div><a href='/db/user/" . $row["ID_User"] . "/'><p>" . $row["username"] . "</p></a></div><div><p>Poslední změna: <a href='/db/book/" . $row["ID_Book"] . "/'> " . $row["lastUpdate"] . "</a></p></div><div>" . substr($row["bio"],0,130) . "..." . "</p></div></div></div>";
        }
        mysqli_close($datCon);
        return;
    }
    public function dbBooks() {
        $datCon = $this->datCon();
        $SQL = "select ID_Book, name, synopsis, avgRat from book order by name ASC;";
        $dbBooks = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($dbBooks as $row) {
            echo "<div><div><a href='/db/book/" . $row["ID_Book"] . "/'><img src='/db/book/" . $row["ID_Book"] . "/book.jpg' alt='Book picture was not found'></a></div><div><div><a href='/db/book/" . $row["ID_Book"] . "/'><p>" . $row["name"] . "</p></a></div><div><p>Hodnocení: " . $row["avgRat"] . "</p></div><div>" . substr($row["synopsis"],0,115) . "..." . "</p></div></div></div>";
        }
        mysqli_close($datCon);
        return;
    }
    public function recBooks() {
        $datCon = $this->datCon();
        $SQL = "select ID_Book, lastUpdate, name from book where (lastUpdate < NOW()) limit 2;";
        $recBooks = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($recBooks as $row) {
            echo "<div><a href='/db/book/" . $row["ID_Book"] . "/'><img src='/db/book/" . $row["ID_Book"] . "/book.jpg' alt='Book picture was not found'></a><p> | </p><a href=/db/book/'" . $row["ID_Book"] . "/'><p>" . $row["name"] . "</p></a><p> | </p><p>" . date("d. m. Y - H:i:s",strtotime($row["lastUpdate"])) . "</p></div>";

        }
        mysqli_close($datCon);
        return;
    }
    public function recUsers() {
        $datCon = $this->datCon();
        $SQL = "select userinfo.username as username, userinfo.ID_User as ID_User, book.name as lastUpdate, book.ID_Book as ID_Book, userinfo.lastUpdate_time as lastUpdate_time from userinfo, book where (book.ID_Book=userinfo.lastUpdate) And (lastUpdate_time < NOW()) limit 3;";
        $recUsers = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        foreach ($recUsers as $row) {
            echo "<div><a href='/db/user/" . $row["ID_User"] . "/'><img src='/db/user/" . $row["ID_User"] . "/pfp.jpg' alt='Profile picture was not found'></a><p> | </p><a href='/db/user/" . $row["ID_User"] . "/'><p>" . $row["username"] . "</p></a><p> | </p><a href='/db/book/" . $row["ID_Book"] . "/'><p>" . $row["lastUpdate"] . "</p></a></div>";

        }
        mysqli_close($datCon);
        return;
    }
    public function infoUserSpec($userIDPage) {
        $datCon = $this->datCon();
        $SQL = "select DISTINCT userinfo.username as username, userinfo.name as name, userinfo.surname as surname, userinfo.dateOfBirth as dateOfBirth, userinfo.bio as bio, userinfo.avgRat as avgRat, userinfo.noBookAll as noBookAll, userinfo.noChapAll as noChapAll, book.name as lastUpdate, gender.name as gender, language.name as language, country.name as country, book.ID_Book as ID_Book, userinfo.ID_User as ID_User from userinfo, country, language, gender, book where (ID_User=" . $userIDPage . ")And(userinfo.gender=gender.ID_Gend)And(userinfo.language=language.ID_Lang)And(userinfo.country=country.ID_Coun)And(userinfo.lastUpdate=book.ID_Book);";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        mysqli_close($datCon);
        return $info;
    }
    public function infoUser() {
        $datCon = $this->datCon();
        $SQL = "select username from userinfo where ID_User=" . $_COOKIE["ID_User"] . ";";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        echo "<div><p>".$info["0"]["username"]."</p></div><div><a href='/db/user/".$_COOKIE["ID_User"]."/'><img src='/db/user/".$_COOKIE["ID_User"]."/pfp.jpg' alt='Profile picture was not found'></a></div><div><a href='/assets/php/unlog.php' target='_blank'><img src='/assets/images/logout.svg' class='invert'></a></div>";
        mysqli_close($datCon);
        return $info;
    }
    public function infoBook($userIDPage) {
        $datCon = $this->datCon();
        $SQL = "select * from book where ID_Book=" . 1 . ";";
        # jedničku nahradit za $userIDPage
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        mysqli_close($datCon);
        return $info;
    }
    public function bookTop($userIDPage) {
        $datCon = $this->datCon();
        $SQL = "WITH cBase AS ( SELECT book.ID_Book, ROW_NUMBER() OVER (ORDER BY book.avgRat DESC) AS top FROM book) SELECT * FROM cBase WHERE ID_Book=1;";
        $info = mysqli_fetch_all(mysqli_query($datCon, $SQL), MYSQLI_ASSOC);
        mysqli_close($datCon);
        return $info;
    }
    public function logUser() {
        if($_COOKIE["ID_User"]!=0) {
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
                $SQL = "select ID_User, password from userinfo where username=\"$username \";";
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

                setcookie("ID_User", $passwd["0"]["ID_User"], time() + (86400 * 30), "/");
                mysqli_close($datCon);
                return;
            }
            else {
                return;
            }
        }
    }
    public function regUser() {
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
