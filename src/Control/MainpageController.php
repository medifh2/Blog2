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
        $numposts = 10;
        $connect = new PostDBModel;
        $is_last = ($connect -> getNumRows() >= $numposts);
        $post = $connect -> getNumPosts($numposts);
        $all_posts = $post;
        $data_for_view ['all_posts'] = $all_posts;
        $data_for_view ['message'] = false;
        $data_for_view['is_last'] = $is_last;
        View::pageGenerate ('MainpageView', $data_for_view);
    }

    public function showMore($route_data)
    {
        $numposts = $route_data;
        $connect = new PostDBModel;
        $is_last = ($connect -> getNumRows() >= $numposts);
        $post = $connect -> getNumPosts($numposts);
        $all_posts = $post;
        $data_for_view['all_posts'] = $all_posts;
        $data_for_view['is_last'] = $is_last;
        View::pageGenerate ('MainpageView', $data_for_view);
    }

}
