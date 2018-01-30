<?php

namespace Album\Form;

 use Zend\Form\Form;

 class AlbumForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('album');

         $this->add(array(
             'name' => 'idAlbum',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'nickName',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'nombre',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Nombre del Album',
             ),
         ));
         $this->add(array(
             'name' => 'descripcion',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Descripcion del Album',
             ),
         ));
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
