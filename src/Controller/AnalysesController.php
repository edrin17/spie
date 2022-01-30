<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;

class AnalysesController extends AppController
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
		//chargement des onglets du tableau classeur
        $onglets = $this->_tabs(); //appel du tableau classeur

        //récupération des onglets cliqués par l'utilisateur transmis par _tabs()
        $listLVL1 = $onglets["listLVL1"];
        $listLVL2 = $onglets["listLVL2"];
        $selectedLVL1 = $onglets["selectedLVL1"];
        $selectedLVL2 = $onglets["selectedLVL2"];
        $nameController = 'Analyses';
        $nameAction = 'index';
        $options = '';

        //passage des variables pour le layout
        $this->set('titre', 'Progression des TP');


        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'selectedLVL2','selectedLVL1','listLVL1','listLVL2','nameController',
            'nameAction','options'
        ));

        //FIN tableau classeur

        // on récupère les données qui matchent la rotation
        // sur la table TravauxPratiquesObjectifsPedas
        $listMatch = $this->_getTPObjsPedas($selectedLVL2->id);
        //On récupère les compétences de la rotation à partir de $listMatch
        $tableauComp = $this->_listMicroComps($listMatch);
        //On récupère la liste de Tp de la rotation
        $listTP = $this->_getTPlist($selectedLVL2->id);
        //crée le tableau objXTP
        $tableauMatch = $this->_makeMatchArray($listMatch);

        $this->set(compact('tableauComp','listTP','tableauMatch'));
	}
    /*
     *Gestion du tableau classeur
     */
    protected function _tabs()
    {

        //TABLEAU CLASSEUR
        function getPeriode()
        {
            if (isset($_GET['LVL1'])) {
                $selectedPeriode = $_GET['LVL1'];
            }else{
                $selectedPeriode = null;
            }
            return $selectedPeriode;
        }


        //@returns $rotation_id
        function getRotation()
        {
            if (isset($_GET['LVL2'])) {
                $rotation_id = $_GET['LVL2'];
            }else{
                $rotation_id = null;
            }
            return $rotation_id;
        }

        $selectedPeriode = getPeriode();
        $rotation_id = getRotation();

        $tablePeriodes = TableRegistry::get('Periodes');
        $tableRotations = TableRegistry::get('Rotations');

        $listPeriodes = $tablePeriodes->find()
            ->order([
                'Periodes.numero' => 'ASC'
            ]);

        $listRotations = $tableRotations->find()
            ->contain(['Periodes'])
            ->order([
                'Periodes.numero' => 'ASC',
                'Rotations.numero' =>'ASC',
            ]);
        //si on a sélectionné une période
        if ($selectedPeriode != null){
            //si on a sélectionné une période on récupère la liste des rotations correspondante'
            $listRotations = $tableRotations->find()
                ->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order([
                  'Periodes.numero' => 'ASC',
                  'Rotations.numero' =>'ASC',
                ]);

            if ($rotation_id == null) { //si pas de rotation selectionnée on prend la première de la liste
                $selectedRotation = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order([
                      'Periodes.numero' => 'ASC',
                      'Rotations.numero' =>'ASC',
                    ])
                    ->first();
            } else {
                $selectedRotation = $tableRotations->get($rotation_id,['contain' => [] ]);
            }
        } else {
            $periode = $tablePeriodes->find()
                ->order([
                    'Periodes.numero' => 'ASC'
                ])
                ->first();
            $selectedPeriode = $periode->id;

            $listRotations = $tableRotations->find()
                ->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order([
                  'Periodes.numero' => 'ASC',
                  'Rotations.numero' =>'ASC',
                ]);

            $selectedRotation = $tableRotations->find()
                ->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order([
                  'Periodes.numero' => 'ASC',
                  'Rotations.numero' =>'ASC',
                ])
                ->first();
        }

        //modification d'un contenu des variables'
        foreach ($listPeriodes as $periode) {
            $periode->nom = 'P'.$periode->numero;
        }

        //modification d'un contenu des variables'
        foreach ($listRotations as $rotation) {
            $rotation->nom = $rotation->fullName;
        }


        //changement de variable pour correspondre à la vue standard
        $onglets = [
            "listLVL1" => $listPeriodes,
            "listLVL2" => $listRotations,

            "selectedLVL1" => $selectedPeriode,
            "selectedLVL2" => $selectedRotation,
        ];
        return $onglets;
    }
    /*
     * Récupère la liste des liens TravauxPratiquesObjectifsPedas
     */
    protected function _getTPObjsPedas($rotationId)
    {
        $tpXobjTable = TableRegistry::get('TravauxPratiquesObjectifsPedas');
        $listMatch = $tpXobjTable->find()
            ->contain([
                'TravauxPratiques.Rotations.Periodes.Classes',
                'ObjectifsPedas.CompetencesIntermediaires.CompetencesTerminales.Capacites',
                'ObjectifsPedas.NiveauxCompetences',
            ])
            ->where(['Rotations.id' => $rotationId])
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
    protected function _getTPlist($rotationId)
    {
        $tpTable = TableRegistry::get('TravauxPratiques');
        $listTPs = $tpTable->find()
            ->contain([
                'Rotations.Periodes',
            ])
            ->where(['Rotations.id' => $rotationId])
            ->where(['TravauxPratiques.specifique' => 0])
            ->order([
                'Periodes.numero',
                'Rotations.numero',
                'TravauxPratiques.nom',
            ]);

        foreach ($listTPs as $element)
        {
            $fullName = $element->fullName;
            $id = $element->id;
            $listTP[$id] = $fullName;
        }

        return $listTP;
    }
    /*
     *Etabli la correspondance entre les TP et les objectifs pedas
     */
    protected function _makeMatchArray($listeMatch)
    {
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
