<?php
namespace Multi\Admin\Controllers;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{ 
    public function indexAction()
    {    
        if(!$this->session->has('admin')){
            $this->response->redirect('../login');
        } 

        $client = new \MongoDB\Client("mongodb+srv://m001-student:m001-mongodb-basics@cluster0.bromc.mongodb.net/myFirstDatabase?retryWrites=true&w=majority");
        $collection = $client->test->products;
        $result = $collection->find();
        $this->view->result=$result;   
        if($this->request->getPost('view') !=""){
            
            $id = $this->request->getPost('view');
            $result2 = $collection->findOne([ "_id" => new \MongoDB\BSON\ObjectId($id)]);
            $this->view->result2 = $result2;
        }
    }
   
}