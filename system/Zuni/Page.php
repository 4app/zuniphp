<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 


// -------------------------------
 
    public function page()
    {

        $uriNum = \Zuni\Uri::getSegment(2);
        $url = 'http://127.0.0.1/myproject/page/';

        $page = new \Zuni\Page();
        $page->setTotal(200);
        $page->setPerPage(10);
        $page->setCurrentPage($uriNum);
        $page->setNumberLink(5);
        $page->init();

        if($page->haveToPaginate())
        {
            echo (!$page->getFirstPage()) ? 
                'First |' : 
                \Zuni\Html::anchor($url . $page->getFirstPage(), 'First');
            echo ' ';

            echo (!$page->getPreviousPage()) ? 
                'Previous' : 
                \Zuni\Html::anchor($url . $page->getPreviousPage(), 'Previous');
            echo ' ';

            echo ' - ';
            foreach ($page->getNumberAll() as $num)
            {
                echo ($page->getCurrentPage() == $num) ? 
                    $num : \Zuni\Html::anchor($url . $num, $num);
                echo ' - ';
            }

            echo (!$page->getNextPage()) ? 
                'Next' : \Zuni\Html::anchor($url . $page->getNextPage(), 'Next');
            echo ' ';

            echo (!$page->getLastPage()) ? 
                '| Last' : \Zuni\Html::anchor($url . $page->getLastPage(), 'Last');
            echo ' ';

        }
 */

namespace Zuni;


class Page
{

    private $_total = 0;
    private $_first;
    private $_last;
    private $_next;
    private $_previous;
    private $_number;

    private $_currentPage;
    private $_plus;
    private $_less;


    private $_perPage;
    private $_startPage;

    private $_totalRows;
    private $_numberLink = 4;
    private $_numberArr = array();
    private $_numberPrevious;
    private $_numberNext;





    public function getNumberLink()
    {
        return $this->_numberLink;
    }


    public function setNumberLink($number)
    {
        $this->_numberLink = (int) $number;
        return $this;
    }


    private function _setFirstPage($currentPage)
    {

        $currentPage = (int) $currentPage;

        if($currentPage != 1)
        {
            $this->_first = 1;
        }

        return $this;
    } 



    private function _setPreviousPage($plus)
    {
        $plus = (int) $plus;

        if($plus)
        {
            $this->_previous = $plus; 
        }

        return $this;
    }



    private function _setNextPage($less)
    {

        $less = (int) $less;

        if($less <= self::_getTotalRows())
        {
            $this->_next = $less;
        }

        return $this;
    }


    private function _setLastPage($currentPage)
    {
        $currentPage = (int) $currentPage;

        if($currentPage != self::_getTotalRows())
        {
            $this->_last = self::_getTotalRows() ;
        }

        return $this;
    } 


    public function getFirstPage()
    {
        return $this->_first;
    }

    public function getPreviousPage()
    {
        return $this->_previous; 
    } 

    public function getNextPage()
    {
        return $this->_next;
    } 


    public function getLastPage()
    {
        return $this->_last;
    } 



    public function getTotal()
    {
        return $this->_total;
    }

    public function setTotal($total)
    {
        $this->_total = (int) $total;
        return $this;
    }


    private function _getTotalRows()
    {
        return $this->_totalRows;
    }

    private function _setTotalRows($totalRows)
    {
        $this->_totalRows = (int) $totalRows;
        return $this;
    }



    public function getNumberAll()
    {

        $current = self::getCurrentPage();
        $total = self::getNumberLink();

        self::_setNumberPrevious($current - $total);
        self::_setNumberNext($current + $total);

        $previous   = self::_getNumberPrevious();
        $next       = self::_getNumberNext();

        for ( $i = $previous; $i <= $next; $i++)
        {
            $this->_numberArr[] = $i;
        }

        return $this->_numberArr; 

    } 




    private function _setNumberPrevious($number)
    {
        $number = (int) $number;

        if ($number < 1)
        {
            $number = 1;
        }

        $this->_numberPrevious = $number;


        return $this;
    }





    private function _setNumberNext($number)
    {
        $number = (int) $number;

        if ($number > $this->_totalRows)
        {
            $number = $this->_totalRows;
        }

        $this->_numberNext = $number;


        return $this;
    }


    private function _getNumberPrevious()
    {
        return $this->_numberPrevious;
    }


    private function _getNumberNext()
    {
        return $this->_numberNext;
    }




    private function _getPlus()
    {
        return $this->_plus;
    }

    private function _setPlus($plus)
    {
        $this->_plus = (int) $plus;
        return $this;
    }


    private function _getLess()
    {
        return $this->_less;
    }

    private function _setLess($less)
    {
        $this->_less = (int) $less;
        return $this;
    }



    public function getCurrentPage()
    {
        return $this->_currentPage;
    }




    public function setCurrentPage($currentPage)
    {
        $num = (int) $currentPage;
        $currentPage = ($num) ? $num : 1;

        $this->_currentPage = $currentPage; 
        return $this;
    }




    public function getPerPage()
    {
        return $this->_perPage;
    }




    public function setPerPage($number)
    {
        $this->_perPage = (int) $number;
        return $this;
    }





    public function getStartPage()
    {
        return $this->_startPage;
    }



    private function _setStartPage($currentPage)
    {

        $p = self::getPerPage();
        $c = $currentPage;

        $startPage = ($p * $c -$p);

        $this->_startPage = $startPage;
        return $this;
    }


    public function haveToPaginate()
    {
        return (self::_getTotalRows() > 1); 
    } 




    public function init()
    {

        $current = self::getCurrentPage();
        $total = self::getTotal() / self::getPerPage();

        self::_setStartPage($current);
        self::_setTotalRows(ceil($total));

        self::_setPlus($current - 1);
        self::_setLess($current + 1);

        self::_setFirstPage($current);
        self::_setPreviousPage(self::_getPlus());
        self::_setNextPage(self::_getLess());
        self::_setLastPage($current);

    } 


}



