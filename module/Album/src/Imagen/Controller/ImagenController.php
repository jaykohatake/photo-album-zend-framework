<?php

namespace Imagen\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Imagen\Model\Imagen;
 use Imagen\Model\ImagenxAlbum;
 use Imagen\Form\ImagenForm;
  //para el manejo de sesion
 use Zend\Session\Container;

 class ImagenController extends AbstractActionController
 {
     protected $imagenTable;
     protected $imagenxalbumTable;
     
     public function getImagenTable()
     {
         if (!$this->imagenTable) {
             $sm = $this->getServiceLocator();
             $this->imagenTable = $sm->get('Imagen\Model\ImagenTable');
         }
         return $this->imagenTable;
     }
     
     public function getImagenxAlbumTable()
     {
         if (!$this->imagenxalbumTable) {
             $sm = $this->getServiceLocator();
             $this->imagenxalbumTable = $sm->get('Imagen\Model\ImagenxAlbumTable');
         }
         return $this->imagenxalbumTable;
     }
     
     public function indexAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         $nombre = $this->params()->fromRoute('nombre', "nombre");
         
         //traer el nickName de la sesion
         $session = new Container('Usuario');
         $usuario = $session->nickName;
         
         return new ViewModel(array(
             'imagenes' => $this->getImagenTable()->fetchAll($id),
             'idAlbum' => $id,
             'nombre' => $nombre,
             'usuario' => $usuario,
         ));
     }

     public function addAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         
         $form = new ImagenForm();
         $form->get('submit')->setValue('Crear');
         $form->get('idAlbum')->setValue($id);
         //consultar en bd el numero de imagenes y poner la nueva de ultima (count imagenes)
         $form->get('numeroOrden')->setValue(99);

         $request = $this->getRequest();
         if ($request->isPost()) {
             $imagen = new Imagen();
             $form->setInputFilter($imagen->getInputFilter());
             
             //se reciben los datos del formulario y el archivo del avatar (imagen)
             $post = array_merge_recursive($request->getPost()->toArray(),$request->getFiles()->toArray());
             
             $form->setData($post);
             
             //traer el nickName de la sesion
             $session = new Container('Usuario');
             $usuario = $session->nickName;

             if ($form->isValid()) {
                 $imagen->exchangeArray($form->getData());
                 $idImagen = $this->getImagenTable()->saveImagen($imagen, $usuario);
//                 $idImagen = 1; //prueba
                 
                 $form->get('idImagen')->setValue($idImagen);
//                 $form->setData(array('idImagen' => $idImagen));
                 $imagenxalbum = new ImagenxAlbum();
//                 $imagenxalbum->exchangeArray($form->getData());
                 $imagenxalbum->exchangeArray(array('idImagen' => $idImagen, 'numeroOrden' => (int)$form->getData()['numeroOrden'], 'idAlbum' => (int)$form->getData()['idAlbum']));
                 $this->getImagenxAlbumTable()->saveImagenxAlbum($imagenxalbum);
                 
                 //prueba para editar sin ir a BD
//                 return array('imagen' => $imagen,
//                    'imagenxalbum' => $imagenxalbum,
//                    'id' => $id,
//                    'form' => $form,
                 //
//                ); 
                 // Redirect to list of images
                 return $this->redirect()->toRoute('imagen', array('action' => 'index', 'id' => $id));
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
 }

