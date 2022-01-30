<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * TravauxPratiques Controller
 */
class TravauxPratiquesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les TravauxPratiques:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les travauxPratiques terminales
     */
    public function index()
    {
        //chargement des onglets du tableau classeur
        $onglets = $this->_tabs();
        $listLVL1 = $onglets["listLVL1"];
        $listLVL2 = $onglets["listLVL2"];
        $selectedLVL1 = $onglets["selectedLVL1"];
        $selectedLVL2 = $onglets["selectedLVL2"];
        $nameController = $onglets["nameController"];
        $nameAction = $onglets["nameAction"];
        $options = $onglets["options"];
        //debug($onglets);die;

        //passage des variables pour le layout
        $this->set('titre', 'Progression des TP');


        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'selectedLVL2','selectedLVL1','listLVL1','listLVL2','nameController',
            'nameAction','options'
        ));

        //FIN tableau classeur

        //on récupère les bonnes données pour affichage
        $tableTPs = $this->TravauxPratiques;
        $listTPs = $tableTPs->find()
            ->contain(['Rotations.Periodes.Classes', 'Rotations.Themes'])
            ->where(['rotation_id' => $selectedLVL2->id])
            ->where(['specifique' => 0]);

        $this->set(compact('listTPs'));

    }
	/***************** Ajoute une tâche principale
     **********************************************************/
    public function add()
    {
		$rotations = TableRegistry::get('Rotations');

		$listRotations = $rotations->find('list')
			->contain(['Periodes.Classes'])
			->order([
				'Periodes.Numero' => 'ASC',
				'Rotations.Numero' => 'ASC'
			]);

        $taches = TableRegistry::get('TachesPros');
        $listTachesPro = $taches->find('list')
    			->contain(['Activites'])
    			->order([
    				'Activites.Numero' => 'ASC',
    				'TachesPros.Numero' => 'ASC'
    			]);

        $tp = $this->TravauxPratiques->newEntity();
        if ($this->request->is('post')) {
            $tp = $this->TravauxPratiques->patchEntity($tp, $this->request->getData());
            if ($this->TravauxPratiques->save($tp)) {
                $this->Flash->success(__('Le matériel a été sauvegardé.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le matériel n\'a pas pu être sauvegardé ! Réessayer.'));
            }
        }

        $this->set(compact('tp','listRotations','listTachesPro'));
    }


    /**
     * Édite un utilisateur
     */
    public function edit($id = null)
    {
        $rotations = TableRegistry::get('Rotations');
          $listRotations = $rotations->find('list')
        	->contain(['Periodes.Classes'])
        	->order([
        		'Periodes.Numero' => 'ASC',
        		'Rotations.Numero' => 'ASC'
        ]);

        $taches = TableRegistry::get('TachesPros');
        $listTachesPro = $taches->find('list')
        		->contain(['Activites'])
        		->order([
        			'Activites.Numero' => 'ASC',
        			'TachesPros.Numero' => 'ASC'
        ]);

        $tp = $this->TravauxPratiques->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $tp = $this->TravauxPratiques->patchEntity($tp, $this->request->getData());
            if ($this->TravauxPratiques->save($tp)) {                  //Sauvegarde les données dans la BDD
              $this->Flash->success(__('Le matériel a été sauvegardé.'));      //Affiche une infobulle
              return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
              $this->Flash->error(__('Le matériel n\'a pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }

        $this->set(compact('listRotations','tp','listTachesPro'));
    }

    /************* Affiche toutes les données d'un T.P************************
     ********************************************************************************/
    public function view($id = null)  //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $tp = $this->TravauxPratiques->get($id,[
			'contain' => ['Rotations.Periodes.Classes','Rotations.Themes']
		]);
        $this->set(compact('tp'));;

    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tp = $this->TravauxPratiques->get($id);
        if ($this->TravauxPratiques->delete($tp)) {
            $this->Flash->success(__("Le TP a été supprimé."));
        } else {
            $this->Flash->error(__("Le TP n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
    /**
     * suivi des TP
     */
    public function suivi($id = null)
    {
        //chargement des onglets du tableau classeur
        $onglets = $this->_tabs();
        $listLVL1 = $onglets["listLVL1"];
        $listLVL2 = $onglets["listLVL2"];
        $selectedLVL1 = $onglets["selectedLVL1"];
        $selectedLVL2 = $onglets["selectedLVL2"];
        $nameController = $onglets["nameController"];
        $nameAction = $onglets["nameAction"];
        $options = $onglets["options"];
        //debug($onglets);die;

        //passage des variables pour le layout
        $this->set('titre', 'Progression des TP');


        //passage des variables standardisées pour la vue tableauClasseur
        $this->set(compact(
            'selectedLVL2','selectedLVL1','listLVL1','listLVL2','nameController',
            'nameAction','options'
        ));

        //FIN tableau classeur

    }
    /*
     *Gestion du tableau classeur
     */
    protected function _tabs()
    {

        //TABLEAU CLASSEUR
        function getPeriode() {
            if (isset($_GET['LVL1'])) {
                $selectedPeriode = $_GET['LVL1'];
            }else{
                $selectedPeriode = null;
            }
            return $selectedPeriode;
        }


        //@returns $rotation_id
        function getRotation() {
            if (isset($_GET['LVL2'])) {
                $rotation_id = $_GET['LVL2'];
            }else{
                $rotation_id = null;
            }
            return $rotation_id;
        }

        $selectedPeriode = getPeriode();
        $rotation_id = getRotation();

        $tableTPs = $this->TravauxPratiques;
        $tablePeriodes = TableRegistry::get('Periodes');
        $tableRotations = TableRegistry::get('Rotations');

        $listPeriodes = $tablePeriodes->find()
            //->contain(['Classes'])
            ->order([
                //'Classes.nom' => 'ASC',
                'Periodes.numero' => 'ASC'
            ]);

        $listRotations = $tableRotations->find()
            //->contain(['Periodes.Classes'])
            ->contain(['Periodes'])
            ->order([
                //'Classes.nom' => 'ASC',
                'Periodes.numero' => 'ASC',
                'Rotations.numero' =>'ASC'
            ]);
        //si on a sélectionné une période
        if ($selectedPeriode != null) {
            //si on a sélectionné une période on récupère la liste des rotations correspondante'
            $listRotations = $tableRotations->find()
                ->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order(['Rotations.numero' => 'ASC']);

            if ($rotation_id == null) { //si pas de rotation selectionnée on prend la première de la liste
                $selectedRotation = $tableRotations->find()
                    ->contain(['Periodes'])
                    ->where(['periode_id' => $selectedPeriode])
                    ->order(['Rotations.numero' => 'ASC'])
                    ->first();
            } else {
                $selectedRotation = $tableRotations->get($rotation_id,['contain' => [] ]);
            }
        } else {
            $periode = $tablePeriodes->find()
                //->contain(['Classes'])
                ->order([
                    //'Classes.nom' => 'ASC',
                    'Periodes.numero' => 'ASC'
                ])
                ->first();
            $selectedPeriode = $periode->id;

            $listRotations = $tableRotations->find()
                ->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order(['Rotations.numero' => 'ASC']);

            $selectedRotation = $tableRotations->find()
                ->contain(['Periodes'])
                ->where(['periode_id' => $selectedPeriode])
                ->order(['Rotations.numero' => 'ASC'])
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


            "nameController" => 'TravauxPratiques',
            "nameAction" => 'index',
            "options" => '',
        ];
        return $onglets;
    }

}
