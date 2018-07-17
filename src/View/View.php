<?php
namespace View;
use Conf\LogoInfo;
class View
{
    static function pageGenerate ($files, $data_for_view = NULL)
    {
        $logo_info = new LogoInfo;
        $data_for_view['logo'] = $logo_info -> getData();
        include $files['head'] . ".php";
        include $files['nav'] . ".php";
        include $files['body'] . ".php";
        include "AlertView.php";
        echo '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
              <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>';
    }

    private static $_instance = null;

    private function __construct()
    {

    }
    protected function __clone()
    {

    }

    static public function getInstance()
    {
        if(is_null(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}