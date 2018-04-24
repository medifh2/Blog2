<?php
namespace Control;

use Model\PostDBModel;
use View\View;
class MainPageController extends Controller
{

    function __construct()
    {

    }

    public function showMainPage($route_date)
    {
        $from = 0;
        $to = 10;
        $connect = new PostDBModel;
        $num_all_posts = ($connect -> getNumRows());
        $all_posts  = $connect -> getFromToPosts($from, $to);
        $data_for_view ['all_posts'] = $all_posts;
        $data_for_view['num_all_posts'] = $num_all_posts;
        View::pageGenerate ('MainpageView', $data_for_view);
    }

    public function showNPage($route_data)
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
