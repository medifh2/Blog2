<?php
namespace Control;
use View\View;
class Controller
{

    protected function showPage($file_name, $data_for_view = NULL)
    {
        View::pageGenerate($file_name, $data_for_view);
    }

}