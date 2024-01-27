<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class ElevesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index($classe_id = null)
    {
        //on liste les classes pour le select qui sert de filtre de la vue avec numeNom
        $tbl_classes = TableRegistry::get('Classes');
        $listeClasses = $tbl_classes->find('list')
			->order(['nom' => 'ASC']);
        /* On regarde si un filtre par classe est appliqué sur la page index en POST
		 * (appuie sur le bouton 'filtrer du formulaire') ou si on a passé un paramètre */

		if ( ($this->request->is('post')) or ($classe_id !== null) )
		{
			//on stocke la valeur du formulaire pour utilisation utérieure
			$classe_id = $this->request->getData()['classe_id'];

			//debug($this->request->getData()['classe_id']);die;
			$eleves = $this->Eleves->find()
							->contain(['Classes'])
							->where(['classe_id' => $classe_id])
							->order(['Eleves.nom' =>'ASC'])
							->order(['Eleves.prenom' => 'ASC']);
		}else
		{
			$eleves = $this->Eleves->find()
							->contain(['Classes'])
							->order(['Classes.nom' =>'ASC'])
							->order(['Eleves.nom' =>'ASC'])
							->order(['Eleves.prenom' => 'ASC']);
		}

        //debug($listeEleves);die;
        $this->set(compact('listeClasses','eleves','classe_id'));
    }
    
    public function add($classe_id = null)
    {
        $eleve = $this->Eleves->newEntity();                                   // crée une nouvelle entité dans $eleve
        if ($this->request->is('post')) {                                           //si requête de type post
            $eleve = $this->Eleves->patchEntity($eleve, $this->request->getData());  //??
            if ($this->Eleves->save($eleve)) {
                $this->_updateTpEleves($eleve);                            
                $this->Flash->success(__("L'élève a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("L'élève n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $classes = $this->Eleves->Classes->find('list')->order(['nom' => 'ASC'])->toArray();
        $this->set(compact('eleve','classes','classe_id'));
    }


    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {

        //récupère le contenu de la table eleves_terminales en fonction de l'id'
        $eleve = $this->Eleves->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $eleve = $this->Eleves->patchEntity($eleve, $this->request->getData());
            if ($this->Eleves->save($eleve)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__("L'élève a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("L'élève n'a pas pu être sauvegardé ! Réessayer.")); //Sinon affiche une erreur
            }
        }

        // Récupère les données de la table Eleves et les classe par ASC
        $classes = $this->Eleves->Classes->find('list')->order(['nom' => 'ASC'])->toArray();
        $this->set(compact('eleve','classes'));
        $this->set('_serialize', ['eleve']);
    }

    /************* Affiche toutes les données d'un utilisateur************************
     ********************************************************************************/
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $eleve = $this->Eleves->get($id, ['contain' => [] ]);

        $classe = $this->Eleves->Classes->find()
							->select(['nom'])
							->matching('Eleves')
							->where(['Eleves.classe_id' => $eleve->classe_id])
							->first();


        $this->set(compact('eleve','classe'));                                  // Passe le paramètre 'eleve' à la vue.
        $this->set('_serialize', ['eleve']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $tableEval = TableRegistry::get('Evaluations');


        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $eleve = $this->Eleves->get($id);

        //selection de toutes les évals qui concernent l'élève'
        $listEvals = $tableEval ->find()
            ->where(['eleve_id' => $id])
            ->toArray();
        //suppression des évals de l'élève
        foreach ($listEvals as $eval) {
            $tableEval->delete($eval);
        }
        //suppression de l'élève
        if ($this->Eleves->delete($eleve)) {
            $this->Flash->success(__("L'élève a été supprimé."));
        } else {
            $this->Flash->error(__("L'élève n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

    private function _updateTpEleves($eleve = null) //on lie le nouveau TP au TP_Eleves
    {
        $tableTpEleves = TableRegistry::get('TpEleves');
        $tableTps = TableRegistry::get('TravauxPratiques');
        $listTPs = $tableTps->find();

        foreach ($listTPs as $tp) {
            $tpEleve = $tableTpEleves->newEntity();
            $tpEleve->eleve_id = $eleve->id;
            $tpEleve->travaux_pratique_id = $tp->id;
            $tpEleve->debut = null;
            $tpEleve->fin = null;
            $tpEleve->note = null;
            $tpEleve->pronote = false;
            $tpEleve->memo = '';
            $tableTpEleves->save($tpEleve);
        }
    }
}
