<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class SiteController extends CommonController
{
	/**
	 * Index action is the default action in a controller.
	 */
	public function actionIndex()
	{
        $this->render('index');
    }
    public function actionTest(){
        
        
        $db = Yii::app()->db;
         $sql = 'select * from platform_user where status = 0 ';
        $command = $db->createCommand($sql);

        $command->params = array(':status'=>'0');

        $result = $command->queryAll();
        $this->render('test', array(
                                'var1'=>'erere',
                                'var2'=>'ok',
            ));
    }
    public function actionError(){
        echo 'error';
    }
    public function actionHello(){
    }
}
