<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;
/**
 * MaterielsTravauxPratiques Controller
 */
class ProgressionsController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

	public function tp()
	{
        $progression_id = $this->request->getQuery('progression_id');
        $progressionsTable = TableRegistry::get('Progressions');
		$progressions = $progressionsTable->find('list')
			->order(['id' => 'ASC']);

        if (is_null($progression_id)) {
            $progression_id = $progressionsTable->find()
                ->first()
                ->id;
        }
        $periodes = TableRegistry::get('Periodes');

		$listPeriodes = $periodes->find()
            ->where(['progression_id' => $progression_id])
            ->contain([
                'Rotations.TravauxPratiques.Materiels.Marques',
                'Rotations.TravauxPratiques.Materiels.TypesMachines',
                'Rotations.Periodes',
                'Rotations.Themes'
            ])

			->order(['Periodes.numero' => 'ASC']);

        $listPeriodes = $listPeriodes->toArray();

        //on classe les rotations de chaque periode par numero ASC
        $nbTpTotal = 0;
        foreach ($listPeriodes as $periode) {
            $tpByPeriode = 0;
            foreach ($periode->rotations as $rotation) {
				$numberedRotations[$rotation->numero] = $rotation;
                $tpByRotation = 0;
                foreach ($rotation->travaux_pratiques as $tp) {
                    if ($tp->specifique == 0) {
                        $tpByPeriode ++;
                        $tpByRotation ++;
                        $nbTpTotal ++;

                        $rotation->tpByRotation = $tpByRotation;
                    }

                }
            $periode->tpByPeriode = $tpByPeriode;
			}
			ksort($numberedRotations);
			$periode->rotations = $numberedRotations;
			$numberedRotations =[];
		}
        //debug($listPeriodes);die;
		//$listPeriodes = new Collection($tablePeriodes);

		//debug($listPeriodes);die;
		$this->set(compact('listPeriodes','nbTpTotal','progressions','progression_id'));
	}
    public function index()
    {
        $this->_loadFilters();
        $referential_id = $this->viewVars['referential_id'];

        $progressions = $this->Progressions->find()
            ->contain(['Referentials'])
            ->where(['referential_id' => $referential_id])
            ->order(['nom' => 'ASC']);
        $this->set(compact('progressions'));
    }

    public function add()
    {
        $this->_loadFilters();
        $progression = $this->Progressions->newEntity();
        if ($this->request->is('post')) {
            $progression = $this->Progressions->patchEntity($progression, $this->request->getData());
            if ($this->Progressions->save($progression)) {
                $this->Flash->success(__("La progression a été sauvegardé."));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__("La progression n'a pas pu être sauvegardé ! Réessayer.")); //Affiche une infobulle
            }
        }
        $this->set(compact('progression'));
    }

    public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->_loadFilters();
        $progression = $this->Progressions->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
        if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
            $progression = $this->Progressions->patchEntity($progression, $this->request->getData());
            if ($this->Progressions->save($progression)) {                                 //Sauvegarde les données dans la BDD
                $this->Flash->success(__("La progression a été sauvegardée."));      //Affiche une infobulle
                return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
            } else {
                $this->Flash->error(__("La progression n'a pas pu être sauvegardée ! Réessayer."));
            }
        }
        $this->set(compact('progression'));
    }


    public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
    {
        $this->_loadFilters();
        $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
        $progression = $this->Progressions->get($id);
        if ($this->Progressions->delete($progression)) {
            $this->Flash->success(__("La progression a été supprimé."));
        } else {
            $this->Flash->error(__("La progression n'a pas pu être supprimé ! Réessayer."));
        }
        return $this->redirect(['action' => 'index']);
    }

    private function _loadFilters($resquest = null)
    {
        //chargement de la liste des référentiels
        $referentialsTbl = TableRegistry::get('Referentials');
        $referentials = $referentialsTbl->find('list')
            ->order(['name' => 'ASC']);
        
        //récup du filtre existant dans la requête
        $referential_id = $this->request->getQuery('referential_id');

        //si requête vide slection du premier de la liste
        if ($referential_id =='') {
            $referential_id = $referentialsTbl->find()
            ->order(['name' => 'ASC'])
            ->first()
            ->id;
        }

        $this->set(compact( //passage des variables à la vue
            'referentials', 'referential_id'
        ));
    }
}
