<?php
namespace Model;

class AnonModel extends Model
{
    protected $lvl;

    public
    function __construct()
    {
        $this -> lvl = "anon";
    }

    public
    function getLvl()
    {
            return $this -> lvl;
    }
}

