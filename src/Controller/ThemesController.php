<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 */
class ThemesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
	
     public function index()
    {
        // Utilise le helper paginate
        $this->set('themes', $this->paginate($this->Themes)); //'theme' est l'alias de la variable globale pour la vue'index.ctp'
        $this->set('_serialize', ['themes']);
    }

    /**
     * Affiche toutes les données d'un utilisateur
     */
    public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $theme = $this->Themes->get($id, ['contain' => [] ]);
        $this->set('theme', $theme);                                  // Passe le paramètre 'theme' à la vue.
        $this->set('_serialize', ['theme']);                         // Sérialize 'theme'
    }

    /**
     * Ajoute un utilisateur
     */
    public function add()
    {
        $colors = [
			'1E90FF' => 'Bleu',
			'FB615C' => 'Rouge' ,
			'FBC05C' => 'Orange',
			'58B961' => 'Vert',
			'BFBFBF' => 'Gris',
			'BCA4EC' => 'Violet',
        ];
        
        $theme = $this->Themes->newEntity();                                   // crée une nouvelle entité dans $theme
        if ($this->request->is('post')) {                                           //si requête de type post
            $theme = $this->Themes->patchEntity($theme, $this->request->getData());  //??
            if ($this->Themes->save($theme)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
                $this->Flash->success(__("Le type de theme a été sauvegardé."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("Le type de theme n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('theme','colors')); 
        $this->set('_serialize', ['theme']);
    }

    /**
     * Édite un utilisateur
     */
    public function edit($id = null)
    {
        $colors = [
			'1E90FF' => 'Bleu',
			'FB615C' => 'Rouge' ,
			'FBC05C' => 'Orange',
			'58B961' => 'Vert',
			'BFBFBF' => 'Gris',
			'BCA4EC' => 'Violet',
        ];
        
        $theme = $this->Themes->get($id, ['contain' => [] ]);                  
        if ($this->request->is(['patch', 'post', 'put'])) {                      
            $theme = $this->Themes->patchEntity($theme, $this->request->getData());
            if ($this->Themes->save($theme)) {                                
                $this->Flash->success(__("Le type de theme a été sauvegardée."));  
                return $this->redirect(['action' => 'index']); 
            } else {
                $this->Flash->error(__("Le type de theme n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
        $this->set(compact('theme', 'colors'));
        $this->set('_serialize', ['theme']);
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $theme = $this->Themes->get($id);
        if ($this->Themes->delete($theme)) {
            $this->Flash->success(__("Le type de theme a été supprimé."));
        } else {
            $this->Flash->error(__("Le type de theme n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
