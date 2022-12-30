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

    public function competences()
	{
        ini_set('memory_limit', '-1'); //car trop de ligne en latéral FIXME
        /*
            tableau[row;col]
            recuperer les tp dans l'ordre de et les objectifs pedas à travers les TP et les compétencesInter
            boucle [1;1->n] Ajouter les TP pour chaque colonne.

        */
        //on récupère les TPs
		$tableTps = TableRegistry::get('TravauxPratiques');

		$listTPs = $tableTps->find()
            ->contain(['Rotations.Periodes','ObjectifsPedas.CompetencesIntermediaires'])
            ->order([
                'Periodes.numero' => 'ASC',
                'Rotations.numero' => 'ASC',
            ])
            ->toArray();

        //on récupère les ObjectifsPedas
		$tableObjs = TableRegistry::get('ObjectifsPedas');

		$listObjs = $tableObjs->find()
            ->contain(['NiveauxCompetences','CompetencesIntermediaires.CompetencesTerminales.Capacites'])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC',
                'NiveauxCompetences.numero' => 'ASC',
            ])
            ->toArray();

        //on récupère les coméptences intermédiaires
		$tableComps = TableRegistry::get('CompetencesIntermediaires');

		$listComps = $tableComps->find()
            ->contain(['CompetencesTerminales.Capacites'])
            ->order([
                'Capacites.numero' => 'ASC',
                'CompetencesTerminales.numero' => 'ASC',
                'CompetencesIntermediaires.numero' => 'ASC',
            ])
            ->toArray();

        //debug($listObjs); die;
        /*
        trouve le numéro de coméptence corespondant
        */
        function getNivoComp ($objId, $listObjs){
            $value = '';
            foreach ($listObjs as $obj) {
                if ($objId == $obj->id ) {
                    return ($obj->niveaux_competence->numero);
                }
            }
        }

        // ajoute les noms des TPs à la première ligne du tableau
        foreach ($listTPs as $key => $tp) {
            $progression[0][$key + 1] = $tp->fullName;
        }

        // ajoute les CompetencesIntermediaires pour chaques colonnes tel que [1->n;0]
        foreach ($listComps as $key => $comp) {
            $progression[$key + 1][0] = $comp->fullName;
        }



        //debug($listTPs);die;
        foreach ($listTPs as $col => $tp) { //itère la list des TP
            $objsInTP = $tp->objectifs_pedas; //récupère le liste des Objs Péda pour le TP
            foreach ($objsInTP as $obj) { //itère la list de compétences du TP
                $compInterId = $obj->competences_intermediaire->id; //récupère
                foreach ($listComps as $row => $comp) { //pour chaque ligne (donc chaque compétence Inter)
                    $compId = $comp->id;
                    $objId  = $obj->id;
                    if ($compId == $compInterId) {
                        if (isset($progression[$row + 1 ][$col + 1])) {
                            $progression[$row + 1 ][$col + 1] = (string)$progression[$row + 1 ][$col + 1] ."-". (string)getNivoComp($objId, $listObjs);
                        }else{
                            $progression[$row + 1 ][$col + 1] = getNivoComp($objId, $listObjs);
                        }
                    }
                }
            }
        }
        unset($col); unset($row);
        //debug(count($listComps));debug(count($listTPs));
        // ajoute dans le tableau la valeur '' pour ne pas avoir de problème de d'offset
        for ($row=1; $row < count($listComps) ; $row++) {
            for ($col=1; $col < count($listTPs) ; $col++) {
                if (empty($progression[$row][$col]) or
                    is_null($progression[$row][$col]) or
                    !isset($progression[$row][$col])) {
                    $progression[$row][$col] = "";
                }
            }
        }
        //debug($progression);die;
        $this->set(compact('progression','listTPs','listComps'));
        //debug($progression->toArray());
	}
}
