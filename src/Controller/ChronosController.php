<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

class ChronosController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    /*Affiche les micros compétences en fonction du temps
     *
     */
	public function index()
	{
        $this->_loadFilters();
        $progression_id = $this->viewVars['progression_id'];
        // on récupère les données qui matchent la rotation
        // sur la table TravauxPratiquesObjectifsPedas
        $listMatch = $this->_getTPObjsPedas($progression_id);
        //On récupère les compétences de la rotation à partir de $listMatch
        $tableauComp = $this->_listMicroComps($listMatch);
        //On récupère la liste de Tp de la rotation
        $tps = $this->_getTPlist($progression_id);
        //crée le tableau objXTP
        $tableauMatch = $this->_makeMatchArray($listMatch);
        //debug($tps->toArray());

        $this->set(compact('tableauComp','tps','tableauMatch'));
	}

    private function _loadFilters($resquest = null)
    {
        //chargement de la liste des référentiels
        $referentialsTbl = TableRegistry::get('Referentials');
        $referentials = $referentialsTbl->find('list')
            ->order(['name' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $referential_id = $this->request->getQuery('referential_id');

        //si requête vide slection du premier de la liste
        if ($referential_id =='') {
            $referential_id = $referentialsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'referentials', 'referential_id'
        ));

        $progressionsTbl = TableRegistry::get('Progressions');
        $progressions = $progressionsTbl->find('list')
            ->where(['referential_id' => $referential_id])
            ->order(['nom' => 'ASC']);
        
        $progression_id = $this->request->getQuery('progression_id');

        if ($progression_id =='') {
            $progression_id = $progressionsTbl->find()
            ->where(['referential_id' => $referential_id])
            ->order(['nom' => 'ASC'])
            ->first()
            ->id;
        }

        $classesTbl = TableRegistry::get('Classes');
        $classes = $classesTbl->find('list')
            ->where([
                'archived' => 0,
                'progression_id' => $progression_id
            ])
            ->order(['nom' => 'ASC']);
        $classe_id = $this->request->getQuery('classe_id');
        if ($classe_id =='') {
        $classe_id = $classesTbl->find()
            ->where([
                'archived' => 0,
                'progression_id' => $progression_id
            ])
            ->first()
            ->id;
        }

        $tachesTbl = TableRegistry::get('TachesPros');
        $taches = $tachesTbl->find('list')
            ->contain(['Activites'])
            ->order([
                'Activites.Numero' => 'ASC',
                'TachesPros.Numero' => 'ASC'
            ]);
        $tache_id = $this->request->getQuery('tache_id');
        if ($tache_id =='') {
        $tache_id = $tachesTbl->find()
        ->contain(['Activites'])
        ->order([
            'Activites.Numero' => 'ASC',
            'TachesPros.Numero' => 'ASC'
            ])
            ->first()->id;
        }
        $this->set(compact( //passage des variables à la vue
            'classes', 'classe_id',
            'progression_id', 'progressions',
            'taches', 'tache_id'
        ));
    }

    /*
     * Récupère la liste des liens TravauxPratiquesObjectifsPedas
     */
    protected function _getTPObjsPedas($progression_id)
    {
        $tpXobjTable = TableRegistry::get('TravauxPratiquesObjectifsPedas');
        $listMatch = $tpXobjTable->find()
            ->contain([
                'TravauxPratiques.Rotations.Periodes.Progressions',
                'ObjectifsPedas.CompetencesIntermediaires.CompetencesTerminales.Capacites',
                'ObjectifsPedas.NiveauxCompetences',
            ])
            ->where(['progression_id' => $progression_id])
            ->where(['TravauxPratiques.specifique' => 0])
            ->order([
                'Capacites.numero',
                'CompetencesTerminales.numero',
                'CompetencesIntermediaires.numero',
                'NiveauxCompetences.numero',
            ]);
        return $listMatch;
    }
    /*
     * Récupère la liste des MicrosCompétences
     */
    protected function _listMicroComps($listeMatch)
    {
        $result = []; //defini le tableau pour ne pas avoir d'erreur si vide car pas de TP
        foreach ($listeMatch as $element)
        {
            $fullName = $element->objectifs_peda->fullName;
            $id = $element->objectifs_peda->id;
            $result[$id] = $fullName;
        }
        $tableauComp = array_unique($result);
        return $tableauComp;
    }
    /*
     * Récupère la liste des TP de la rotation
     */
    protected function _getTPlist($progression_id)
    {
        $tpTable = TableRegistry::get('TravauxPratiques');
        $tps = $tpTable->find('list')
            ->contain([
                'Rotations.Periodes.Progressions',
            ])
            ->where(['progression_id' => $progression_id])
            ->where(['TravauxPratiques.specifique' => 0])
            ->order([
                'Periodes.numero',
                'Rotations.numero',
                'TravauxPratiques.nom',
            ]);

        return $tps;
    }
    /*
     *Etabli la correspondance entre les TP et les objectifs pedas
     */
    protected function _makeMatchArray($listeMatch)
    {
        $tableauMatch= [];
        foreach ($listeMatch as $element)
        {
            $idComp = $element-> objectifs_peda->id;
            $idTP = $element->travaux_pratique->id;
            $tableauMatch[$idComp][$idTP] = true;
        }
        //debug($tableauMatch);die;
        return $tableauMatch;
    }

}
