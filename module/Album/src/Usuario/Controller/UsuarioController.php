<?php

namespace Usuario\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Usuario\Model\Usuario;
 use Usuario\Model\Persona;
 use Usuario\Form\UsuarioForm;

class UsuarioController extends AbstractActionController
 {
     protected $usuarioTable;
     protected $personaTable;
     
     public function getUsuarioTable()
     {
         if (!$this->usuarioTable) {
             $sm = $this->getServiceLocator();            
             $this->usuarioTable = $sm->get('Usuario\Model\UsuarioTable');
         }
         return $this->usuarioTable;
     }
     
     public function getPersonaTable()
     {
         if (!$this->personaTable) {
             $sm = $this->getServiceLocator();             
             $this->personaTable = $sm->get('Usuario\Model\PersonaTable');
         }
         return $this->personaTable;
     }
     
     public function indexAction()
     {
        $usuarios = $this->getUsuarioTable()->fetchAll();

        return new ViewModel(array(
            'usuarios' => $usuarios,
        ));
    }

     public function addAction()
     {
         $form = new UsuarioForm();
         $form->get('submit')->setValue('Crear');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $usuario = new Usuario();
             $form->setInputFilter($usuario->getInputFilter());
             
             //se reciben los datos del formulario y el archivo del avatar (imagen)
             $post = array_merge_recursive($request->getPost()->toArray(),$request->getFiles()->toArray());
             
             $form->setData($post);

             if ($form->isValid()) {
                 $usuario->exchangeArray($form->getData());
                 $this->getUsuarioTable()->saveUsuario($usuario);
//                 //prueba para editar sin ir a BD
//                 return array('user' => $usuario,
//                    'id' => $id,
//                    'form' => $form,
//                 //
//                ); 
                 
                 //crea la carpeta donde el usuario guardara las imagenes de sus albumes
                 mkdir('public/img/'.$usuario->getNickName(), 0777, true);
                 
                 // Redirect to list of users
                 return $this->redirect()->toRoute('usuario');
             }
         }
         return array('form' => $form);
     }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('usuario', array(
                 'action' => 'add'
             ));
         }

         // Get the User with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $usuario = $this->getUsuarioTable()->getUsuario($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('usuario', array(
                 'action' => 'index'
             ));
         }

         $form  = new UsuarioForm();
         $form->bind($usuario);         
         $form->get('submit')->setAttribute('value', 'Editar');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($usuario->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $documento_ant = $form->get('documento_ant')->getValue();
                 
                 //pasar logica de usuariotable???
                 $this->getUsuarioTable()->saveUsuario($usuario, $documento_ant);
                 // Redirect to list of users
                 return $this->redirect()->toRoute('usuario');               
             }
         }
         
         //asignar el documento anterior
         $form->get('documento_ant')->setAttribute('value', $usuario->getDocumento());

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('usuario');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             //obtiene el paramtero del, por defecto con valor No
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getUsuarioTable()->deleteUsuario($id);
             }

             // Redirect to list of users
             return $this->redirect()->toRoute('usuario');
         }

         return array(
             'id'    => $id,
             'usuario' => $this->getUsuarioTable()->getusuario($id)
         );
     }
 }

