<?php


namespace Controller;

use Zuni\View;
use Zuni\Controller;

class Error404 extends Controller
{
    public function __construct() {
   
    }

        public function index()
        {
            $view = new View\Render('error404');

            $this->load($view);
        } 

}





