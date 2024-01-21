<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
     * Liste les Capacites
     */
    public function index()
    {
        $this->_loadFilters();
        $referential_id = $this->viewVars['referential_id'];
        $capacites = $this->Capacites->find()
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        $this->set(compact('capacites','referential_id'));
        
        //build a new entity to send go params pattern to the create helper in the view
        $capacite = $this->Capacites->newEntity();
        $this->set(compact('capacite'));
        
        //choose action if POST
        $requestType = $this->request->is(['patch', 'post', 'put', 'delete']);
        $action = $this->request->getData('action');
        if ($requestType) {
           if ($action === 'add') {
            $this->_add($this->request);
           }
           if ($action === 'edit') {
            $this->_edit($this->request);
           }
           if ($action === 'delete') {
            $this->_delete($this->request);
           }
        }
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $capacite = $this->Capacites->get($id, ['contain' => [] ]);
        $this->set('capacite', $capacite);                                  // Passe le paramètre 'capacite' à la vue.                        // Sérialize 'capacite'
    }

    /**
     * Ajoute un utilisateur
     */
    public function _add()
    {
        $capacite = $this->Capacites->newEntity();
        $capacite = $this->Capacites->patchEntity($capacite, $this->request->getData());
        $referential_id = $this->request->getData('referential_id');                                   // crée une nouvelle entité dans $capacite
        if ($this->request->is('post')) {                                           //si requête de type post
            $capacite = $this->Capacites->patchEntity($capacite, $this->request->getData());
            $referential_id = $this->request->getData('referential_id');
            if ($this->Capacites->save($capacite)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La capacité a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La capacité n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
            }
        }
        $this->set(compact('capacite'));
    }

    /**
     * Édite un utilisateur
     */
    public function _edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $capacite = $this->Capacites->get($id,[
            'contain'=>[]
        ]);
        $referential_id = $capacite->referential_id;
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $capacite = $this->Capacites->patchEntity($capacite, $this->request->getData());
            if ($this->Capacites->save($capacite)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La capacité a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    
                ]);
            } else {
                $this->Flash->error(__('La capacité n\' pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('capacite'));
    }

    /**
     * Efface un utilisateur
     */
    public function _delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $capacite = $this->Capacites->get($id);
        $referential_id = $capacite->referential_id;
        if ($this->Capacites->delete($capacite)) {
            $this->Flash->success(__('La capacité a été supprimé.'));
        } else {
            $this->Flash->error(__('La capacité n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index','referential_id' => $referential_id]);
    }
 

    private function _loadFilters($resquest = null)
    {
        //chargement de la liste des référentiels
        $referentialsTbl = TableRegistry::get('Referentials');
        $referentials = $referentialsTbl->find('list')
            ->order(['name' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $referential_id = $this->request->getQuery('referential_id');

        //si requête vide slection du premier de la liste
        if ($referential_id =='') {
            $referential_id = $referentialsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'referentials', 'referential_id'
        ));
    }
}
