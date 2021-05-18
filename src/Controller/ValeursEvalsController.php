<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ValeursEvalsController extends AppController
{
	private $colors = [
		'#FF0000' => 'Rouge',
		'#1EA6FF' => 'Bleu',
		'#FFA71E' => 'Orange',
		'#E1DD0E' => 'Jaune',
		'#32D36A' => 'Vert',
	];
	
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {
        // Utilise le helper paginate
        $this->set('valeursEvals', $this->paginate($this->ValeursEvals)); //'valeursEvals' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['valeursEvals']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $valeursEval = $this->ValeursEvals->get($id, ['contain' => [] ]);
        $this->set('valeursEval', $valeursEval);                                  // Passe le paramètre 'valeursEval' à la vue.
        $this->set('_serialize', ['valeursEval']);                         // Sérialize 'valeursEval'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $valeursEval = $this->ValeursEvals->newEntity();                                   // crée une nouvelle entité dans $valeursEval
        if ($this->request->is('post')) {                                           //si requête de type post
            $valeursEval = $this->ValeursEvals->patchEntity($valeursEval, $this->request->getData());  //??
            if ($this->ValeursEvals->save($valeursEval)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("La valeur d'évaluation a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La valeur d'évaluation n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('valeursEval'));
        $this->set('colors', $this->colors);
        $this->set('_serialize', ['valeursEval']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $valeursEval = $this->ValeursEvals->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $valeursEval = $this->ValeursEvals->patchEntity($valeursEval, $this->request->getData());
            if ($this->ValeursEvals->save($valeursEval)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("La valeur d'évaluation a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La valeur d'évaluation n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
        $this->set(compact('valeursEval'));
        $this->set('colors', $this->colors);
        $this->set('_serialize', ['valeursEval']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $valeursEval = $this->ValeursEvals->get($id);
        if ($this->ValeursEvals->delete($valeursEval)) {
            $this->Flash->success(__("L'valeursEval a été supprimée."));
        } else {
            $this->Flash->error(__("L'valeursEval n' pas pu être supprimée ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
