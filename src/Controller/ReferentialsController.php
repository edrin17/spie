<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ReferentialsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

     public function index()
    {
      $referentials = $this->Referentials->find()->order(['nom' => 'ASC']);
      $this->set(compact('referentials'));
    }

    public function add()
    {
        $referential = $this->Referentials->newEntity();
        if ($this->request->is('post')) {
            $referential = $this->Referentials->patchEntity($referential, $this->request->getData());
            if ($this->Referentials->save($referential)) {
                $this->Flash->success(__("Le référentiel a été sauvegardé."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("Le référentiel n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('referential'));
    }

    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $referential = $this->Referentials->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $referential = $this->Referentials->patchEntity($referential, $this->request->getData());
            if ($this->Referentials->save($referential)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("L'activité a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("L'activité n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
        $this->set(compact('referential'));
    }


    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $referential = $this->Referentials->get($id);
        if ($this->Referentials->delete($referential)) {
            $this->Flash->success(__("Le référentiel a été supprimé."));
        } else {
            $this->Flash->error(__("Le référentiel n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
