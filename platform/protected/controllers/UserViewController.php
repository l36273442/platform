<?php
class UserViewController extends Controller{
    //交易密码
    public function actionUpTpass(){
        $this->render('uptpass');
    }
    public function actionPowerContractOrderList(){
        $this->render('powercontractorderlist');
    }
    //登录密码 
    public function actionUpPass(){

        $this->render('uppass');
    }
}
