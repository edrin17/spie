<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class MarquesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {
        // Utilise le helper paginate
        $this->set('marques', $this->paginate($this->Marques)); //'marques' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['marques']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $marque = $this->Marques->get($id, ['contain' => [] ]);
        $this->set('marque', $marque);                                  // Passe le paramètre 'marque' à la vue.
        $this->set('_serialize', ['marque']);                         // Sérialize 'marque'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $marque = $this->Marques->newEntity();                                   // crée une nouvelle entité dans $marque
        if ($this->request->is('post')) {                                           //si requête de type post
            $marque = $this->Marques->patchEntity($marque, $this->request->getData());  //??
            if ($this->Marques->save($marque)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("La marque a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La marque n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('marque')); 
        $this->set('_serialize', ['marque']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $marque = $this->Marques->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $marque = $this->Marques->patchEntity($marque, $this->request->getData());
            if ($this->Marques->save($marque)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("La marque a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La marque n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
        $this->set(compact('marque'));
        $this->set('_serialize', ['marque']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $marque = $this->Marques->get($id);
        if ($this->Marques->delete($marque)) {
            $this->Flash->success(__("L'marque a été supprimée."));
        } else {
            $this->Flash->error(__("L'marque n' pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
