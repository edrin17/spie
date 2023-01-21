<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class TaxosController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
	public function index()
	{
		$taxos = $this->Taxos->find()->order(['num' => 'ASC']);
		$this->set(compact('taxos'));
	}
	public function add()
    {
        $taxo = $this->Taxos->newEntity();
        if ($this->request->is('post')) {
            $taxo = $this->Taxos->patchEntity($taxo, $this->request->getData());
            //debug($taxo);die;
            if ($this->Taxos->save($taxo)) {
                $this->Flash->success(__('Le niveau taxonomique a été sauvegardé.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le niveau taxonomique n\'a pas pu être sauvegardé ! Réessayer.'));
            }
        }

        $this->set(compact('taxo'));
    }

    public function edit($id = null)
    {
        $taxo = $this->Taxos->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $taxo = $this->Taxos->patchEntity($taxo, $data);
            //debug($taxo);die;
            if ($this->Taxos->save($taxo)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le niveau taxonomique a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le niveau taxonomique n\'a pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }

        $this->set(compact('taxo'));
    }

	public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $taxo = $this->Taxos->get($id);
        if ($this->Taxos->delete($taxo)) {
            $this->Flash->success(__("Le niveau taxonomique a été supprimé."));
        } else {
            $this->Flash->error(__("Le niveau taxonomique n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
