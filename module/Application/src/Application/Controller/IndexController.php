<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        $loginview = new ViewModel();
        $loginview->setTemplate('layout/layout_1');
        $view->addChild($loginview, 'login');
//        cambiar el layout
//        $view->setTemplate('mi_layout');
//        deshabilitar el leyout
//        $view->setTerminal(true);
        return $view;
    }
}