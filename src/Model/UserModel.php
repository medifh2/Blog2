<?php
namespace Model;

class UserModel extends Model
{
    protected  $login, $pass, $username, $about, $lvl, $reg_date, $status;
    
    public function __construct($login, $pass, $username, $about, $lvl, $reg_date, $status)
    {
        $this -> login = $login;
        $this -> pass = $pass;
        $this -> username = $username;
        $this -> about = $about;
        $this -> lvl = $lvl;
        $this -> reg_date = $reg_date;
        $this -> status = $status;
    }

    public function getUserInfo()
    {
        $res =[
            'login' => $this -> login,
            'username' => $this -> username,
            'about_me' => $this -> about,
            'lvl' => $this -> lvl,
            'status' => $this -> status,
        ];
        return $res;
    }
    
    public function getLvl()
    {
            return $this -> lvl;
    }
}

