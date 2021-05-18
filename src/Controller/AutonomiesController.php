<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class AutonomiesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {
        $autonomies = $this->Autonomies->find()->order(['numero' => 'ASC']);
        $this->set('autonomies', $this->paginate($autonomies)); //'Autonomies' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['autonomies']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $autonomie = $this->Autonomies->get($id, ['contain' => [] ]);
        $this->set('autonomie', $autonomie);                                  // Passe le paramètre 'Autonomie' à la vue.
        $this->set('_serialize', ['autonomie']);                         // Sérialize 'Autonomie'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $autonomie = $this->Autonomies->newEntity();                                   // crée une nouvelle entité dans $Autonomie
        if ($this->request->is('post')) {                                           //si requête de type post
            $autonomie = $this->Autonomies->patchEntity($autonomie, $this->request->getData());  //??
            if ($this->Autonomies->save($autonomie)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le niveaux d\'autonomie a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveaux d\'autonomie n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('autonomie')); 
        $this->set('_serialize', ['autonomie']);
    }

    /**
     * Édite un niveau d'autonomie
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $autonomie = $this->Autonomies->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $autonomie = $this->Autonomies->patchEntity($autonomie, $this->request->getData());
            if ($this->Autonomies->save($autonomie)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le niveaux d\'autonomie a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveaux d\'autonomie n\' pas pu être sauvegardé ! Réessayer.'));
            }
        }
        $this->set(compact('autonomie'));
        $this->set('_serialize', ['autonomie']);
    }

    /**
     * Efface un niveau d'autonomie
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $autonomie = $this->Autonomies->get($id);
        if ($this->Autonomies->delete($autonomie)) {
            $this->Flash->success(__('Le niveaux d\'autonomie a été supprimé.'));
        } else {
            $this->Flash->error(__('Le niveaux d\'autonomie n\' pas pu être supprimé ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
