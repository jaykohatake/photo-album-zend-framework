<?php

namespace Imagen\Form;

 use Zend\Form\Form;
 use Zend\Form\Element;

 class ImagenForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('imagen');

        $file = new Element\File('foto');
        $file->setLabel('Foto')
                ->setAttribute('id', 'foto');
        $this->add($file);
        $this->add(array(
             'name' => 'idImagen',
             'type' => 'Hidden',
        ));
        $this->add(array(
             'name' => 'idAlbum',
             'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'titulo',
            'type' => 'Text',
            'options' => array(
                'label' => 'Titulo de la imagen',
            ),
        ));
        $this->add(array(
             'name' => 'descripcion',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Descripcion de la imagen',
             ),
        ));
        $this->add(array(
             'name' => 'comentario',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Comentario sobre la imagen',
             ),
         ));
        $this->add(array(
             'name' => 'numeroOrden',
             'type' => 'Hidden',
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
