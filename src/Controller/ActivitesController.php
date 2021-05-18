<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ActivitesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

     public function index()
    {
      $activites = $this->Activites->find()->order(['numero' => 'ASC']);
      $this->set('activites', $this->paginate($activites)); //'activites' est l'alias de la variable globale pour la vue'index.ctp'
      $this->set('_serialize', ['activites']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
      $activite = $this->Activites->get($id, ['contain' => [] ]);
      $this->set('activite', $activite);                                  // Passe le paramètre 'activite' à la vue.
      $this->set('_serialize', ['activite']);                         // Sérialize 'activite'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $activite = $this->Activites->newEntity();                                   // crée une nouvelle entité dans $activite
        if ($this->request->is('post')) {                                           //si requête de type post
            $activite = $this->Activites->patchEntity($activite, $this->request->getData());  //??
            if ($this->Activites->save($activite)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("L'activité a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("L'activité n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('activite'));
        $this->set('_serialize', ['activite']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $activite = $this->Activites->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $activite = $this->Activites->patchEntity($activite, $this->request->getData());
            if ($this->Activites->save($activite)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("L'activité a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("L'activité n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
        $this->set(compact('activite'));
        $this->set('_serialize', ['activite']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $activite = $this->Activites->get($id);
        if ($this->Activites->delete($activite)) {
            $this->Flash->success(__("L'activite a été supprimée."));
        } else {
            $this->Flash->error(__("L'activite n' pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
