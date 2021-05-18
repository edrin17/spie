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
		$listeClasses = $this->Periodes->Classes->find('list')
												->order(['nom' => 'ASC']);
		
		if ($this->request->is('post'))
		{
			//on stocke la valeur du formulaire pour utilisation utérieure
			$classe_id = $this->request->getData()['classe_id'];
			
			//debug($this->request->getData()['classe_id']);die;
			$periodes = $this->Periodes->find()		
							->contain(['Classes'])
							->where(['classe_id' => $classe_id])
							->order(['Classes.nom' =>'ASC'])
							->order(['Periodes.numero' => 'ASC']);							
		}else
		{
			$periodes = $this->Periodes->find()		
							->contain(['Classes'])
							->order(['Classes.nom' =>'ASC'])
							->order(['Periodes.numero' => 'ASC']);
		}
	$this->set(compact('periodes','classe_id','listeClasses'));
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
						->order(['nom' => 'ASC']);
						
		foreach ($classes as $classe) 
		{
			$listeClasses[$classe->id] = $classe->nom;
		}
        
        $periode = $this->Periodes->newEntity();                                   // crée une nouvelle entité dans $periode
        if ($this->request->is('post')) {                                           //si requête de type post
			$classe_id = $this->request->getData()['classe_id'];
            $this->set(compact('classe_id'));  
            $periode = $this->Periodes->patchEntity($periode, $this->request->getData());  //??
            if ($this->Periodes->save($periode)) {
				                               //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("La période a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index', $classe_id]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La période n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }
        
        $this->set(compact('periode','listeClasses','classe_id','colors')); 
    }
	
	/**
     * Édite un utilisateur
     */
    public function edit($id = null, $classe_id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
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
						->order(['nom' => 'ASC']);
						
		foreach ($classes as $classe) 
		{
			$listeClasses[$classe->id] = $classe->nom;
		}
        
        $periode = $this->Periodes->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $periode = $this->Periodes->patchEntity($periode, $this->request->getData());
            if ($this->Periodes->save($periode)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La période a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La période n\' a pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('periode','listeClasses','classe_id','colors'));
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
