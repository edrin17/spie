<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 */
class ActivitesController extends AppController
{
    public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     * Liste les Activites
     */
    public function index()
    {
        $this->_loadFilters();
        $referential_id = $this->viewVars['referential_id'];
        $activites = $this->Activites->find()
            ->where(['referential_id' => $referential_id])
            ->order(['numero' => 'ASC']);
        $this->set(compact('activites','referential_id'));
        
        //build a new entity to send go params pattern to the create helper in the view
        $activite = $this->Activites->newEntity();
        $this->set(compact('activite'));
        
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
     * Ajoute un utilisateur
     */
    public function _add()
    {
        $activite = $this->Activites->newEntity();
        $activite = $this->Activites->patchEntity($activite, $this->request->getData());
        $referential_id = $this->request->getData('referential_id');                                   // crée une nouvelle entité dans $activite
        if ($this->request->is('post')) {                                           //si requête de type post
            $activite = $this->Activites->patchEntity($activite, $this->request->getData());
            if ($this->Activites->save($activite)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("L'activité a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("L'activité n\'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
    }

    /**
     * Édite un utilisateur
     */
    public function _edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $activite = $this->Activites->get($id,[
            'contain'=>[]
        ]);
        $referential_id = $activite->referential_id;
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $activite = $this->Activites->patchEntity($activite, $this->request->getData());
            if ($this->Activites->save($activite)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("L'activité a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',
                    'referential_id' => $referential_id,
                    
                ]);
            } else {
                $this->Flash->error(__("L'activité n\'a pas pu être sauvegardé ! Réessayer."));
            }
        }
    }

    /**
     * Efface un utilisateur
     */
    public function _delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //get entity form 'id' param
        $id = $this->request->getData('entityId');
        $activite = $this->Activites->get($id);
        $referential_id = $activite->referential_id;
        if ($this->Activites->delete($activite)) {
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
