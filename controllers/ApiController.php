<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
//namespace app\controllers;

use yii\rest\ActiveController;

/**
 * UserController implements the CRUD actions for User model.
 */
class ApiController extends ActiveController
{
   public $modelClass = 'app\models\User';
   
   public function parseToJson(){
        $post = file_get_contents("php://input");
        $data = Json::decode($post, true);
        return $data;

   }
   
    public function actionEntry()
    {
    
        
         $data= $this->parseToJson();
         $model = new User; 
       
         $model->username=$data["username"];
         $model->password=$data["password"]; 

        if ($model->save()) {
        
           $output = array('response' => "success");

                echo json_encode($output);
        } else {
             $output = array('response' => "fails");

                echo json_encode($output);
        }
    }

   
}
