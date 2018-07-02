<?php
require_once(dirname(__FILE__).'/CommonController.php');
class AdminController extends CommonController
{
    public function init()
    {
        $this->start_time = microtime(true);
        if( !isset(Yii::app()->session['admin_id']) || empty(Yii::app()->session['admin_id'])) {
            
            $this->renderError('未登录', 4);
        }        
    }
}

