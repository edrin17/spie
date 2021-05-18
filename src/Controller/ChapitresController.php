<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ChapitresController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

     public function index()
    {
		$chapitres = $this->Chapitres->find()->order(['numero' => 'ASC']);
        $this->set('chapitres', $this->paginate($chapitres)); //'chapitres' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['chapitres']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $chapitre = $this->Chapitres->get($id, ['contain' => [] ]);
        $this->set('chapitre', $chapitre);                                  // Passe le paramètre 'chapitre' à la vue.
        $this->set('_serialize', ['chapitre']);                         // Sérialize 'chapitre'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $chapitre = $this->Chapitres->newEntity();                                   // crée une nouvelle entité dans $chapitre
        if ($this->request->is('post')) {                                           //si requête de type post
            $chapitre = $this->Chapitres->patchEntity($chapitre, $this->request->getData());  //??
            if ($this->Chapitres->save($chapitre)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le chapitre n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('chapitre'));
        $this->set('_serialize', ['chapitre']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $chapitre = $this->Chapitres->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $chapitre = $this->Chapitres->patchEntity($chapitre, $this->request->getData());
            if ($this->Chapitres->save($chapitre)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le chapitre a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le chapitre n\' pas pu être sauvegardé ! Réessayer.'));
            }
        }
        $this->set(compact('chapitre'));
        $this->set('_serialize', ['chapitre']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $chapitre = $this->Chapitres->get($id);
        if ($this->Chapitres->delete($chapitre)) {
            $this->Flash->success(__('Le chapitre a été supprimé.'));
        } else {
            $this->Flash->error(__('Le chapitre n\' pas pu être supprimé ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
