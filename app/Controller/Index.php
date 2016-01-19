<?php


namespace Controller;

use Zuni\View;
use Zuni\Controller;
use Zuni\Table;
use Zuni\Element;

class Index extends Controller
{
    public function __construct() {
   
    }

        public function index()
        {
            $view = new View\Render('index');

            $this->load($view);
        } 

}




