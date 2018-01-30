<?php

namespace Application\Controller;

use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Form\LoginForm;
use Application\Form\LoginFilter;
use Application\Model\UserPassword;

class LoginController extends AbstractActionController {

    protected $storage;
    protected $authservice;

    public function indexAction() {
        $request = $this->getRequest();
        
//        return new ViewModel(array());
        
        $view = new ViewModel();
        $loginForm = new LoginForm('LoginForm');
        $loginForm->setInputFilter(new LoginFilter());
        
        if ($request->isPost()) {
            $data = $request->getPost();
            $loginForm->setData($data);
            if ($loginForm->isValid()) {
                $data = $loginForm->getData();

                $userPassword = new UserPassword();
                //se cifra la contraseña, y se debe tener cifrada la contraseña en bd con el mismo metodo
                //$encyptPass = $userPassword->create($data['password']);
                $encyptPass = $data['contrasena']; //no se esta cifrando la contraseña actualmente
                $this->getAuthService()
                        ->getAdapter()
                        ->setIdentity($data['nickName'])
                        ->setCredential($encyptPass);
                $result = $this->getAuthService()->authenticate();
                if ($result->isValid()) {
                    $session = new Container('Usuario');
                    $session->offsetSet('nickName', $data['nickName']);
                    
                    $this->flashMessenger()->addMessage(array('success' => 'Login Success.'));
                    
                    return $this->redirect()->tourl('../album');
                // Redirect to page after successful login
                } else {
                    $this->flashMessenger()->addMessage(array('error' => 'invalid credentials.'));
                    
                    return $this->redirect()->tourl('../usuario');
                // Redirect to page after login failure
                }
                return $this->redirect()->tourl('application/login');
                // Logic for login authentication                
            } else {
                $errors = $loginForm->getMessages();
                //prx($errors);  
            }
        }
        $view->setVariable('loginForm', $loginForm);
        return $view;
    }

    private function getAuthService() {
        if (!$this->authservice) {
            $this->authservice = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authservice;
    }

    public function logoutAction() {
        $session = new Container('Usuario');
        $session->getManager()->destroy();
        $this->getAuthService()->clearIdentity();
        return $this->redirect()->toUrl('application/login');
    }

}
