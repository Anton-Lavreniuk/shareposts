<?php
 /*
  * Base controller. Loads models and views
  */

    class Controller{

        //Load model
        public function model($model){
            // Require the model
            require_once '../app/models/'.$model.'.php';

            // Instantiate the model
            return new $model();
        }

        //Load view
        public function view($view,$data = []){
            // Require the view
            if(file_exists( '../app/views/'.$view.'.php')){
             require_once '../app/views/'.$view.'.php';
            }else{
                die('View does not exist!');
            }

    }

    }