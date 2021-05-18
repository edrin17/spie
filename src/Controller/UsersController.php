<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     Liste les Users
     */
    public function index()
    {
        $users = $this->Users->find();
        foreach ($users as $user) {
            $privilege = $user->privilege;
            switch ($privilege) {
                case 0;
                    $user->set('nom_privilege','Élève');
                break;
                
                case 1;
                    $user->set('nom_privilege','Vue');
                break;
                
                case 2;
                    $user->set('nom_privilege','Prof');
                break;
                
                case 3;
                    $user->set('nom_privilege','Admin');
                break;
            
            }   
        }
        //debug($users->toArray());die;
        $this->set('users', $users);
        //debug($this->paginate($users));die;
        $this->set('_serialize', ['Users']);
    }

    /**
     * Affiche toutes les données d'un user
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $user = $this->Users->get($id, ['contain' => [] ]);
        $this->set('user', $user);                                  // Passe le paramètre 'user' à la vue.
        $this->set('_serialize', ['user']);                         // Sérialize 'user'
    }

    /**
     * Ajoute un user
     */
    public function add()
    {
        $user = $this->Users->newEntity();                                  
        if ($this->request->is('post')) {                                           
            $user = $this->Users->patchEntity($user, $this->request->getData());
            //debug($user);die;
            if ($this->Users->save($user)) {                             
                $this->Flash->success(__("L'utilisateur a été sauvegardé.")); 
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("L'utilisateur n'a pas pu être sauvegardé ! Réessayer."));
            }
        }
        $this->set(compact('user')); 
    }

    /**
     * Édite un user
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $user = $this->Users->get($id, ['contain' => [] ]);                  //récupère le contenu qui correpond à l'id
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('L\'user a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('L\'user n\' pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Efface un user
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('L\'user a été supprimé.'));
        } else {
            $this->Flash->error(__('L\'user n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
    
    public function login()
	{
		
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
			//debug($this->Auth->identify());die();
			$user = $this->Auth->identify();
            if ($user) {
				$this->Auth->setUser($user);
				return $this->redirect($this->Auth->redirectUrl());
			}
			$this->Flash->error('Votre login ou mot de passe est incorrect.');
		}
	}
	
	public function logout()
	{
        $this->Flash->success('Vous êtes maintenant déconnecté.');
		return $this->redirect($this->Auth->logout());
	}
}
