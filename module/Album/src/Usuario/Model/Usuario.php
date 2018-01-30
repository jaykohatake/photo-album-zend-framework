<?php

 namespace Usuario\Model;

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

 class Usuario extends Persona
 {
     private $nickName;
     private $avatar;
     private $contrasena;

     protected $inputFilter;
     
     public function exchangeArray($data)
     {
         $this->nombre  = (isset($data['nombre'])) ? $data['nombre'] : null;
         $this->documento  = (isset($data['documento'])) ? $data['documento'] : null;
         $this->nickName  = (isset($data['nickName'])) ? $data['nickName'] : null;
         $this->avatar  = (isset($data['avatar'])) ? $data['avatar'] : null;
         $this->contrasena  = (isset($data['contrasena'])) ? $data['contrasena'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
     
     public function getNickName(){
         return $this->nickName;
     }
     
     public function getContrasena(){
         return $this->contrasena;
     }
     
     public function getAvatar(){
         return $this->avatar;
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

             $notSame = \Zend\Validator\Identical::NOT_SAME;
             
             $inputFilter->add(array(
                 'name'     => 'documento',
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
                 'name'     => 'contrasena',
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
                 'name'     => 'contrasena_2',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 30,
                        ),
                    ),
                    array(
                        'name' => 'identical',
                        'options' => array(
                            'token' => 'contrasena',
                            'messages' => array(
                                $notSame => 'Las contraseñas no coinciden'
                            ),
                        )
                    ),
                ),
             ));
             
            $fileInput = new FileInput('avatar');
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

