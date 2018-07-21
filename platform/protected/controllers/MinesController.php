<?php
class MinesController extends WebController{
    public function actionIndex(){
        $this->render('index',$this->data);
    }

}
