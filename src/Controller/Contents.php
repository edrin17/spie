<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 */
class ContentsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function errors()
    {
        $objsPeda = TableRegistry::get('ObjectifsPedas');
        $TPs = TableRegistry::get('TravauxPratiques');
        $compsInters = TableRegistry::get('CompetencesIntermediaires');
        $TpObjPedas = TableRegistry::get('TravauxPratiquesObjectifsPedas');
        
        $listCompsInters = $compsInters->find()							
			->contain([
				'CompetencesTerminales.Capacites',
			])
            ->order([
                'Capacites.Numero',
                'CompetencesTerminales.Numero',
            ]);

        
        
        $listObjsPedas = $objsPeda->find()							
			->contain([
				'CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences'
			])
			->order(['Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC',
				'CompetencesIntermediaires.numero' => 'ASC',
				'NiveauxCompetences.numero' => 'ASC'
			]);
        
        $listTPs = $TPs->find()							
			->contain([
				'Rotations.Periodes'
			])
			->order(['Periodes.Numero' => 'ASC',
				'Rotations.numero' => 'ASC',
			]);
        
        $listTpObjPedas = $TpObjPedas->find();
        
        $tablErrors['vide'] = ['vide', 'vide'=>'vide', 'vide'=>'vide'];
        
        foreach ($listCompsInters as $compInter) {
            foreach ($listTPs as $TP) {
                $numObj = 0;
                foreach ($listObjsPedas as $objPeda) {
                    $matching = ($objPeda->competences_intermediaire_id === $compInter->id);
                    if ($matching) {
                        $numObj++;
                        foreach ($listTpObjPedas as $TpObjPeda) {
                            $matchingTP = ($TpObjPeda->travaux_pratique_id === $TP->id);
                            $matchingObjPeda = ($TpObjPeda->objectifs_peda_id === $objPeda->id);
                            $matching = ($matchingTP and $matchingObjPeda);
                            if ($matching) {
                                if (isset($compteur[$numObj])) {
                                    $compteur[$numObj]++;    
                                }else{
                                    $compteur[$numObj] = 1;    
                                }
                                //debug($compteur);
                                //die;
                                if (($numObj > 1) and (isset($compteur[$numObj-1]))) {
                                    if ($compteur[$numObj-1] <= 3) {
                                        $tablErrors [$compInter->id] = [
                                        $compInter->fullName,
                                        $objPeda->id => $objPeda->fullName,
                                        $TP->id => $TP->nom,
                                        ];
                                    }
                                    
                                    
                                }
                                
                            }
                            
                        }
                            
                    }
                    
                }
                  
            }
            
        }
        //die;
        $this->set(compact('tablErrors'));
        
    }

    
}
