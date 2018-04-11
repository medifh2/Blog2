<?php
namespace model;

require_once "AnonModel.php";
class ReaderModel extends AnonModel
{
protected $login, $pass, $username, $about;


    function __construct($login, $pass, $username, $about)
    {
        $this -> login = $login;
        $this -> pass = $pass;
        $this -> username = $username;
        $this -> about = $about;
        $this -> lvl = "reader";
    }

    public
    function allData()
    {
        $res =[
            'Login' => $this -> login,
            'Username' => $this -> username,
            'About_me' => $this -> about,
            'Lvl' => $this -> lvl,
        ];
        return $res;
    }

}