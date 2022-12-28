<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * Users Controller
 */
class PeriodesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

    public function index($classe_id = null)
    {

		if ($this->request->is('post'))
		{
			$periodes = $this->Periodes->find()
				->contain(['Classes','Referentials'])
				->order(['Periodes.numero' => 'ASC']);
		}else
		{
			$periodes = $this->Periodes->find()
                ->contain(['Classes','Referentials'])
				->order(['Periodes.numero' => 'ASC']);
		}
    //debug($periodes->toArray());
	$this->set(compact('periodes'));
    }

	/**
     * Ajoute un utilisateur
     */
    public function add($classe_id = null)
    {
        $colors = [
			'1E90FF' => 'Bleu',
			'FB615C' => 'Rouge' ,
			'FFC49C' => 'Orange',
			'58B961' => 'Vert',
			'BFBFBF' => 'Gris',
			'BCA4EC' => 'Violet',
        ];

        $tableClasse = TableRegistry::get('Classes');

        $classes = $tableClasse->find()
						->select(['id', 'nom'])
                        ->where(['archived' => false])
						->order(['nom' => 'ASC']);

		foreach ($classes as $classe)
		{
			$listeClasses[$classe->id] = $classe->nom;
		}
        $referentialTbl = TableRegistry::get('Referentials');

        $referentials = $referentialTbl->find('list')
						->order(['nom' => 'ASC']);

        $periode = $this->Periodes->newEntity();                                   // crée une nouvelle entité dans $periode
        if ($this->request->is('post')) {                                           //si requête de type post
            $periode = $this->Periodes->patchEntity($periode, $this->request->getData());  //??
            if ($this->Periodes->save($periode)) {
				                               //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("La période a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $classe_id, $referential_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La période n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }

        $this->set(compact('periode',
            'listeClasses','colors',
            'referentials'
        ));
    }

	/**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $colors = [
			'1E90FF' => 'Bleu',
			'FB615C' => 'Rouge' ,
			'FFC49C' => 'Orange',
			'58B961' => 'Vert',
			'BFBFBF' => 'Gris',
			'BCA4EC' => 'Violet',
        ];

        $tableClasse = TableRegistry::get('Classes');

        $classes = $tableClasse->find()
						->select(['id', 'nom'])
                        ->where(['archived' => false])
						->order(['nom' => 'ASC']);

        $referentialTbl = TableRegistry::get('Referentials');

        $referentials = $referentialTbl->find('list')
						->order(['nom' => 'ASC']);

		foreach ($classes as $classe)
		{
			$listeClasses[$classe->id] = $classe->nom;
		}
        $periode = $this->Periodes->get($id);                  //recupère l'entité corespondante à l'id
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $periode = $this->Periodes->patchEntity($periode, $this->request->getData());
            if ($this->Periodes->save($periode)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La période a été modifée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La période n\' a pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('periode',
            'listeClasses','colors',
            'referentials'
        ));
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        //$periode = $this->Periodes->get($id, ['contain' => [] ]);
        $periode = $this->Periodes->find()
						->contain(['Classes'])
						->select(['id','numero', 'Classes.nom'])
						->where(['Periodes.id' => $id])
						->first();

        $this->set('periode', $periode);                                  // Passe le paramètre 'periode' à la vue.
        $this->set('_serialize', ['periode']);                         // Sérialize 'periode'
    }


    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $periode = $this->Periodes->get($id);
        if ($this->Periodes->delete($periode)) {
            $this->Flash->success(__("La période a été supprimée."));
        } else {
            $this->Flash->error(__("La période n' pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
