<?php

namespace Album\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Album\Model\Album;
 use Album\Form\AlbumForm;
 //para el manejo de sesion
 use Zend\Session\Container;

 class AlbumController extends AbstractActionController
 {
     protected $albumTable;
     
     public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Album\Model\AlbumTable');
         }
         return $this->albumTable;
     }
     
     public function indexAction()
     {
         $mensaje = "no hay mensaje";
         $session = new Container('Usuario');
         
         if ($session->offsetExists('nickName')) {
             $mensaje = $session->nickName;
         }
         
         return new ViewModel(array(
             'albumes' => $this->getAlbumTable()->fetchAll($session->nickName),
             'mensaje' => $mensaje
         ));
     }

     public function addAction()
     {
         $form = new AlbumForm();
         $form->get('submit')->setValue('Crear');
         
         //traer el nickName de la sesion
         $session = new Container('Usuario');
         $form->get('nickName')->setValue($session->nickName);

         $request = $this->getRequest();
         if ($request->isPost()) {
             $album = new Album();
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $album->exchangeArray($form->getData());
                 $this->getAlbumTable()->saveAlbum($album);

                 // Redirect to list of albums
                 return $this->redirect()->toRoute('album');
                 
                 //prueba para editar sin ir a BD
//                 return array('mensaje' => $album,
//                    'id' => $id,
//                    'form' => $form,
//                 /////////////////////////////////
//                ); 
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'add'
             ));
         }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $album = $this->getAlbumTable()->getAlbum($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('album', array(
                 'action' => 'index'
             ));
         }

         $form  = new AlbumForm();
         $form->bind($album);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($album->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getAlbumTable()->saveAlbum($album);
                 // Redirect to list of albums
                 return $this->redirect()->toRoute('album');

                 //prueba para editar sin ir a BD
//                 return array('mensaje' => $album,
//                    'id' => $id,
//                    'form' => $form,
//                 //
//                );                
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('album');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             //obtiene el paramtero del, por defecto con valor No
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getAlbumTable()->deleteAlbum($id);
             }

             // Redirect to list of albums
             return $this->redirect()->toRoute('album');
         }

         return array(
             'id'    => $id,
             'album' => $this->getAlbumTable()->getAlbum($id)
         );
     }
 }
