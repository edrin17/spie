<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class OwnersController extends AppController
{
	public $paginate = [
        'limit' => 6,
        'order' => [
            'Owners.nom' => 'asc'
        ]
    ];

	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');

		//on charge le composant de pagination
		$this->loadComponent('Paginator');

	}

     public function index()
    {
        // Utilise le helper paginate
        $this->set('owners', $this->paginate()); //'Owners' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['owners']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $owner = $this->Owners->get($id, ['contain' => [] ]);
        $this->set('owner', $owner);                                  // Passe le paramètre 'owner' à la vue.
        $this->set('_serialize', ['owner']);                         // Sérialize 'owner'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $owner = $this->Owners->newEntity();                                   // crée une nouvelle entité dans $owner
        if ($this->request->is('post')) {                                           //si requête de type post
            $owner = $this->Owners->patchEntity($owner, $this->request->getData());  //??
            if ($this->Owners->save($owner)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("Le propriétaire a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le propriétaire n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('owner'));
        $this->set('_serialize', ['owner']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $owner = $this->Owners->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $owner = $this->Owners->patchEntity($owner, $this->request->getData());
            if ($this->Owners->save($owner)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("Le propriétaire a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le propriétaire n'a pas pu être sauvegardé ! Réessayer."));
            }
        }
        $this->set(compact('owner'));
        $this->set('_serialize', ['owner']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $owner = $this->Owners->get($id);
        if ($this->Owners->delete($owner)) {
            $this->Flash->success(__("L'owner a été supprimé."));
        } else {
            $this->Flash->error(__("L'owner n' pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
