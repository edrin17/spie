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

	public function tp()
	{
        $referential_id = $this->request->getQuery('referential_id');
        $referentialsTable = TableRegistry::get('Referentials');
		$referentials = $referentialsTable->find('list')
			->order(['id' => 'ASC']);

        if (is_null($referential_id)) {
            $referential_id = $referentialsTable->find()
                ->first()
                ->id;
        }
        $periodes = TableRegistry::get('Periodes');

		$listPeriodes = $periodes->find()
            ->where(['referential_id' => $referential_id])
            ->contain([
                'Rotations.TravauxPratiques.Materiels.Marques',
                'Rotations.TravauxPratiques.Materiels.TypesMachines',
                'Rotations.Periodes',
                'Rotations.Themes'
            ])

			->order(['Periodes.numero' => 'ASC']);

        $listPeriodes = $listPeriodes->toArray();

        //on classe les rotations de chaque periode par numero ASC
        $nbTpTotal = 0;
        foreach ($listPeriodes as $periode) {
            $tpByPeriode = 0;
            foreach ($periode->rotations as $rotation) {
				$numberedRotations[$rotation->numero] = $rotation;
                $tpByRotation = 0;
                foreach ($rotation->travaux_pratiques as $tp) {
                    if ($tp->specifique == 0) {
                        $tpByPeriode ++;
                        $tpByRotation ++;
                        $nbTpTotal ++;

                        $rotation->tpByRotation = $tpByRotation;
                    }

                }
            $periode->tpByPeriode = $tpByPeriode;
			}
			ksort($numberedRotations);
			$periode->rotations = $numberedRotations;
			$numberedRotations =[];
		}
        //debug($listPeriodes);die;
		//$listPeriodes = new Collection($tablePeriodes);

		//debug($listPeriodes);die;
		$this->set(compact('listPeriodes','nbTpTotal','referentials','referential_id'));
	}
}
