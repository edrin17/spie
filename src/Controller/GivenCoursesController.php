<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 */
class GivenCoursesController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->viewBuilder()->setLayout('default');
	}

   public function index()
  {
    $givenCourses = $this->GivenCourses->find()->order(['name' => 'ASC']);
    $this->set(compact('givenCourses'));
  }

  /**
   * Affiche toutes les données d'un utilisateur
   */
  public function view($id = null)                                //Met le paramètre id à null pour éviter un paramètre restant ou hack
  {
    $givenCourse = $this->givenCourses->get($id, ['contain' => [] ]);
    $this->set('givenCourse', $givenCourse);                                  // Passe le paramètre 'givenCourse' à la vue.
    $this->set('_serialize', ['givenCourse']);                         // Sérialize 'givenCourse'
  }

  public function add()
  {
      $givenCourse = $this->GivenCourses->newEntity();                                   // crée une nouvelle entité dans $givenCourse
      if ($this->request->is('post')) {                                           //si requête de type post
          $givenCourse = $this->GivenCourses->patchEntity($givenCourse, $this->request->getData());  //??
          if ($this->GivenCourses->save($givenCourse)) {                                 //Met le champ 'id' de la base avec UUID CHAR(36)
              $this->Flash->success(__("Le document a été sauvegardée."));      //Affiche une infobulle
              return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
          } else {
              $this->Flash->error(__("Le document n'a pas pu être sauvegardée ! Réessayer.")); //Affiche une infobulle
          }
      }
      $this->set(compact('givenCourse'));
      $this->set('_serialize', ['givenCourse']);
  }

  /**
   * Édite un utilisateur
   */
  public function edit($id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
  {
      $givenCourse = $this->GivenCourses->get($id, ['contain' => [] ]);                  //récupère l'id de l'utilisateur
      if ($this->request->is(['patch', 'post', 'put'])) {                         // Vérifie le type de requête
          $givenCourse = $this->GivenCourses->patchEntity($givenCourse, $this->request->getData());
          if ($this->GivenCourses->save($givenCourse)) {                                 //Sauvegarde les données dans la BDD
              $this->Flash->success(__("Le document a été sauvegardé."));      //Affiche une infobulle
              return $this->redirect(['action' => 'index']);                      //Déclenche la fonction 'index' du controlleur
          } else {
              $this->Flash->error(__("Le document n'a pas pu être sauvegardé ! Réessayer."));
          }
      }
      $this->set(compact('givenCourse'));
      $this->set('_serialize', ['givenCourse']);
  }

  /**
   * Efface un utilisateur
   */
  public function delete($id = null)      //Met le paramètre id à null pour éviter un paramètre restant ou hack
  {
      $this->request->allowMethod(['post', 'delete']); // Autoriste que certains types de requête
      $givenCourse = $this->GivenCourses->get($id);
      if ($this->GivenCourses->delete($givenCourse)) {
          $this->Flash->success(__("Le document a été supprimé."));
      } else {
          $this->Flash->error(__("Le document n' pas pu être supprimé ! Réessayer."));
      }
      return $this->redirect(['action' => 'index']);
  }

  /**
   * Slection de la classe avant association
   */
  public function classSelect($givenCourse_id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
  {
      if (isset($this->request->getData()['givenCourse_id'])
        and isset($this->request->getData()['classe_id'])) {
          $data = $this->request->getData();
          $this->setAction('associate', $data);
      }
      $classes = TableRegistry::get('Classes');
      //debug ($givenCourse);
      $classes = $classes->find('list')->order(['nom' => 'ASC']);                  //récupère l'id de l'utilisateur
      $this->set(compact('classes','givenCourse_id'));
  }

  public function associate($givenCourse_id = null)                                        //Met le paramètre id à null pour éviter un paramètre restant ou hack
  {

  }
}
