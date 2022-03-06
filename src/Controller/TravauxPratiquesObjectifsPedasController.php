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
		$spe =$this->request->getQuery('spe');
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
					"L'association TP - Objectif Péda a été sauvegardée."
				));
                return $this->redirect(['action' => 'index',
                    $tp->id,'?' => ['selectedLVL2_id' => $selectedLVL2_id, 'selectedLVL1_id' => $selectedLVL1_id, 'spe' => $spe]
                ]);
            } else {
                $this->Flash->error(__(
					"L'association TP - Objectif Péda n'a pas pu être sauvegardée ! Réessayer."
				));
            }
        }

        $this->set(compact('tpObjPeda','listObjsPedas','tp_id','tp','selectedLVL1_id','selectedLVL2_id', 'spe'));

    }

    /**
     * Efface une association
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $tpObjPeda = $this->TravauxPratiquesObjectifsPedas->get($id);
        if ($this->TravauxPratiquesObjectifsPedas->delete($tpObjPeda)) {
            $this->Flash->success(__("L'association a été supprimée."));
        } else {
            $this->Flash->error(__("L'association n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Crée un tableau qui sera passé à la vue où on recense chaque association de chaque TP
     * par micro-compétence
     */
    public function view()
    {
        $spe = 0;
        if ($this->request->getQuery() !== null){
            $spe = $this->request->getQuery('spe');
        }
        //On crée l'en-tête du tableau dynamiquement en fonction des niveaux de compétence
        //le nb de colonnes servira dimensionnement de référence pour la suite du tableau

        //création des colonnes
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
        //création des lignes
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
         * Création du tableau:
         * Pour chaque compétences Inter ET pour chaque colonne (nbColonnes)
         * on itère les Obj Pedas contenus dans la compétence
         * si le "numero" (son niveau d'acquisition) de la compétence correspond au n° de colonne
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
                    //on ajoute remplace la clé de chaque TP par fullName contaténer avec son ID
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
                    if ($nbTps === 4) {
                        $lblColor = "success";
                    }
                    elseif ($nbTps === 0) {
                        $lblColor = "danger";
                    }
                    elseif ($nbTps > 4) {
                        $lblColor = "info";
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
