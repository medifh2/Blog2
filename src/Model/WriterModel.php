<?php
namespace Model;

class WriterModel extends ReaderModel
{
    function __construct($login, $pass, $username, $about)
    {
        $this -> login = $login;
        $this -> pass = $pass;
        $this -> username = $username;
        $this -> about = $about;
        $this -> lvl = "writer";
    }
}
