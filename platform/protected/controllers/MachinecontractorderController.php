<?php
class MachineContractOrderController extends AjaxController{
    const CANCEL = 5;
    public function actiongetUserList(){
        $p = $this->getParams('REQUEST');
        if( !isset($p['size']) || !is_numeric($p['size']) || $p['size'] <= 0 ){
            $size = $this->size;
        }
        else{
            $size = $p['size'];
        }
        if( $size > $this->maxSize ){
            $size = $this->maxSize;
        }     
        if( !isset($p['page']) || !is_numeric($p['page']) || $p['page'] <= 0 ){
            $page = 1;
        }
        else{
            $page = $p['page'];
        }
        //$uid =1;
        $uid = Yii::app()->session['id']; 
        if( isset($p['status']) && is_numeric($p['status'])){
            $status = $p['status'];
        }
        else{
            $status = '';
        }
        $where = ' where uid=:uid';
        $arr = array(':uid'=>$uid);
        if( $status !== '' ){
            $where .= ' and status=:status';
            $arr[':status'] = $status;          
        }
        if( isset($p['coin_id']) && is_numeric($p['coin_id']) && $p['coin_id']>=0 ){
            $where .=' and coin_id=:coin_id';
            $arr[':coin_id'] = $p['coin_id'];
        }
        $s = 'select * from '.MachineContractOrderModel::model()->tableName().$where.' limit '.($page-1)*$size.','.$size;
        $r = MachineContractOrderModel::model()->findAllBySql( $s , $arr );
        $data = array();
        if( $r ){ 
            foreach( $r as $v ){
                $data[] = $v->attributes;
            }
        }
        $this->renderJson(Yii::t('common','success') , $data);
    }
}
