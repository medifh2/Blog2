<?php
namespace Control;

use Model\PostDBModel;
use View\View;
class MainPageController extends Controller
{

    function __construct()
    {

    }
    public function showMainPage()
    {
        $_SESSION['Numposts'] = 2;
        $connect = new PostDBModel;
        $_SESSION['Islast'] = ($connect -> getNumRows() >= $_SESSION['Numposts']);
        $post = $connect -> getTenPosts($_SESSION['Numposts']);
        foreach ($post as &$exemp)
        {
            $exemp['Image'] = 'images/'.$exemp['Image'];
        }
        $_SESSION['Allposts'] = $post;
        View::pageGenerate ('MainpageView');
    }
    public function showMore()
    {
        $_SESSION['Numposts'] += 2;
        $connect = new PostDBModel;
        $_SESSION['Islast'] = ($connect -> getNumRows() >= $_SESSION['Numposts']);
        $post = $connect -> getTenPosts($_SESSION['Numposts']);
        foreach ($post as &$exemp)
        {
            $exemp['Image'] = 'images/'.$exemp['Image'];
        }
        $_SESSION['Allposts'] = $post;
        View::pageGenerate ('MainpageView');
    }
}
