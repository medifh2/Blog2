<?php
namespace Control;

use Model\PostDBModel;

class MainPageController extends Controller
{

    function __construct()
    {

    }

    public function showMainPage()
    {
        $page_number = 0;
        $from = 0;
        $to = 10;
        $connect = new PostDBModel;
        $all_posts  = $connect -> getFromToPosts($from, $to);
        $data_for_view ['all_posts'] = $all_posts;
        $amount_posts  = $connect -> getAmountRows();
        $amount_pages = $amount_posts / 10;
        $amount_pages = ceil ($amount_pages);
        $data_for_view ['amount_pages'] = $amount_pages;
        $data_for_view ['current_page'] = $page_number;
        $this -> showPage ('MainpageView', $data_for_view);
    }

    public function showNPage($page_number)
    {
        $page_number --;
        $connect = new PostDBModel;
        $from = 10 * $page_number;
        $to = $from + 10;
        $all_posts = $connect -> getFromToPosts($from, $to);
        $data_for_view['all_posts'] = $all_posts;
        $amount_posts  = $connect -> getAmountRows();
        $amount_pages = $amount_posts / 10;
        $amount_pages = ceil ($amount_pages);
        $data_for_view ['amount_pages'] = $amount_pages;
        $data_for_view ['current_page'] = $page_number;
        $this -> showPage ('MainpageView', $data_for_view);
    }

}
