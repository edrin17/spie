<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
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
    /**
     * Liste les NiveauxTaxos
     */
    public function index()
    {
        $niveauxTaxos = $this->NiveauxTaxos->find()
            ->order(['numero' => 'ASC']);
        //debug($niveauxTaxos->toArray());die;
        $this->set(compact('niveauxTaxos'));
        
        //build a new entity to send go params pattern to the create helper in the view
        $niveauxTaxo = $this->NiveauxTaxos->newEntity();
        $this->set(compact('niveauxTaxo'));
        
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
        $niveauxTaxo = $this->NiveauxTaxos->newEntity();
        $niveauxTaxo = $this->NiveauxTaxos->patchEntity($niveauxTaxo, $this->request->getData());                                 // crée une nouvelle entité dans $niveauxTaxo
        if ($this->request->is('post')) {                                           //si requête de type post
            $niveauxTaxo = $this->NiveauxTaxos->patchEntity($niveauxTaxo, $this->request->getData());
            if ($this->NiveauxTaxos->save($niveauxTaxo)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("Le niveau a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',      
                ]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le niveau n\'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
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
        $niveauxTaxo = $this->NiveauxTaxos->get($id,[
            'contain'=>[]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $niveauxTaxo = $this->NiveauxTaxos->patchEntity($niveauxTaxo, $this->request->getData());
            if ($this->NiveauxTaxos->save($niveauxTaxo)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("Le niveau a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect([
                    'action' => 'index',  
                ]);
            } else {
                $this->Flash->error(__("Le niveau n\'a pas pu être sauvegardé ! Réessayer."));
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
        $niveauxTaxo = $this->NiveauxTaxos->get($id);
        if ($this->NiveauxTaxos->delete($niveauxTaxo)) {
            $this->Flash->success(__('La capacité a été supprimé.'));
        } else {
            $this->Flash->error(__('La capacité n\' pas pu être supprimer ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
