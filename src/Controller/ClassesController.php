<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ClassesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

     public function index()
    {
        $classes = $this->Classes->find()->order(['nom' => 'ASC']);
        $this->set(compact('classes'));
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $classe = $this->Classes->get($id, ['contain' => [] ]);
        $this->set('classe', $classe);                                  // Passe le paramètre 'classe' à la vue.
        $this->set('_serialize', ['classe']);                         // Sérialize 'classe'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $classe = $this->Classes->newEntity();                                   // crée une nouvelle entité dans $classe
        if ($this->request->is('post')) {                                           //si requête de type post
            $classe = $this->Classes->patchEntity($classe, $this->request->getData());  //??
            if ($this->Classes->save($classe)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("La classe a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La classe n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }
        $referentials = $this->Classes->Referentials->find('list')->order(['name' => 'ASC'])->toArray();
        $this->set(compact('classe','referentials'));
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $classe = $this->Classes->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $classe = $this->Classes->patchEntity($classe, $this->request->getData());
            if ($this->Classes->save($classe)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("La classe a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La classe n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
				$referentials = $this->Classes->Referentials->find('list')->order(['name' => 'ASC'])->toArray();
        $this->set(compact('classe','referentials'));
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $classe = $this->Classes->get($id);
        if ($this->Classes->delete($classe)) {
            $this->Flash->success(__("L'classe a été supprimée."));
        } else {
            $this->Flash->error(__("L'classe n' pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
