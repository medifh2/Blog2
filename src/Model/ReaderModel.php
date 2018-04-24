<?php
namespace Model;

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
            'login' => $this -> login,
            'username' => $this -> username,
            'about_me' => $this -> about,
            'lvl' => $this -> lvl,
        ];
        return $res;
    }

}