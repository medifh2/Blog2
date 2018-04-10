<?php
namespace Model;

class AnonModel
{
    protected $lvl;

    public
    function __construct()
    {
        $this -> lvl = "anon";
    }

    function getLvl()
    {
            return $this -> lvl;
    }
}

