<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;

class IndexController extends AbstractActionController
{

	public function __construct()
    {
        $this->auth = new AuthenticationService();
    }

    public function indexAction()
    {
    	if($this->auth->hasIdentity()) {
    		$this->layout()->authOk = true;
    	}
        return new ViewModel();
    }
}
