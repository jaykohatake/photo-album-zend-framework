<?php

 namespace Imagen\Model;
 
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
//
use Zend\InputFilter\FileInput;
use Zend\Validator;
//
use Zend\Filter\File\RenameUpload;
use Zend\Validator\File\Size;
use Zend\Validator\File\Extension;
use Zend\Validator\File\MimeType;

 class Imagen
 {
     private $idImagen;
     private $foto;
     private $descripcion;
     private $titulo;
     private $comentario;

     public function exchangeArray($data)
     {
         $this->idImagen = (isset($data['idImagen'])) ? $data['idImagen'] : null;
         $this->foto = (isset($data['foto'])) ? $data['foto'] : null;
         $this->descripcion  = (isset($data['descripcion'])) ? $data['descripcion'] : null;
         $this->titulo  = (isset($data['titulo'])) ? $data['titulo'] : null;
         $this->comentario  = (isset($data['comentario'])) ? $data['comentario'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     public function getIdImagen(){
         return $this->idImagen;
     }
     
     public function getfoto(){
         return $this->foto;
     }
     
     public function getDescripcion(){
         return $this->descripcion;
     }
     
     public function getTitulo(){
         return $this->titulo;
     }
     
     public function getComentario(){
         return $this->comentario;
     }
     
     // Add content to these methods:
     public function setInputFilter(InputFilterInterface $inputFilter)
     {
         throw new \Exception("Not used");
     }

     public function getInputFilter()
     {
         if (!$this->inputFilter) {
             
             $inputFilter = new InputFilter();

             $notSame = \Zend\Validator\Identical::NOT_SAME;
             
             $inputFilter->add(array(
                 'name'     => 'titulo',
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
                             'max'      => 50,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'descripcion',
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

             $inputFilter->add(array(
                 'name'     => 'comentario',
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
             
             $inputFilter->add(array(
                 'name'     => 'numeroOrden',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'idAlbum',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'idImagen',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
            $fileInput = new FileInput('foto');
            $fileInput->setRequired(false);
            $fileInput->getValidatorChain()
                    ->attach(new Size(array(
                        'messageTemplates' => array(
                            Size::TOO_BIG => 'The file supplied is over the allowed file size',
                            Size::TOO_SMALL => 'The file supplied is too small',
                            Size::NOT_FOUND => 'The file was not able to be found',
                        ),
                        'options' => array(
                            'max' => 4000
                        )
                            )
                    ))
                    ->attach(new MimeType('image/gif,image/jpg, image/png, image/jpeg'));

//            renombrar el archivo
//            $fileInput->getFilterChain()->attach(new RenameUpload(array(
//                'options' => array(
//                    'target' => 'public/img/user-avatar/avatar'.$this->getNickName().'.png',
//                    'overwrite' => true,
//                )
//            )));
            $inputFilter->add($fileInput);

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
     }
 }

