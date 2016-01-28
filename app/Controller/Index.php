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

            $e  = new Element('input');

  /*
            $e->attr(array(
                'type'=> 'text',
                'required'
            ));
*/
            $e->attr('required');
            $e->attr('type', 'email');
            echo htmlentities($e->render());


            // $view = new View\Render('index');

            // $this->load($view);
        } 

}




