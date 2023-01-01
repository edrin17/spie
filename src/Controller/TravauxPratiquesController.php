<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * TravauxPratiques Controller
 */
class TravauxPratiquesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('default');
    }
    /**
     *Liste les TravauxPratiques:
     *récupère les capacités & les classe ASC
     *puis les passes en paramètre à l'instance
     * Pagine les travauxPratiques terminales
     */
    public function index()
    {
 
        $this->_loadFilters();
        $spe = 0;
        //debug($this->viewVars->rotation_id);die;
        //on récupère les bonnes données pour affichage
        $tableTPs = $this->TravauxPratiques;
        $tps = $tableTPs->find()
            ->contain([
                'Rotations.Periodes',
                'Rotations.Themes',
                'MaterielsTravauxPratiques.Materiels.Marques',
            ])
            ->where(['rotation_id' => $this->viewVars['rotation_id']])
            ->where(['specifique' => $spe]);
        $this->set(compact('tps','spe'));
    }

    private function _loadFilters($resquest = null)
    {
        $progressionsTbl = TableRegistry::get('Progressions');
        $progressions = $progressionsTbl->find('list')
            ->order(['id' => 'ASC']);
        
        $progression_id = $this->request->getQuery('progression_id');

        if ($progression_id =='') {
            $progression_id = $progressionsTbl->find()
            ->order(['id' => 'ASC'])
            ->first()
            ->id;
        }

        $classesTbl = TableRegistry::get('Classes');
        $classes = $classesTbl->find('list')
            ->where([
                'archived' => 0,
                'progression_id' => $progression_id
            ])
            ->order(['nom' => 'ASC']);
        $classe_id = $this->request->getQuery('classe_id');
        if ($classe_id =='') {
        $classe_id = $classesTbl->find()
            ->where([
                'archived' => 0,
                'progression_id' => $progression_id
            ])
            ->first()
            ->id;
        }
 
        $periodesTbl = TableRegistry::get('Periodes');
        $periodes = $periodesTbl->find('list')
            ->where(['progression_id' => $progression_id])
            ->order(['numero' => 'ASC']);
        $periode_id = $this->request->getQuery('periode_id');
        if ($periode_id =='') {
        $periode_id = $periodesTbl->find()
            ->where(['progression_id' => $progression_id])
            ->order(['numero' => 'ASC'])
            ->first()->id;
        }

        $rotationsTbl = TableRegistry::get('Rotations');
        $rotations = $rotationsTbl->find('list')
            ->contain(['Periodes'])
            ->where(['periode_id' => $periode_id])
            ->order(['Rotations.numero' => 'ASC']);
        $rotation_id = $this->request->getQuery('rotation_id');
        if ($rotation_id =='') {
        $rotation_id = $rotationsTbl->find()
            ->where(['periode_id' => $periode_id])
            ->order(['numero' => 'ASC'])
            ->first()->id;
        }

        $tachesTbl = TableRegistry::get('TachesPros');
        $taches = $tachesTbl->find('list')
            ->contain(['Activites'])
            ->order([
                'Activites.Numero' => 'ASC',
                'TachesPros.Numero' => 'ASC'
            ]);
        $tache_id = $this->request->getQuery('tache_id');
        if ($tache_id =='') {
        $tache_id = $tachesTbl->find()
        ->contain(['Activites'])
        ->order([
            'Activites.Numero' => 'ASC',
            'TachesPros.Numero' => 'ASC'
            ])
            ->first()->id;
        }
        $this->set(compact( //passage des variables à la vue
            'classes', 'classe_id',
            'progression_id', 'progressions',
            'rotations', 'rotation_id',
            'periodes', 'periode_id',
            'taches', 'tache_id'
        ));
    }
    /***************** Ajoute une tâche principale
     **********************************************************/
    public function add()
    {
        $this->_loadFilters($this->request);
        
        $tp = $this->TravauxPratiques->newEntity();
        if ($this->request->is('post')) {
            $tp = $this->TravauxPratiques->patchEntity($tp, $this->request->getData());
            if ($this->TravauxPratiques->save($tp)) {
                $this->_updateTpEleves($tp);
                $this->Flash->success(__('Le matériel a été sauvegardé.'));
                return $this->redirect(['action' => 'index',
                    '?' => [
                        'progression_id'=> $this->viewVars['progression_id'],
                        'periode'=> $this->viewVars['periode_id'],
                        'rotation_id'=> $this->viewVars['rotation_id'],
                        'classe_id'=> $this->viewVars['classe_id']
                    ]]);
            } else {
                $this->Flash->error(__('Le matériel n\'a pas pu être sauvegardé ! Réessayer.'));
            }
        }

        $this->set(compact('tp'));
        //debug($this->viewVars);
    }


    /**
     * Édite un utilisateur
     */
    public function edit($id = null)
    {
        $this->_loadFilters($this->request);
        $tp = $this->TravauxPratiques->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (!isset($data['specifique'])) {
                $data['specifique'] = false;
            }
            $tp = $this->TravauxPratiques->patchEntity($tp, $data);
            //debug($tp);die;
            if ($this->TravauxPratiques->save($tp)) {                  //Sauvegarde les données dans la BDD
                $this->Flash->success(__('Le matériel a été sauvegardé.'));      //Affiche une infobulle
                return $this->redirect(['action' => 'index',
                '?' => [
                    'progression_id'=> $this->viewVars['progression_id'],
                    'periode'=> $this->viewVars['periode_id'],
                    'rotation_id'=> $this->viewVars['rotation_id'],
                    'classe_id'=> $this->viewVars['classe_id']
                ]]);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__('Le matériel n\'a pas pu être sauvegardé ! Réessayer.')); //Sinon affiche une erreur
            }
        }

        $this->set(compact('tp'));
    }

    private function _updateTpEleves($tp = null) //on lie le nouveau TP au TP_Eleves
    {
        $tableTpEleves = TableRegistry::get('TpEleves');
        $tableEleves = TableRegistry::get('Eleves');

        $listEleves = $tableEleves->find();
        foreach ($listEleves as $eleve) {
            $tpEleve = $tableTpEleves->newEntity();
            $tpEleve->eleve_id = $eleve->id;
            $tpEleve->travaux_pratique_id = $tp->id;
            $tpEleve->debut = null;
            $tpEleve->fin = null;
            $tpEleve->note = null;
            $tpEleve->pronote = false;
            $tpEleve->memo = '';
            $tableTpEleves->save($tpEleve);
        }
    }

    /************* Affiche toutes les données d'un T.P************************
     ********************************************************************************/
    public function view($id = null)  //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $tp = $this->TravauxPratiques->get($id, [
            'contain' => ['Rotations.Periodes', 'Rotations.Themes']
        ]);
        $this->set(compact('tp'));;
    }

    /**
     * Efface un utilisateur
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tp = $this->TravauxPratiques->get($id);
        if ($this->TravauxPratiques->delete($tp)) {
            $this->Flash->success(__("Le TP a été supprimé."));
        } else {
            $this->Flash->error(__("Le TP n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }
}
