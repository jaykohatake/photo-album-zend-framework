<?php

namespace Usuario\Form;

 use Zend\Form\Form;
 use Zend\Form\Element;

 class UsuarioForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('usuario');

       $this->add(array(
             'name' => 'documento',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Documento de identificacion del usuario',
             ),
        ));
       $this->add(array(
             'name' => 'documento_ant',
             'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'nombre',
            'type' => 'Text',
            'options' => array(
                'label' => 'Nombre del usuario',
            ),
        ));
        $this->add(array(
             'name' => 'nickName',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Nickname del usuario',
             ),
         ));
        $this->add(array(
             'name' => 'contrasena',
             'type' => 'password',
             'options' => array(
                 'label' => 'Contraseña del usuario',
             ),
         ));
        $this->add(array(
             'name' => 'contrasena_2',
             'type' => 'password',
             'options' => array(
                 'label' => 'Confirmar contraseña del usuario',
             ),
        ));

        $file = new Element\File('avatar');
        $file->setLabel('Avatar del Usuario')
                ->setAttribute('id', 'avatar');
        $this->add($file);
        $this->add(array(
            'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Crear',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
