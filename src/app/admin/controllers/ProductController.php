<?php
namespace Multi\Admin\Controllers;
use Phalcon\Mvc\Controller;

class ProductController extends Controller
{ 
    public function indexAction()
    {
     $temp=0;
     if($this->request->isPost('addField')){
      if($this->request->getPost('addField') == 0){
          $temp = 1;
      }
      elseif($this->request->getPost('addField')==1){
          $temp=2;
      }

      if($this->request->getPost('decField')== 1 ){
        $temp=0;
      }
      elseif($this->request->getPost('decField') == 2){
           $temp=1;
       }
      }
     $this->view->temp=$temp;
    }
    public function addAction(){
        $collection = $this->mongo->test->products;
        $insertOneResult = $collection->insertOne([
            'name' => $this->request->getPost('pName'),
            'category' => $this->request->getPost('catName'),
            'price' => $this->request->getPost('pPrice'),
            'stock' => $this->request->getPost('pStock'),
            'meta' => [$this->request->getPost('metaLabel'),$this->request->getPost('metaValue')],
            'variations'=> [$this->request->getPost('attrName'),$this->request->getPost('attrValue'),$this->request->getPost('varPrice')]
        ]);

      if($insertOneResult){
          $this->view->message = $insertOneResult->getInsertedId();
      }
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
    public function deleteAction(){
        $id = $this->request->getPost('delete');
        $collection = $this->mongo->test->products;
        $result = $collection->deleteOne([ "_id" => new \MongoDB\BSON\ObjectId($id)]);
        if($result){
           $this->response->redirect('../index');
        }
    }
    public function editAction(){
        $id = $this->request->getPost('view');
       
        $collection = $this->mongo->test->products;
        $result = $collection->findOne([ "_id" => new \MongoDB\BSON\ObjectId($id)]);
        $this->view->result=$result;
    }
    public function UpdateAction(){
        $id = $this->request->getPost('id');
        $newdata = array('$set'=>array(
            "name"=>$this->request->getPost('upName'),
            "category"=>$this->request->getPost('ucatName'),
            "price"=>$this->request->getPost('upPrice'),
            "stock"=>$this->request->getPost('upStock'),
            "meta"=>[$this->request->getPost('umetaLabel'),$this->request->getPost('umetaValue')],
            "variations"=>[
                $this->request->getPost('uattrName'),
                $this->request->getPost('uattrValue'),
                $this->request->getPost('uvarPrice')],
        ));
        $collection = $this->mongo->test->products;
        $result = $collection->updateOne(["_id" => new \MongoDB\BSON\ObjectId($id)],$newdata);
        if($result){
            $this->response->redirect('../index');
        }

    }

}