<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

 namespace App\View;

 use BootstrapUI\View\UIViewTrait;
 use Cake\View\View;

 class AppView extends View
 {
     use UIViewTrait;

     /**
      * Initialization hook method.
      */
     public function initialize()
     {
         //render the initializeUI method from the UIViewTrait
         $this->initializeUI(['layout' => false]);
     }
 }
