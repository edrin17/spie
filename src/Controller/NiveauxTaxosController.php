<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class NiveauxTaxosController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {
        $niveauxTaxos = $this->NiveauxTaxos->find()->order(['numero' => 'ASC']);
        $this->set('niveauxTaxos', $this->paginate($niveauxTaxos)); //'niveauxTaxos' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['niveauxTaxos']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $niveauxTaxo = $this->NiveauxTaxos->get($id, ['contain' => [] ]);
        $this->set('niveauxTaxo', $niveauxTaxo);                                  // Passe le paramètre 'niveauxTaxo' à la vue.
        $this->set('_serialize', ['niveauxTaxo']);                         // Sérialize 'niveauxTaxo'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $niveauxTaxo = $this->NiveauxTaxos->newEntity();                                   // crée une nouvelle entité dans $niveauxTaxo
        if ($this->request->is('post')) {                                           //si requête de type post
            $niveauxTaxo = $this->NiveauxTaxos->patchEntity($niveauxTaxo, $this->request->getData());  //??
            if ($this->NiveauxTaxos->save($niveauxTaxo)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('Le niveaux taxonomique a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveaux taxonomique n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('niveauxTaxo')); 
        $this->set('_serialize', ['niveauxTaxo']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $niveauxTaxo = $this->NiveauxTaxos->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $niveauxTaxo = $this->NiveauxTaxos->patchEntity($niveauxTaxo, $this->request->getData());
            if ($this->NiveauxTaxos->save($niveauxTaxo)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le niveaux taxonomique a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveaux taxonomique n\' pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('niveauxTaxo'));
        $this->set('_serialize', ['niveauxTaxo']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $niveauxTaxo = $this->NiveauxTaxos->get($id);
        if ($this->NiveauxTaxos->delete($niveauxTaxo)) {
            $this->Flash->success(__('Le niveaux taxonomique a été supprimé.'));
        } else {
            $this->Flash->error(__('Le niveaux taxonomique n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
