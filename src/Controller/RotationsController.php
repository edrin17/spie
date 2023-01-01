<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

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
        //si periode_id en parmètre c'est un retour d'ajout ou d'edition
        //donc on prend progression_id qui match
        if ($periode_id) {
            $progression_id = $this->Rotations->Periodes->get($periode_id)
                ->progression_id;
        }else{
            $progression_id = $this->request->getQuery('progression_id');
            $periode_id = $this->request->getQuery('periode_id');
        }

        $progressionsTable = TableRegistry::get('Progressions');
		$progressions = $progressionsTable->find('list')
			->order(['id' => 'ASC']);
        if (is_null($progression_id)) { //si aucun referentiel choisi l'id du 1er
            $progression_id = $progressionsTable->find()
                ->first()
                ->id;

            //on récupère la 1ere periode correpondantes au référentiel
    		$periode_id = $this->Rotations->Periodes->find()
                ->where(['progression_id' => $progression_id])
                ->order(['Periodes.numero' => 'ASC'])
                ->first()
                ->id;
        }else{
            $periode = $this->Rotations->Periodes->get($periode_id); //on regarde si periode_id match le référentiel

            if ($periode->progression_id != $progression_id) {
                $periode_id = $this->Rotations->Periodes->find()
                    ->where(['progression_id' => $progression_id])
                    ->order(['Periodes.numero' => 'ASC'])
                    ->first()
                    ->id;
            }
        }

        $periodes = $this->Rotations->Periodes->find('list')
            ->where(['progression_id' => $progression_id])
            ->order(['Periodes.numero' => 'ASC']);

		//on recupere de toutes les rotations
		$rotations = $this->Rotations->find()
            ->contain(['Periodes','Themes'])
            ->where([
                'Periodes.progression_id' => $progression_id,
                'periode_id' => $periode_id,
                ])

            ->order(['Periodes.numero' =>'ASC',
                    'Rotations.numero' =>'ASC'
            ]);

        //debug($periodes);
        $this->set(compact('rotations','periodes','periode_id','progressions','progression_id'));

    }

    /**
     * Ajoute un utilisateur
     */
    public function add($periode_id = null)
    {
        //on recupere la liste des référentiels
        $progressionsTable = TableRegistry::get('Progressions');
		$progressions = $progressionsTable->find('list')
			->order(['id' => 'ASC']);

        //prend le progression_id correspondant à la période passée en paramètres
        if ($periode_id) {
            $progression_id = $this->Rotations->Periodes->get($periode_id)
                ->progression_id;
        }else{
        //sino prend le 1ere progression_id de la table
        $progression_id = $progressionsTable->find()
            ->first()
            ->id;
        }
        //on recupere la liste des thèmes
        $listThemes = $this->Rotations->Themes->find('list')
            ->order(['nom' => 'ASC']);

		//on cherche la liste des periodes qui correpondent à progression_id
		$periodes = $this->Rotations->Periodes->find('list')
            ->where(['progression_id' => $progression_id])
            ->order(['Periodes.numero' => 'ASC']);





        $rotation = $this->Rotations->newEntity();                                   // crée une nouvelle entité dans $rotation
        if ($this->request->is('post')) {
			$periode_id = $this->request->getData('periode_id');                                           //si requête de type post
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
            'periodes',
            'listThemes',
            'progressions',
            'progression_id'
        ));
    }


       public function edit($rotation_id = null)
    {
        $rotation = $this->Rotations->get($rotation_id);
        $periode_id = $rotation->periode_id;
        //on recupere la liste des référentiels
        $progressionsTable = TableRegistry::get('Progressions');
		$progressions = $progressionsTable->find('list')
			->order(['id' => 'ASC']);

        //prend le progression_id correspondant à la période passée en paramètres
        $progression_id = $this->Rotations->Periodes->get($periode_id)
            ->progression_id;
        //on recupere la liste des thèmes
        $listThemes = $this->Rotations->Themes->find('list')
            ->order(['nom' => 'ASC']);

		//on cherche la liste des periodes qui correpondent à progression_id
		$periodes = $this->Rotations->Periodes->find('list')
            ->where(['progression_id' => $progression_id])
            ->order(['Periodes.numero' => 'ASC']);


        if ($this->request->is(['patch','post','put'])) {                                           //si requête de type post
            $periode_id = $this->request->getData('periode_id');
            $rotation = $this->Rotations->patchEntity($rotation, $this->request->getData());  //??
            if ($this->Rotations->save($rotation)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__('La rotation a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $periode_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La rotation n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }

        $themes = $this->Rotations->Themes->find('list');
        $this->set(compact(
            'rotation',
            'periodes',
            'listThemes',
            'progressions',
            'progression_id'
        ));
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
