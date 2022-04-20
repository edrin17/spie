<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * ContenusChapitres Controller
 */
class CommandesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}
    /**
     *Liste les ContenusChapitres:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les contenusChapitres terminales
     */
    public function index()
    {
        $commande = $this->Commandes->find()->first();                 //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $commande = $this->Commandes->patchEntity($commande, $this->request->getData());
            if ($this->Commandes->save($commande)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__('La commande a été sauvegardée.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('La commande n\' pas pu être sauvegarder ! Réessayer.'));
            }
        }
        $this->set(compact('commande'));
    }

    public function new()
    {
        $commande = $this->Commandes->newEntity();
        if ($this->Commandes->save($commande)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
            $this->Flash->success(__('La commande a été créée.'));      //Affiche une infobulle
            return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
        } else {
            $this->Flash->error(__('La commande n\'a pas pu être sauvegardé ! Réessayer.')); //Affiche une infobulle
        }
    }

}
