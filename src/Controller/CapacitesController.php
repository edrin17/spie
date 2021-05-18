<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Capacites Controller
 */
class CapacitesController extends AppController
{
	
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     Liste les Capacites
     */
    public function index()
    {
        $capacite = $this->Capacites->find()->order(['numero' => 'ASC']);
        $this->set('capacites', $this->paginate($capacite)); //'capacites' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['Capacites']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $capacite = $this->Capacites->get($id, ['contain' => [] ]);
        $this->set('capacite', $capacite);                                  // Passe le paramètre 'capacite' à la vue.
        $this->set('_serialize', ['capacite']);                         // Sérialize 'capacite'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $capacite = $this->Capacites->newEntity();                                   // crée une nouvelle entité dans $capacite
        if ($this->request->is('post')) {                                           //si requête de type post
            $capacite = $this->Capacites->patchEntity($capacite, $this->request->getData());  //??
            if ($this->Capacites->save($capacite)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La capacité a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La capacité n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('capacite')); 
        $this->set('_serialize', ['capacite']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $capacite = $this->Capacites->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $capacite = $this->Capacites->patchEntity($capacite, $this->request->getData());
            if ($this->Capacites->save($capacite)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La capacité a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La capacité n\' pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('capacite'));
        $this->set('_serialize', ['capacite']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $capacite = $this->Capacites->get($id);
        if ($this->Capacites->delete($capacite)) {
            $this->Flash->success(__('La capacité a été supprimé.'));
        } else {
            $this->Flash->error(__('La capacité n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }

}
