<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Bootstrap test controller
 */
class BootstrapController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {

    }

}
