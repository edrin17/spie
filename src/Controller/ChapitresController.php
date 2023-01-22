<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 */
class ChapitresController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

     public function index()
    {
		$this->_loadFilters();
        $savoir_id = $this->viewVars['savoir_id'];
        $chapitres = $this->Chapitres->find()
            ->where(['parent_id' => $savoir_id])
            ->order(['Chapitres.num' => 'ASC']);
        $this->set(compact('chapitres'));
    }

    public function add($savoir_id = null)
    {
		$this->_loadFilters();
        $chapitre = $this->Chapitres->newEntity();
        if ($this->request->is('post')) {
            $chapitre = $this->Chapitres->patchEntity($chapitre, $this->request->getData());
            if ($this->Chapitres->save($chapitre)) {
                $this->Flash->success(__("Le chapitre a été sauvegardé."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("Le chapitre n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('chapitre'));
    }
    
    private function _loadParents($id = null)
    {
        # code...
    }
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->_loadFilters();
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $chapitre = $this->Chapitres->get($id);
        if ($this->Chapitres->delete($chapitre)) {
            $this->Flash->success(__("Le chapitre a été supprimé."));
        } else {
            $this->Flash->error(__("Le chapitre n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
    private function _loadFilters($resquest = null)
    {
        //chargement de la liste des référentiels
        $savoirsTbl = TableRegistry::get('Savoirs');
        $savoirs = $savoirsTbl->find('list')
            ->order(['num' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $savoir_id = $this->request->getQuery('savoir_id');

        //si requête vide selection du premier de la liste
        if ($savoir_id =='') {
            $savoir_id = $savoirsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }
        //chargement de la liste des référentiels
        $taxosTbl = TableRegistry::get('Taxos');
        $taxos = $taxosTbl->find('list')
            ->order(['num' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $taxo_id = $this->request->getQuery('taxo_id');

        //si requête vide selection du premier de la liste
        if ($taxo_id =='') {
            $taxo_id = $taxosTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'savoirs', 'savoir_id', 'taxos', 'taxo_id'
        ));
    }
   
}
