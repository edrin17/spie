<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;
/**
 * MaterielsTravauxPratiques Controller
 */
class ProgressionsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
	public function index()
	{		
		$periodes = TableRegistry::get('Periodes');

		$listPeriodes = $periodes->find()	
			->contain([
                'Rotations.TravauxPratiques.Materiels.Marques',
                'Rotations.TravauxPratiques.Materiels.TypesMachines',
                'Rotations.Themes',
                'Rotations.Users'
            ])
			->order(['Periodes.numero' => 'ASC']);
		
		//on convertit en tableau pour classer les rotations de chaque periode par numero ASC
		$tablePeriodes = $listPeriodes->toArray();
		//on classe les rotations de chaque periode par numero ASC
		foreach ($tablePeriodes as $key => $periode) {
			foreach ($periode->rotations as $rotation) {
				
				$numberedRotations[$rotation->numero] = $rotation;
			}
			ksort($numberedRotations);
			$periode->rotations = $numberedRotations;
			$numberedRotations =[];
		}
		
		$listPeriodes = new Collection($tablePeriodes);
							
		//debug($listPeriodes);die;
		$this->set(compact('listPeriodes'));
	}
}











