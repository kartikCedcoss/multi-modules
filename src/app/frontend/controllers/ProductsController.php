<?php
namespace Multi\Front\Controllers;
use Phalcon\Mvc\Controller;

class ProductsController extends Controller
{ 
    public function indexAction()
    {
     
    }
    public function searchAction(){
        $flag = 0;
        if($this->request->getPost('search') != "" ){
        $product = $this->request->getPost('search');
        $collection = $this->mongo->test->products;
        $find = array('name'=>"$product");
        $result = $collection->find($find);
        $this->view->result=$result;
        $flag =1;
        }
        $this->view->flag = $flag;
    }
   
    public function editAction(){
        $id = $this->request->getPost('view');
        $collection = $this->mongo->test->products;
        $result = $collection->findOne([ "_id" => new \MongoDB\BSON\ObjectId($id)]);
        $this->view->result=$result;
    }
    

    

}