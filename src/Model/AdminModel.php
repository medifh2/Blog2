<?php
namespace Model;

class AdminModel extends WriterModel
{
    function __construct($login, $pass, $username, $about)
    {
        $this -> login = $login;
        $this -> pass = $pass;
        $this -> username = $username;
        $this -> about = $about;
        $this -> lvl = "admin";
    }
}
