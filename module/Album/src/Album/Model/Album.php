<?php

 namespace Album\Model;
 
 use Zend\InputFilter\InputFilter;
 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;


 class Album
 {
     private $idAlbum;
     private $nickName;
     private $nombre;
     private $descripcion;
     
     protected $inputFilter;

     public function exchangeArray($data)
     {
         $this->idAlbum     = (isset($data['idAlbum'])) ? $data['idAlbum'] : null;
         $this->nickName = (!empty($data['nickName'])) ? $data['nickName'] : null;
         $this->nombre  = (!empty($data['nombre'])) ? $data['nombre'] : null;
         $this->descripcion  = (!empty($data['descripcion'])) ? $data['descripcion'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

     //getters y setters
     public function getIdAlbum(){
         return $this->idAlbum;
     }
     
     public function getNombre(){
         return $this->nombre;
     }
     
     public function getNickName(){
         return $this->nickName;
     }
     
     public function getDescripcion(){
         return $this->descripcion;
     }
     //
     
     // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'idAlbum',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'nickName',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 30,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'nombre',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 30,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'descripcion',
                 //no es requerido en bd, despues veo si lo permito nulo (lidiar insercion)
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 100,
                         ),
                     ),
                 ),
             ));

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;
     }

 }

