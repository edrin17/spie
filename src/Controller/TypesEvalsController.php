<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class TypesEvalsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
     public function index()
    {
        // Utilise le helper paginate
        $this->set('typesEvals', $this->paginate($this->TypesEvals)); //'typesEvals' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['typesEvals']);
    }

	/**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $typesEval = $this->TypesEvals->newEntity();                                   // crée une nouvelle entité dans $typesEval
        if ($this->request->is('post')) {                                           //si requête de type post
            $typesEval = $this->TypesEvals->patchEntity($typesEval, $this->request->getData());  //??
            if ($this->TypesEvals->save($typesEval)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("Le type d'évaluation a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le type d'évaluation n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('typesEval')); 
        $this->set('_serialize', ['typesEval']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $typesEval = $this->TypesEvals->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $typesEval = $this->TypesEvals->patchEntity($typesEval, $this->request->getData());
            if ($this->TypesEvals->save($typesEval)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("Le type d'évaluation a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le type d'évaluation n'a pas pu être sauvegardé ! Réessayer."));
            }
        }
        $this->set(compact('typesEval'));
        $this->set('_serialize', ['typesEval']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $typesEval = $this->TypesEvals->get($id, ['contain' => [] ]);
        $this->set('typesEval', $typesEval);                                  // Passe le paramètre 'typesEval' à la vue.
        $this->set('_serialize', ['typesEval']);                         // Sérialize 'typesEval'
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $typesEval = $this->TypesEvals->get($id);
        if ($this->TypesEvals->delete($typesEval)) {
            $this->Flash->success(__("Le type d'évaluation a été supprimé."));
        } else {
            $this->Flash->error(__("Le type d'évaluation n'z pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
