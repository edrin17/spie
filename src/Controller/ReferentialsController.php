<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ProgressionsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
}
