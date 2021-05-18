<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class TypesMachinesController extends AppController
{
	public $paginate = [
        'limit' => 6,
        'order' => [
            'TypesMachines.nom' => 'asc'
        ]
    ];
	
	
	public function initialize()
	{
		parent::initialize();
		//on choisit le layout
		$this->viewBuilder()->setLayout('default');
		
		//on charge le composant de pagination
		$this->loadComponent('Paginator');
	}
     public function index()
    {
        // Utilise le helper paginate
        //$settings = ['limit' => 2, 'maxlimit' => 5];
        $this->set('typesMachines', $this->paginate());
        $this->set('_serialize', ['typesMachines']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $typesMachine = $this->TypesMachines->get($id, ['contain' => [] ]);
        $this->set('typesMachine', $typesMachine);                                  // Passe le paramètre 'typesMachine' à la vue.
        $this->set('_serialize', ['typesMachine']);                         // Sérialize 'typesMachine'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $typesMachine = $this->TypesMachines->newEntity();                                   // crée une nouvelle entité dans $typesMachine
        if ($this->request->is('post')) {                                           //si requête de type post
            $typesMachine = $this->TypesMachines->patchEntity($typesMachine, $this->request->getData());  //??
            if ($this->TypesMachines->save($typesMachine)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("Le type machine a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le type machine n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('typesMachine')); 
        $this->set('_serialize', ['typesMachine']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $typesMachine = $this->TypesMachines->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $typesMachine = $this->TypesMachines->patchEntity($typesMachine, $this->request->getData());
            if ($this->TypesMachines->save($typesMachine)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("Le type machine a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le type machine n'a pas pu être sauvegardé ! Réessayer."));
            }
        }
        $this->set(compact('typesMachine'));
        $this->set('_serialize', ['typesMachine']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $typesMachine = $this->TypesMachines->get($id);
        if ($this->TypesMachines->delete($typesMachine)) {
            $this->Flash->success(__("Le Le type machine a été supprimé."));
        } else {
            $this->Flash->error(__("Le type machine n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
