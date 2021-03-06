<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
/**
 * TravauxPratiquesObjectifsPedasController
 */
class TravauxPratiquesObjectifsPedasController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     * Liste les objectifs peda en relation avec le TP:
     *
     *
     *	@params $id
     *	@return $listObjsPedas
     *
     */
    public function index($tp_id = null)
    {
        if ($tp_id == null) //If null we go back to previous page.
		{
			return $this->redirect(['controller' => 'TravauxPratiques', 'action' => 'index']);
		}

        $travauxPratiques = TableRegistry::get('TravauxPratiques');
        $objectifsPedas = TableRegistry::get('ObjectifsPedas');
        $selectedLVL1_id = $this->request->getQuery('selectedLVL1_id');
		$selectedLVL2_id =$this->request->getQuery('selectedLVL2_id');
		$spe = $this->request->getQuery('spe');
        debug($this->request->getQuery());
        debug($tp_id);
        //find list of objectifs pedas writtening $id
        $tp = $travauxPratiques->get($tp_id,[
			'contain' => ['Rotations.Periodes','Rotations.Themes']
		]);


		$listObjsPedas = $objectifsPedas->find()
			->matching('TravauxPratiques', function($q) use ($tp_id) {
				return $q->where(['TravauxPratiques.id' => $tp_id]);
			})
			->contain([
				'CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences'
			]);
		//debug($listObjsPedas->toArray());//die;
        $this->set(compact('tp','listObjsPedas','tp_id','selectedLVL1_id','selectedLVL2_id', 'spe'));

    }
	/**
	 * Associe un objectif peda avec un TP
	 * @params $id :c'est l'id du TP
	 *
	 *
     **********************************************************/
    public function add($tp_id = null)
    {
		if ($tp_id == null) {
			return $this->redirect(['action' => 'index']);
		}
        $selectedLVL1_id = $this->request->getQuery('selectedLVL1_id');
		$selectedLVL2_id =$this->request->getQuery('selectedLVL2_id');
		$spe =$this->request->getQuery('spe');

		$objsPedas = TableRegistry::get('ObjectifsPedas');
		$listObjsPedas = $objsPedas->find('list')
			->contain([
				'CompetencesIntermediaires.CompetencesTerminales.Capacites',
				'NiveauxCompetences'
			])
			->order([
				'Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC',
				'CompetencesIntermediaires.numero' => 'ASC',
				'NiveauxCompetences.numero' => 'ASC'
			]);

		$travauxPratiques = TableRegistry::get('TravauxPratiques');
		$tp = $travauxPratiques->get($tp_id,[
			'contain' => ['Rotations.Periodes','Rotations.Themes']
		]);

        $tpObjPeda = $this->TravauxPratiquesObjectifsPedas->newEntity();
        if ($this->request->is('post')) {
            $selectedLVL1_id = $this->request->getData('selectedLVL1_id');
    		$selectedLVL2_id =$this->request->getData('selectedLVL2_id');
			$spe = $this->request->getData('spe');
            $tp_id =$this->request->getData('tp_id');
			//debug($this->request->getData());die;
            $tpObjPeda = $this->TravauxPratiquesObjectifsPedas
				->patchEntity($tpObjPeda, $this->request->getData());
            if ($this->TravauxPratiquesObjectifsPedas->save($tpObjPeda)) {
                $this->Flash->success(__(
					"L'association TP - Objectif P??da a ??t?? sauvegard??e."
				));
                return $this->redirect(['action' => 'index',
                    $tp->id,'?' => ['selectedLVL2_id' => $selectedLVL2_id, 'selectedLVL1_id' => $selectedLVL1_id, 'spe' => $spe]
                ]);
            } else {
                $this->Flash->error(__(
					"L'association TP - Objectif P??da n'a pas pu ??tre sauvegard??e ! R??essayer."
				));
            }
        }

        $this->set(compact('tpObjPeda','listObjsPedas','tp_id','tp','selectedLVL1_id','selectedLVL2_id', 'spe'));

    }

    /**
     * Efface une association
     */
    public function delete($id = null)      //Met le param??tre id ?? null pour ??viter un param??tre restant ou hack
    {
        $selectedLVL1_id = $this->request->getQuery('selectedLVL1_id');
        $selectedLVL2_id =$this->request->getQuery('selectedLVL2_id');
        $spe = $this->request->getQuery('spe');
        $tp_id =$this->request->getQuery('tp_id');
        //debug($this->request->getQuery());die;
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requ??te
        $tpObjPeda = $this->TravauxPratiquesObjectifsPedas->get($id);
        if ($this->TravauxPratiquesObjectifsPedas->delete($tpObjPeda)) {
            $this->Flash->success(__("L'association a ??t?? supprim??e."));
        } else {
            $this->Flash->error(__("L'association n'a pas pu ??tre supprim?? ! R??essayer."));
        }
        return $this->redirect(['action' => 'index',
            $tp_id,'?' => ['selectedLVL2_id' => $selectedLVL2_id, 'selectedLVL1_id' => $selectedLVL1_id, 'spe' => $spe]
        ]);
    }

    /**
     * Cr??e un tableau qui sera pass?? ?? la vue o?? on recense chaque association de chaque TP
     * par micro-comp??tence
     */
    public function view()
    {
        $spe = 0;
        if ($this->request->getQuery() !== null){
            $spe = $this->request->getQuery('spe');
        }
        //On cr??e l'en-t??te du tableau dynamiquement en fonction des niveaux de comp??tence
        //le nb de colonnes servira dimensionnement de r??f??rence pour la suite du tableau

        //cr??ation des colonnes
        $tableNiveauxCompetences = TableRegistry::get('NiveauxCompetences');
        $listNiveauxCompetences = $tableNiveauxCompetences -> find()
            ->order(['numero' => 'ASC']);

        $nbColonnes = $listNiveauxCompetences->count();
        $n = 0 ;
        $tableHeader[$n] = '';
        foreach ($listNiveauxCompetences as $value) {
            $n++;
            $tableHeader[$n] = $value->nom;
        }
        //cr??ation des lignes
        $tableCompsInters = TableRegistry::get('CompetencesIntermediaires');
        $listCompsInters = $tableCompsInters->find()
			->contain([
				'CompetencesTerminales.Capacites',
                'ObjectifsPedas.NiveauxCompetences',
                'ObjectifsPedas.TravauxPratiques.Rotations.Periodes',
			])
			->order(['Capacites.numero' => 'ASC',
				'CompetencesTerminales.numero' => 'ASC',
				'CompetencesIntermediaires.numero' => 'ASC',
            ]);

        /*
         * Cr??ation du tableau:
         * Pour chaque comp??tences Inter ET pour chaque colonne (nbColonnes)
         * on it??re les Obj Pedas contenus dans la comp??tence
         * si le "numero" (son niveau d'acquisition) de la comp??tence correspond au n?? de colonne
         * on stocke la valeur sinon on stocke ""
         * @return: tableau[$ligne][$numColonne]["nom" => $nom, $contenu[]]
         */
        foreach ($listCompsInters as $comp) {
            $listMicroComps = $comp->objectifs_pedas;
            $nomComp = $comp->fullName;
            $row = $comp->fullName;
            for ($col = 0; $col <= $nbColonnes ; $col++) {

                $written = false;
                if ($col == 0) {
                    $tableau[$row][$col] = [
                            'nom' => $nomComp,
                            'contenu' => '',
                            'nbTPs' => '',
                    ];
                    $written = true;
                }



                foreach ($listMicroComps as $microComp) {
                    $nbTps = 0;
                    $numero = $microComp->niveaux_competence->numero;
                    $nomMicroComp = $microComp->nom;
                    $listTps = $microComp->travaux_pratiques;
                    //on ajoute remplace la cl?? de chaque TP par fullName contat??ner avec son ID
                    if (!empty($listTps)) {
                        foreach ($listTps as $tp) {
                            if ($tp->specifique == $spe) {
                                $nbTps ++;
                                $intermediateTable[$tp->fullName.'-'.$tp->id] = $tp;
                            }
                        }
                        if ($nbTps > 0){ //on regarde que la liste de Tp ne soir pas vide
                            ksort($intermediateTable);
                            $listTps = $intermediateTable;
                            unset($intermediateTable);
                        }
                    }


                    //on compte le nombre de TP par micro-competence
                    //$nbTps = count($listTps);
                    //en fonction du nombre de TP on change la couleur du badge
                    /*
                    success = "vert"
                    default = "noir"
                    warning = "orange"
                    info = "bleu"
                    danger = "rouge"
                    */
                    if ($nbTps >= 4) {
                        $lblColor = "success";
                    }
                    elseif ($nbTps === 0) {
                        $lblColor = "danger";
                    }
                    else {
                        $lblColor = "warning";
                    }




                    $contenu = '';

                    // on concatene les nom de tp au fromat html
                    foreach ($listTps as $tp) {
                        if ($tp->specifique == $spe) {
                            $contenu .= $tp->fullName ."</br>";
                        }
                    }


                    if ($numero === $col) {
                        $tableau[$row][$col] = [
                            'nom' => $nomMicroComp,
                            'contenu' => $contenu,
                            'nbTPs' => '<span class="label label-'
                                .$lblColor .' label-as-badge">'
                                .$nbTps .'TP</span>',
                        ];
                        $written = true;
                    }

                }
                if (!$written) {
                    $tableau[$row][$col] = [
                            'nom' => '',
                            'contenu' => '',
                            'nbTPs' => '',
                    ];
                }


            }

        }


        //debug($tableau);die;


        $this->set(compact('tableau','tableHeader','nbColonnes','spe'));

    }
}
