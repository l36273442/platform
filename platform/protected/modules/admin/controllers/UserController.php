<?php
class UserController extends CommonController
{
    public function actionGetList(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['size']) || !is_numeric($p['size']) || $p['size'] <=0 || $p['size'] > 40 ){
            $size = 10;
        }
        else{
            $size = $p['size'];
        }
        if(!isset($p['page']) || !is_numeric($p['page']) || $p['page'] <= 0 ){
            $page = 1 ;
        }
        else{
            $page = $p['page'];
        }
        $where = 'where 1';
        $data['page'] = $page;
        $data['size'] = $size;
        if( isset($p['phone']) && !empty($p['phone']) ){
            $total = UserModel::model()->countBySql('select count(id) from platform_user where phone=:phone' , array(':phone'=>$p['phone']));
        }
        else{
            $total = UserModel::model()->countBySql('select count(id) from platform_user');
        }
        $data['total'] = $total;
        $data['pages'] = ceil($total/$size);
        $date['list'] = array();

        if( $data['total'] > 0 && $data['page'] <= $data['pages'] ){
            if(isset($p['phone']) && !empty($p['phone'])){
                $users = UserModel::model()->findAllBySql('select * from platform_user where phone=:phone order by id desc limit '.(($page-1)*$size).','.$size , array(':phone'=> $p['phone']) );
            }
            else{
                $users = UserModel::model()->findAllBySql('select * from platform_user order by id desc limit '.(($page-1)*$size).','.$size );
            }    
            
            if( $users ){
                foreach( $users as $v ){
                    $row = array();
                    $row = $v->attributes;
                    $row['ctime'] = ($row['ctime']>0)?date('Y-m-d H:i:s' ,$row['ctime']):'';
                    $row['login_time'] = ($row['login_time']>0)?date('Y-m-d H:i:s' ,$row['login_time']):'';
                    $data['list'][] = $row;
                } 
            }
        }
        $this->renderJson(Yii::t('common','success'), $data);
    }
    public function actionGetByPhone(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['phone']) || empty($p['phone']) ){
            $this->renderError('参数错误' , ErrorCode::PARAM_ERROR);
        }
        $users = UserModel::model()->findAll('phone=:phone' , array(':phone'=> $p['phone']));
        if( $users ){
            foreach( $users as $v ){
                $row = array();
                $row = $v->attributes;
                $row['ctime'] = date('Y-m-d H:i:s' ,$row['ctime']);
                $row['login_time'] = date('Y-m-d H:i:s' ,$row['login_time']);
                $data[] = $row;
            } 
        }
        $this->renderJson(Yii::t('common','success'), $data);

    }
    public function actionSetStatus(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['uid']) || !is_numeric($p['uid']) || $p['uid'] <=0 ){
            $this->renderError('参数错误' , ErrorCode::PARAM_ERROR);
        }
        if( !isset($p['status']) || !is_numeric($p['status']) || $p['status'] <0 ){
            $this->renderError('参数错误' , ErrorCode::PARAM_ERROR);
        }
        $re = UserModel::model()->updateAll(array('status'=> $p['status']) ,'id=:id' , array(':id'=>$p['uid']));
        if($re){
            $this->renderJson(Yii::t('common','success'));
        }
        $this->renderError(Yii::t('common','error') , ErrorCode::SYSTEM_ERROR);
    }
    public function actionGetUserCoin(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['uid']) || !is_numeric($p['uid']) || $p['uid'] <=0 ){
            $this->renderError('参数错误' , ErrorCode::PARAM_ERROR);
        }
        $coins = CoinModel::model()->findAllBySql('select * from platform_coin ');
        if( empty($coins) ){
            $this->renderJson(Yii::t('common','success'));
        } 
        $usercoins = UserCoinModel::model()->findAll('uid=:uid' , array(':uid' => $p['uid']));
        $user_key = array();
        if( $usercoins ){
            foreach( $usercoins as $v ){
                $user_key[$v->coin_id] = $v->attributes;
            }
        }
        $unit = ComputingPowerUnitModel::model()->findAllBySql('select * from platform_computing_power_unit');
        $unit_key = array();
        if( $unit ){
            foreach( $unit as $v ){
                $unit_key[$v->id] = $v->attributes;
            }
        }

        $data = array();

        foreach( $coins as $v ){
            $row = array();
            $row = $v->attributes;
            if( isset($unit_key[$v->unit_id]) ){
                $row['unit_name'] = $unit_key[$v->unit_id]['name'];
            }
            else{
                $row['unit_name'] = '';
            }
            if( isset($user_key[$v->id])){
                $row['current_total'] = $user_key[$v->id]['current_total'];
                $row['power_total_income'] = $user_key[$v->id]['power_total_income'];
                $row['power_total_investment'] = $user_key[$v->id]['power_total_investment'];
                $row['total_power'] = $user_key[$v->id]['total_power'];
                $row['total_machine'] = $user_key[$v->id]['total_machine'];
                $row['machine_total_investment'] = $user_key[$v->id]['machine_total_investment'];
                $row['machine_total_income'] = $user_key[$v->id]['machine_total_income'];
                $row['total_investment'] = $user_key[$v->id]['total_investment'];
                $row['total_income'] = $user_key[$v->id]['total_income'];
            }
            else{
                $row['current_total'] = 0;
                $row['power_total_income'] = 0;
                $row['power_total_investment'] = 0;
                $row['total_power'] = 0;
                $row['total_machine'] = 0;
                $row['machine_total_investment'] = 0;
                $row['machine_total_income'] = 0;
                $row['total_investment'] = 0;
                $row['total_income'] = 0;

            }
            $data['coins'][] = $row;    
        }
        $legal = UserLegalCoinModel::model()->find('uid=:uid' , array(':uid' => $p['uid']));
        if( $legal ){
            $data['usd'] = $legal->usd;
            $data['usd_recharge_total'] = $legal->usd_recharge_total;
        }    
        else{
            $data['usd'] = 0;
            $data['usd_recharge_total'] = 0;
            
        }
        $this->renderJson(Yii::t('common','success'),$data);

    }

}
