<?php
class LoginController extends CommonController{
 
	public function actionLogin(){
        $this->render('login');
    }
    public function actionLoginOut(){
        if( isset(Yii::app()->session['admin_id'] )){
            unset(Yii::app()->session['admin_id']);
        }
        if( isset(Yii::app()->session['admin_name'] )){
            unset(Yii::app()->session['admin_name']);
        }
        $this->renderJson('成功');

    }
    public function actionDoLogin(){
        $p = $this->getParams('POST');
        if( !isset($p['name']) || empty($p['name']) ){
            $this->renderError('用户名不能为空', ErrorCode::PARAM_EMPTY); 
        }
        if( !isset($p['password']) || empty($p['password']) ){
            $this->renderError('密码不能为空', ErrorCode::PARAM_EMPTY); 
        }
        $re = AdminUserModel::model()->find('admin_name=:admin_name', array(':admin_name'=> $p['name']));
        if( empty($re) ){
            $this->renderError( '无此用户', ErrorCode::USERS_ERROR);
        }
        if( $re['status'] != 0 ){
            $this->renderError('用户状态错误，请联系管理员', ErrorCode::USERS_DENY);
        }
        if( md5($p['password']) != $re['password']){
            $this->renderError( '密码错误', ErrorCode::USERS_PASSWORD_ERR );
        }
        Yii::app()->session['admin_name'] = $re['admin_name'];
        Yii::app()->session['admin_id'] = $re['id'];
        $this->admin_user = $re;

        $this->renderJson('登录成功');
    }
}
