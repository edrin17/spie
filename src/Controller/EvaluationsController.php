<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
/**
 * MaterielsTravauxPratiques Controller
 */
class EvaluationsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		//$this->viewBuilder()->setLayout('view');
	}

    /**
     *On récupère les classes et les prériodes pour le selection de l'évaluation
     */
    public function index()
    {
		//on récupère les rotations
		$tableRotations = TableRegistry::get('Rotations');

		$rotations = $tableRotations->find()
            ->contain(['Periodes'])
            ->order([
                'Periodes.numero' => 'ASC',
                'Rotations.numero' => 'ASC',
            ]);

        //on récupère les Périodes
		$tablePeriodes = TableRegistry::get('Periodes');

		$periodes = $tablePeriodes->find()
            ->order([
                'Periodes.numero' => 'ASC',
            ]);
		$nameController = 'Evaluations';
        $nameAction = 'evaluate';
        $this->set(compact('nameController', 'nameAction'));
        $this->set(compact('periodes','rotations'));

    }

	public function evaluate($rotation_id = null, $selectedEleve = null){

        $tableRotations = TableRegistry::get('Rotations');
		$tableValeurs = TableRegistry::get('ValeursEvals');
        $tableTypesEval = TableRegistry::get('TypesEvals');
        $tableClasses = TableRegistry::get('Classes');
        $tableEleves = TableRegistry::get('Eleves');
        $tableTps = TableRegistry::get('TravauxPratiques');
        $tableTpEleves = TableRegistry::get('Tp_Eleves');

        //debug($this->request->getQuery());
        $rotation_id = $this->request->getQuery('rotation');
        $periode_id = $this->request->getQuery('periode');
        $classe_id = $this->request->getQuery('classe');
        $eleve_id = $this->request->getQuery('eleve_id');
        $tpEleve_id = $this->request->getQuery('tp_id');
        //debug($tpEleve_id);
        //si sauvegarde (POST)
        if ($this->request->is('POST')) {
            //debug($this->request->getData());die;
            $tp_id = $this->request->getData('tp_id');
            $tp = $tableTps->get($tp_id,[
                'contain' => [
                    'Rotations.Periodes.Classes',
                    'ObjectifsPedas.CompetencesIntermediaires.CompetencesTerminales.Capacites',
                    'ObjectifsPedas.NiveauxCompetences',
                ]
            ]);
            //$selectedRotationId = $this->request->getData('selectedRotationId');
            //$selectedPeriodeId = $this->request->getData('selectedPeriodeId');
            //$selectedClasseId = $this->request->getData('selectedClasseId');
            /*
            foreach ($request as $key => $value) {
                //on extrait le debut de la clé pour voir si c'est uuid
                $dataKey = substr($key,0,5);
                // si uuid
                // on extrait les données d'indentification du TP & de l'élève pour la sauvegarde
                // et le rafraichissement
                switch ($dataKey) {
                    case 'tpId_';
                        //on supprime de la chaîne le bout 'tpId_'
                        //debug($key);
                        $key = substr($key,5);
                        //debug($key);
                        //récupère l'id du TP
                        $tp_id = substr($key,0,36);
                        //debug('tp_id:'.$tp_id);
                        //on supprime de la chaîne l'id du TP + '_selectedLVL1_'
                        $key = substr(substr($key,36),13);
                        //debug($key);
                        //récupère l'id du selectedLVL1
                        $selectedClasse = substr($key,0,36);
                        //debug('tp_id:'.$selectedClasse);
                        //on supprime de la chaîne l'id du TP + '_selectedLVL1_'
                        $key = substr(substr($key,36),13);
                        //debug($key);
                        //récupère l'id du selectedLVL2
                        $selectedEleve = substr($key,0,36);
                        //debug('tp_id:'.$selectedEleve);
                        //on supprime de la chaîne l'id du TP + '_options_'
                        $key = substr(substr($key,36),9);
                        //on supprime de la chaîne l'id de selectedEleve + '_options_'
                        $rotation_id = substr($key,0,36);
                        //debug('rotation_id:'.$rotation_id);die;

                    break;

                    case 'valeu'; //si valeurEval
                        $objPedaId = substr($key,-36);
                        $data[$objPedaId]['value'] = $value;
                    break;

                    case 'typeE'; //si typeEval
                        $objPedaId = substr($key,-36);
                        $data[$objPedaId]['type'] = $value;
                    break;
                }
            }*/
            $tp_id = $this->request->getData('tp_id');
            $selectedEleve = $this->request->getData('eleve_id');
            foreach ($tp->objectifs_pedas as $objPeda) {
                $data[$objPeda->id]['value'] = $this->request->getData('valeurEval-'.$objPeda->id);
                $data[$objPeda->id]['type'] = $this->request->getData('typeEval-'.$objPeda->id);
            }

            //debug($data);die;
            if (isset($data)) { //si aucune compétence dans le TP
                $this->_saveData($selectedEleve, $data, $tp_id);
            }

            return $this->redirect([
                'controller' =>'Suivis', 'action' => 'tp',1,
                '?' => [
                    'classe' => $this->request->getData('selectedClasseId'),
                    'rotation' => $this->request->getData('selectedRotationId'),
                    'periode' => $this->request->getData('selectedPeriodeId'),
                    ]]
            );
        }
        /*elseif (isset($_GET['options'])) { //juste un choix normal de selection
            $rotation_id = $_GET['options'];
        }
		//@returns $selectedClasse
        function getClasse() {
            if (isset($_GET['LVL1'])) {
                $selectedClasse = $_GET['LVL1'];
            }else{
                $selectedClasse = null;
            }
            return $selectedClasse;
        }

        //@returns $eleve_id
        function getEleve() {
            if (isset($_GET['LVL2'])) {
                $eleve_id = $_GET['LVL2'];
            }else{
                $eleve_id = null;
            }
            return $eleve_id;
        }

        $selectedClasse = getClasse();
        $eleve_id = getEleve();

        $tableEleves = TableRegistry::get('Eleves');
        $tableClasses = TableRegistry::get('Classes');

        $listClasses = $tableClasses->find()
						->where(['Classes.archived' => 0])
            ->order(['Classes.nom' => 'ASC']);

        $listEleves = $tableEleves->find()
						->order(['Eleves.nom' => 'ASC']);
        //debug($listClasses->toArray());die;

        //si on a sélectionné une classe
        if ($selectedClasse != null) {
            //si on a sélectionné un élève récupère l'entity eleve'
            if ($eleve_id != null) {
                $selectedEleve = $tableEleves->get($eleve_id,['contain' => [] ]);
                $listEleves = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC']);

            } else {//sinon on récupere la première entity élève de classe coresspondante
                $listEleves = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC']);

                $selectedEleve = $tableEleves->find()
                    ->where(['classe_id' => $selectedClasse])
                    ->order(['Eleves.nom' => 'ASC'])
                    ->first();
            }
        } else {
            $classe = $tableClasses->find()
                ->where(['Classes.archived' => 0])
                ->order(['Classes.nom'])
                ->first();
            $selectedClasse = $classe->id;
            $listEleves = $tableEleves->find()
                ->where(['classe_id' => $selectedClasse])
                ->order(['Eleves.nom' => 'ASC']);

            $selectedEleve = $tableEleves->find()
                ->where(['classe_id' => $classe->id])
                ->order(['Eleves.nom' => 'ASC'])
                ->first();
        }

        //changement de variable pour correspondre à la vue standard
        $nameController = 'Evaluations';
        $nameAction = 'evaluate';
        $options = $rotation_id;

        $listLVL1 = $listClasses;
        $listLVL2 = $listEleves;

        $selectedLVL1 = $selectedClasse;
        $selectedLVL2 = $selectedEleve;

        //passage des variables pour le layout
        $this->set('titre', "Evaluation ".$selectedEleve->nom." ".$selectedEleve->prenom);

        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'selectedLVL2','selectedLVL1','listLVL1','listLVL2','nameController',
            'nameAction', 'options'
        )); */
        $selectedEleve = $tableEleves->get($eleve_id);
        //on charge la rotation correspondante
        $rotation = $tableRotations->get($rotation_id,[
			'contain' => [
				'TravauxPratiques.ObjectifsPedas.CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'TravauxPratiques.ObjectifsPedas.NiveauxCompetences',
                'TravauxPratiques.Rotations.Periodes.Classes',
                'Periodes.Classes'
			]
		]);

        //$listTps = $rotation->travaux_pratiques;
        //debug($listTps);die;
		$listValeursEvals = $tableValeurs->find('list')
			->order(['numero' => 'ASC']);

		$listTypesEvals = $tableTypesEval->find('list')
			->order(['numero' => 'ASC']);


        //on classe les objectifs pedas dans l'ordre pour chaque TP
        $tp_eleve = $tableTpEleves->get($tpEleve_id,[
            'contain' => [
                'TravauxPratiques',
                ]
            ]);

        $tp = $tableTps->get($tp_eleve->travaux_pratique->id,[
            'contain' => [
                'Rotations.Periodes.Classes',
                'ObjectifsPedas.CompetencesIntermediaires.CompetencesTerminales.Capacites',
                'ObjectifsPedas.NiveauxCompetences',
                ]
            ]);
        $tp_id = $tp->id;
        //debug($tp_eleve);
        //debug($tp);die;
        //foreach ($listTps as $tp) {


            if (!empty($tp->objectifs_pedas)) {//si aucune compétence dans le TP

                foreach ($tp->objectifs_pedas as $objPeda) {
                    $objPeda->set('join_tableized', str_replace("-","_",$objPeda->_joinData->id));
                    $numberedObjPeda[$objPeda->code] = $objPeda;
                }

                ksort($numberedObjPeda);
                $tp->objectifs_pedas = $numberedObjPeda;
                $tp->set('tableized', str_replace("-","_",$tp->id));
                $numberedObjPeda = [];
            }
		//}

        //on regarde si les TP on été évalués précédemment
        //foreach ($listTps as $tp){
            //$tp_id = $tp->id;
            //$evaluated = $this->_evaluated($tp_id, $eleve_id);
            //$tp->set('evaluated', $evaluated);
            $existingData[$tp_id] = $this->_getExistingData($tp_id, $eleve_id);
        //}
        //debug($listTps);die;
        //debug($existingData);die;
		$this->set(compact(
            'tp','existingData','listValeursEvals','selectedEleve','tpEleve_id',
            'listTypesEvals','selectedEleve','periode_id','rotation_id', 'classe_id',
        ));

	}

    public function updatedb(){
        //on récupère les evals
		$tableEvals = TableRegistry::get('Evaluations');

		$evalsList = $tableEvals->find()
            ->contain(['TravauxPratiquesObjectifsPedas.TravauxPratiques',
                'TravauxPratiquesObjectifsPedas.ObjectifsPedas']);
        $evalsList = $evalsList->toArray();
        foreach ($evalsList as $eval) {
            $id = $eval->id;
            $TPIdToWrite = $eval->travaux_pratiques_objectifs_peda->travaux_pratique->id;
            $ObjPedaIdToWrite = $eval->travaux_pratiques_objectifs_peda->objectifs_peda->id;

            $evalToModif = $tableEvals->get($id);

            $evalToModif->travaux_pratique_id = $TPIdToWrite;
            $evalToModif->objectifs_peda_id = $ObjPedaIdToWrite;
            $tableEvals->save($evalToModif);

        }
        $this->set(compact('evalsList'));
    }


    /**
     * Efface une évaluation
     */
	protected function _delete($eval = null)
    {
        if ($this->Evaluations->delete($eval)) {
            $erreur = false;
            $this->Flash->success(__("L'évaluation a été modifiée."));
        } else {
            $erreur = true;
            $this->Flash->error(__("L'évaluation n'a pas été supprimée."));
        }
    }
    /*
     *
     * name: _evaluated
     * Permet de mettre une couleur et affiché si toutes les micro-compétences du TP
     * ont été évaluées
     * @param
     *  $tp_id(string(char36)): entity uuid of the TP
     *  $eleve_id(string(char(36)) : entity uuid of the eleve
     * @return
     *  $etat(array): ['value'(string), 'label_color'(string)];
     *
     */
    protected function _evaluated($tp_id, $eleve_id, $tpEleve_id)
    {
        //on récupère la liste des entities lien tp<->objspedas
        $tableTps = TableRegistry::get('TravauxPratiques');
        $tp = $tableTps->get($tp_id,['contain'=> 'TravauxPratiquesObjectifsPedas']);

        //debug($tp_id);debug($eleve_id);die;

        //on compte combien il y a d'ObjectifsPedas dans le TP
        $objsPedasDuTp = $tp->travaux_pratiques_objectifs_pedas;
        $nbObjsPedas = count($objsPedasDuTp);

        //on compte le nombre d'évals qui matchent le TP et l'élève à travers TP_ObjPeda
        $tableEvaluations = TableRegistry::get('Evaluations');
        $compteur = 0;
        foreach ($objsPedasDuTp as $objPeda) {
            $nbEvals = $tableEvaluations->find()
                ->where([
                    'travaux_pratiques_objectifs_peda_id' => $objPeda->id,
                    'eleve_id' => $eleve_id
                ])
                ->count();
            $compteur = $compteur + $nbEvals;
        }
        //debug($compteur.'vs'.$nbObjsPedas);//debug($nbEvals);
        //on renvoie l'état
        if ($compteur === 0) {
            $etat = ['value' => 'Non évalué', 'label_color' => 'label-default'];
        }
        elseif (($compteur > 0) and ($compteur < $nbObjsPedas)) {
            $etat = ['value' => 'Incomplet', 'label_color' => 'label-warning'];
        }
        elseif ($compteur === $nbObjsPedas){
            $etat = ['value' => 'Évalué', 'label_color' => 'label-success'];
        }else {
            $etat = ['value' => 'Erreur!', 'label_color' => 'label-danger'];
        }
        return $etat;
    }

    /*
     * Save data in DB.
     * @param
     *  $selectedEleve(string(char36)): entity uuid of the eleve
     *  $data(array) : array withthe content of the evaluation
     * @return
     *  $erreur(boolean): if the save of data is ok -> false else True
     *
     */
    protected function _saveData($selectedEleve, $data, $tpId)
    {
        $tableEvaluations = TableRegistry::get('Evaluations');
        $tableValeurs = TableRegistry::get('ValeursEvals');
        $tableTps = TableRegistry::get('TravauxPratiques');
        $erreur = false;
        //on récupère le TP avec le lien qui le lie à objectif_peda
        $tp = $tableTps->get($tpId,[
            'contain'=> ['TravauxPratiquesObjectifsPedas']
        ]);
        $listLinks = $tp->travaux_pratiques_objectifs_pedas;
        //cherche le lien correspondant
        function findLink($tpId, $objPedaId, $listLinks) {
            $linkId = null;
            //pour chaque lien on regarde si ça match
            foreach ($listLinks as $link) {
                $tpOfLink = $link->travaux_pratique_id;
                $objPedaOfLink = $link->objectifs_peda_id;
                if (($tpOfLink === $tpId) and ($objPedaOfLink === $objPedaId)) {
                    $linkId = $link->id; //si ça match on récupère l'id'
                }
            }
            return $linkId;
        }

        foreach ($data as $key => $value) {
            $objPedaId = $key;
            $toSaveData = [
                'types_eval_id' => $value['type'],
                'valeurs_eval_id' => $value['value'],
                'eleve_id' => $selectedEleve,
                'travaux_pratiques_objectifs_peda_id' => findlink($tpId, $objPedaId,$listLinks),
                'travaux_pratique_id' => $tpId,
                'objectifs_peda_id' => $objPedaId,
                'date_eval' => strtotime(date('Y-m-d'))

            ];
            //debug($toSaveData);die;
            $numeroValeur = $tableValeurs->find()
                ->where([
                    'id' => $value['value']
                ])
                ->first();
            //debug($numeroValeur);die;
            $numeroValeur = $numeroValeur->numero;

            $eval = $tableEvaluations->find()
                ->where([
                    'objectifs_peda_id' => $objPedaId,
                    'travaux_pratique_id' => $tpId,
                    'eleve_id' => $selectedEleve
                ])
                ->first();
            //si eval n'existe pas et n'est pas non notée'
            //crée l'éval et sauvegarde'
            if (($eval === null) and ($numeroValeur >= 0)) {
                $evaluation = $this->Evaluations->newEntity();
                $evaluation = $this->Evaluations->patchEntity($evaluation, $toSaveData);

                if ($this->Evaluations->save($evaluation) and ($erreur == false)) {
                    $erreur = false;
                } else {
                    $erreur = true;
                }//si eval existe&&notée on fait modif
            }elseif (($eval !== null) and($numeroValeur >= 0)) {
                $evaluation = $this->Evaluations->get($eval->id);
                $evaluation = $this->Evaluations->patchEntity($evaluation, $toSaveData);
                if ($this->Evaluations->save($evaluation) and ($erreur == false)) {
                    $erreur = false;
                } else {
                    $erreur = true;
                }//si eval existe && NON notée on supprime
            }elseif (($eval !== null) and ($numeroValeur === -1)) {
                $this->_delete($eval);
            }
        }
        return $erreur;
    }
    /*
     *
     * name: _getExistingData
     * Get existing data from DB in the case we're editing an already evaluated obje_peda
     * @param
     *  $tp_id(string(char36)): entity uuid of the TP
     *  $eleve_id(string(char(36)) : entity uuid of the eleve
     * @return
     *  $existingData(object entity): data of the corresponding evaluation
     *
     */
    protected function _getExistingData($tp_id, $eleve_id){

        $existingData = null;

        //on récupère la liste des entities lien tp<->objsPedas
        $tableTps = TableRegistry::get('TravauxPratiques');
        $tp = $tableTps->get($tp_id);

        //récupère les eval qui matchent le TP et l'élève
        $tableEvaluations = TableRegistry::get('Evaluations');
        $listEval = $tableEvaluations->find()
                ->where([
                    'travaux_pratique_id' => $tp_id,
                    'eleve_id' => $eleve_id
                ]);
        foreach ($listEval as $eval) {
            $existingData[$eval->objectifs_peda_id] = $eval;
        }

        //$objsPedasDuTp = $tp->travaux_pratiques_objectifs_pedas;

        //on récupère les évals qui matchent le TP et l'élève
        /*
        foreach ($objsPedasDuTp as $objPeda) {
            $eval = $tableEvaluations->find()
                ->where([
                    'travaux_pratiques_objectifs_peda_id' => $objPeda->id,
                    'eleve_id' => $eleve_id
                ])
                ->first();
            $existingData[$objPeda->id] = $eval;
        } */
        return $existingData;
    }

}
