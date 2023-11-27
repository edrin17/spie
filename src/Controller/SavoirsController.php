<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Savoirs Controller
 */
class SavoirsController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
    }

    public function index()
    {
        $this->_loadFilters();
        $referential_id = $this->viewVars['referential_id'];

        $savoirs = $this->Savoirs->find()
            ->contain(['Referentials'])
            ->where(['referential_id' => $referential_id])
            ->order(['num' => 'ASC','Savoirs.nom' => 'ASC']);
        $this->set(compact('savoirs'));
    }
    public function add()
    {
        $this->_loadFilters();
        $savoir = $this->Savoirs->newEntity();
        if ($this->request->is('post')) {
            $savoir = $this->Savoirs->patchEntity($savoir, $this->request->getData());
            if ($this->Savoirs->save($savoir)) {
                $this->Flash->success(__("Le savoir a été sauvegardé."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("Le savoir n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('savoir'));
    }

    public function edit($id = null)
    {
        $this->_loadFilters();
        $savoir = $this->Savoirs->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $savoir = $this->Savoirs->patchEntity($savoir, $data);
            //debug($savoir);die;
            if ($this->Savoirs->save($savoir)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le savoir a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le savoir n\'a pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }

        $this->set(compact('savoir'));
    }

    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $savoir = $this->Savoirs->get($id);
        if ($this->Savoirs->delete($savoir)) {
            $this->Flash->success(__("Le savoir a été supprimé."));
        } else {
            $this->Flash->error(__("Le savoir n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
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
