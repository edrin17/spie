<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Rotations Controller
 */
class RotationsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index($periode_id = null)
    {
		$listClasses = $this->Rotations->Periodes->find('list')
			->order(['nom' => 'ASC']);

		//on récupère les liste de periodes correpondantes en la classe
		$listPeriodes = $this->Rotations->Periodes->find()
            ->order(['Periodes.numero' => 'ASC']);
		//mise en forme du select
		foreach ($listPeriodes as $listPeriode)
		{
			$selectPeriodes[$listPeriode->id] = "Période n°" .$listPeriode->numero;
		}

		//on recupere de toutes les rotations
		$rotations = $this->Rotations->find('all')
            ->contain([
                'Periodes',
                'Themes',
            ])
            ->order(['Periodes.numero' =>'ASC',
                    'Rotations.numero' =>'ASC'
            ]);

        //debug($rotations->toArray());die;
        $this->set(compact('rotations','selectPeriodes','periode_id'));

    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        //on recupere la liste des thèmes
        $listThemes = $this->Rotations->Themes->find('list')
            ->order(['nom' => 'ASC']);
		//on cherche la liste des periodes qui correpondent à l'id de la classe
		$listPeriodes = $this->Rotations->Periodes->find()
            ->order(['Periodes.numero' => 'ASC']);

		//on met en forme le resultat
		foreach ($listPeriodes as $listPeriode)
		{
			$selectPeriodes[$listPeriode->id] = "Période n°" .$listPeriode->numero;
		}




        $rotation = $this->Rotations->newEntity();                                   // crée une nouvelle entité dans $rotation
        if ($this->request->is('post')) {
			$periode_id = $this->request->getData()['periode_id'];                                           //si requête de type post
            $rotation = $this->Rotations->patchEntity($rotation, $this->request->getData());  //??
            if ($this->Rotations->save($rotation)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La rotation a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $periode_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La rotation n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }

        $this->set(compact(
            'rotation',
            'selectPeriodes',
            'listThemes',
        ));
    }


       public function edit($id = null)
    {
        //on recupere les donnees de l'entity
        $rotation = $this->Rotations->get($id, [
            'contain' => [
                'Periodes',
                'Themes',
            ]
        ]);

        //on recupere la liste des thèmes
        $listThemes = $this->Rotations->Themes->find('list')
            ->order(['nom' => 'ASC']);

        //on liste les classe pour le select de la vue
		$listClasses = $this->Rotations->Periodes->Classes->find('list')
            ->order(['nom' => 'ASC']);

        //on liste les periodes correpondante à l'entity
		$listPeriodes = $this->Rotations->Periodes->find()
            ->where(['classe_id' => $rotation->periode->classe_id])
            ->order(['Periodes.numero' => 'ASC']);

		//mise en forme du select
		foreach ($listPeriodes as $listPeriode)
		{
			$selectPeriodes[$listPeriode->id] = "Période n°" .$listPeriode->numero;
		}

        if ($this->request->is(['patch','post','put'])) {                                           //si requête de type post
            $periode_id = $this->request->getData()['periode_id'];
            $rotation = $this->Rotations->patchEntity($rotation, $this->request->getData());  //??
            if ($this->Rotations->save($rotation)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La rotation a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $periode_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La rotation n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }

        $themes = $this->Rotations->Themes->find('list');
        $this->set(compact('rotation','selectPeriodes','listThemes'));
    }
    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)
    {
        //on recupere les donnees de l'entity
        $rotation = $this->Rotations->get($id, [
            'contain' => [
                'Periodes',
                'Themes',
            ]
        ]);
		$this->set(compact('rotation'));
    }


    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $rotation = $this->Rotations->get($id);
        if ($this->Rotations->delete($rotation)) {
            $this->Flash->success(__('La rotation a été supprimée.'));
        } else {
            $this->Flash->error(__('La rotation n\'a pas pu être supprimé ! Réessayer.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
