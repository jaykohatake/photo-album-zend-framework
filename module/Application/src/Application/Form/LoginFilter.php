<?php
namespace Application\Form;
 
use Zend\InputFilter\InputFilter;
 
class LoginFilter extends InputFilter {
 
    public function __construct(){
        
        $isEmpty = \Zend\Validator\NotEmpty::IS_EMPTY;
        $invalidEmail = \Zend\Validator\EmailAddress::INVALID_FORMAT;
        
        $this->add(array(
            'name' => 'nickName',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'Nickname can not be empty.'
                        )
                    ),
                    'break_chain_on_failure' => true
                ),
//                array(
//                    'name' => 'EmailAddress',
//                    'options' => array(
//                        'messages' => array(
//                            $invalidEmail => 'Enter Valid Email Address.'
//                        )
//                    )
//                )
//                'validators' => array(
//                     array(
//                         'name'    => 'StringLength',
//                         'options' => array(
//                             'encoding' => 'UTF-8',
//                             'min'      => 1,
//                             'max'      => 30,
//                         ),
//                     ),
//                 ),
            ),
        ));
        
        $this->add(array(
            'name' => 'contrasena',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            $isEmpty => 'Password can not be empty.'
                        )
                    )
                )
            )
        ));
    }
}
