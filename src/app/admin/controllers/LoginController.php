<?php

namespace Multi\Admin\Controllers;
use MyEscaper;
use Phalcon\Mvc\Controller;

class LoginController extends Controller
{ 
    public function indexAction()
    {
       if($this->session->has('admin')){
           $this->response->redirect('../index');
       }
    }
    public function signupAction(){

    }
    public function authAction(){
        $email = $this->request->getPost('email');
        $pass = $this->request->getPost('pass');
        $collection = $this->mongo->test->users;
        $result = $collection->findOne([ "email" => $email,"password"=>$pass]);
        if($result){
            $this->session->set('admin',$result->name);
            $this->response->redirect('../index');
            return $this->logger->excludeAdapters(['signup'])->notice('Login By : '.$result->name );
        }
        else{
            return $this->logger->excludeAdapters(['signup'])->error($email . ':-Wrong Credentials');
        }
    }
    public function registerAction(){
        $escape = new MyEscaper();
        $data = array(
            "name" => $escape->sanitize($this->request->getPost('nameInput')),
            "email" => $escape->sanitize($this->request->getPost('emailInput')),
            "password" => $escape->sanitize($this->request->getPost('passInput'))
        );
        $collection = $this->mongo->test->users;
        $insertOneResult = $collection->insertOne($data,[
            'name',
            'email',
            'password',
           
        ]);
      if($insertOneResult){
        return $this->logger->excludeAdapters(['login'])->notice('account created with : '.$this->request->getPost('emailInput'));

          $this->view->message = $insertOneResult->getInsertedId();
      }
    }
    public function logoutAction(){
        $this->session->destroy();
        $this->response->redirect('../login');
    }
   
}