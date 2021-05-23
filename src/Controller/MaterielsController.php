<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Materiels Controller
 */
class MaterielsController extends AppController
{
	public $paginate = [
        'limit' => 10
    ];

	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index()
    {
			$materiels = $this->Materiels->find()
				->contain(['Marques','Owners','TypesMachines'])
				->order(['Materiels.nom' => 'ASC']);

			$this->set('materiels', $materiels); //'activites' est l'alias de la variable globale pour la vue'index.ctp'
    }
	/***************** Ajoute une tâche principale
     **********************************************************/
    public function add()
    {
        $materiel = $this->Materiels->newEntity();
        ;
        if ($this->request->is('post')) {
            $materiel = $this->Materiels->patchEntity($materiel, $this->request->getData());
            if ($this->Materiels->save($materiel)) {
                $this->Flash->success(__('Le matériel a été sauvegardé.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le matériel n\'a pas pu être sauvegardé ! Réessayer.'));
            }
        }
        $marques = $this->Materiels->Marques->find('list')->order(['nom' => 'ASC'])->toArray();
        $typesMachines = $this->Materiels->TypesMachines->find('list')->order(['nom' => 'ASC'])->toArray();
				$owners = $this->Materiels->Owners->find('list')->order(['nom' => 'ASC'])->toArray();
        $this->set(compact('materiel','marques','typesMachines','owners'));
        $this->set('_serialize', ['materiel']);
    }


    /**
     * Édite un utilisateur
     */
    public function edit($id = null)   //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {

        //récupère le contenu de la table materiels_terminales en fonction de l'id'
        $materiel = $this->Materiels->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {                        // Vérifie le type de requête
            $materiel = $this->Materiels->patchEntity($materiel, $this->request->getData());
            //debug($materiel);die;
            if ($this->Materiels->save($materiel)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le matériel a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le matériel n\'a pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }

        // Récupère les données de la table Materiels et les classe par ASC
        $marques = $this->Materiels->Marques->find('list')->order(['nom' => 'ASC'])->toArray();
        $typesMachines = $this->Materiels->TypesMachines->find('list')->order(['nom' => 'ASC'])->toArray();
				$owners = $this->Materiels->Owners->find('list')->order(['nom' => 'ASC'])->toArray();
        $this->set(compact('materiel','marques','typesMachines','owners'));
        $this->set('_serialize', ['materiel']);
    }

    /************* Affiche toutes les données d'un utilisateur************************
     ********************************************************************************/
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $materiel = $this->Materiels->get($id, [
            'contain' => ['Marques','TypesMachines','Owners']
        ]);

        $this->set(compact('materiel'));
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $materiel = $this->Materiels->get($id);
        if ($this->Materiels->delete($materiel)) {
            $this->Flash->success(__("Le matériel a été supprimé."));
        } else {
            $this->Flash->error(__("Le matériel n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

}
