<?php
require ("DB.php");
class main
{
    public function __construct($choose, $userIDPage)
    {
        $DB = new DB();
        if($choose == "regUser") {
            $DB->regUser();
        }
        if($choose == "logUser") {
            $DB->logUser();
        }
        if($choose == "recUsers") {
            $DB->recUsers();
        }
        if($choose == "recBooks") {
            $DB->recBooks();
        }
        if($choose == "dbUsers") {
            $DB->dbUsers();
        }
        if($choose == "dbBooks") {
            $DB->dbBooks();
        }
        if($choose == "usersBooks") {
            $DB->usersBooks($userIDPage);
        }
        if($choose == "infoUser") {
            return ($DB->infoUser());
        }
        if($choose == "infoBook") {
            return ($DB->infoBook($userIDPage));
        }
        if($choose == "bookStatus") {
            return ($DB->bookStatus($userIDPage));
        }
        if($choose == "bookTop") {
            return ($DB->bookTop($userIDPage));
        }
        if($choose == "infoUserSpec") {
            return ($DB->infoUserSpec($userIDPage));
        }
    }
}