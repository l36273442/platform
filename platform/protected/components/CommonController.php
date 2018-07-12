<?php
class CommonController extends CController
{
	protected $params;
    
    public $user;
    public $admin_user;
    /*
    *url 目录
    *例 /platform/test/test
    */
    public $path; 
    /***
     * Controller need login
     * @var
     */
    public $data = array();
    public $needLogin=true;
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    public $size = 20;
    public $maxSize = 50;
    /**
     * init
     */
    public $start_time ;
    public $user_log = array();
    public static $arr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
                                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
                            );
    const ADD = 1;
    const DEL = 2;
    const UPDATE = 3;
    const SEARCH = 4;
    public $lang = array('zh_cn','en_us');
    public function init()
    {
        $this->start_time = microtime(true);
        Yii::app()->messages->forceTranslation = true;
        
        if(isset($_GET['lang']) && $_GET['lang'] != "" && in_array( $_GET['lang'], $this->lang))
        {
            Yii::app()->language = $_GET['lang'];
            Yii::app()->session['lang'] =  $_GET['lang'];
        }
        else if(!empty(Yii::app()->session['lang']))
        {
            Yii::app()->language = Yii::app()->session['lang'];
        }
        else
        {
            Yii::app()->language = Yii::app()->sourceLanguage;
        }
    }
    public function check_password( $pass ){
        if( empty($pass) ){
            return false;
        }
        $len = strlen($pass);
        if( $len < 6 || $len > 16 ){
            return false;
        }
        $reg = '/(^[0-9]+$)|(^[a-zA-Z]+$)/';
        $re = preg_match( $reg , $pass );
        if( $re ){
            return false;
        }
        return true;
    }
    public function getInvite( $num ){
        if( $num <= 0 ){
            return '';
        }
        $str = '';
        $x =$num;
        while(true){
            if( $x < 52 ){
                $str .= self::$arr[$x];
                break;
            }
            $j = $x%52;
            $str .= self::$arr[$j];
            $x = floor($x/52); 

        }
        $len = strlen($str);
        if( $len < 8 ){
            $y = 8-$len;
            for( $i=0 ; $i< $y ; $i++  ){
                $n = rand(0,9);
                $str .= $n;
            }
        }
        return $str;
    }
    public function getMark(){

        $str = '';
        $x = time();
        while( $x >= 52 )
        {
            $j = $x%52;
            $str = self::$arr[$j].$str;
            $x = floor($x/52); 
        }
        $str = self::$arr[rand(0,51)].$str;
        return $str;
    }
    //加密验证token
    public function getToken( $arr )
    {
        if( empty($arr) )
        {
            return false;
        }
        return md5(implode("",ksort($arr)));
    }
    public function addOperateHistory( $bill_id = 0 , $org_id = 0 ,  $type = 0 , $bill_type = 0 , $arr = array())
    {
        $p['bill_id'] = $bill_id;
        $p['org_id'] = $org_id;
        $p['type'] = $type;
        $p['bill_type'] = $bill_type;
        $arr['path'] = Yii::app()->urlManager->parseUrl(Yii::app()->request);
        //$arr['ua'] = $_SERVER['HTTP_USER_AGENT'];
        $p['c_t'] = $p['u_t'] = time();
        $p['c_u'] = $this->user['id'];
        $p['c_user_name'] = $this->user['user_name'];
        $p['content'] = json_encode( $arr , JSON_UNESCAPED_UNICODE );
        /*
        $re = OperateHistoryModel::model()->create($p);  
        if( !$re )
        {
            return false;
        }
         */
        return true;
    }
    //time 时间秒数 格式化成 1时1分1秒
    public function buildTime( $time )
    {
        $str = '';

        $str = ($time%60).'秒'.$str;
        $time = floor($time/60);
        if( $time > 0 )
        {
            $str = ($time%60).'分'.$str;
            $time = floor($time/60);
            if( $time > 0 )
            {
                $str = $time.'时'.$str;
            }
        }
        return $str; 
    }
    public function is_mobile()
    {
        $str = "/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i";
        if( preg_match("$str" , $_SERVER['HTTP_USER_AGENT'] ) )
        {
            return true;
        }
        return false;
    }
    public function RowsToIds( $rows , $col = 'id' )
    {
        $ids = array();
        if( !empty( $rows ) )
        {
            foreach ( $rows as $v  )
            {
                if( isset($v[$col]) )
                {
                    $ids[] = $v[$col];
                }
            }    
        }
        return $ids;
    }
    public function RowsToArrs( $rows , $col = 'id')
    {
        $arr = array();
        if( !empty( $rows ) )
        {
            foreach ( $rows as $v  )
            {
                if( isset($v[$col]) )
                {
                    $arr[$v[$col]][] = $v;
                }
            }    
        }
        return $arr;

    }
    public function RowsToArr( $rows , $col = 'id' )
    {
        $arr = array();
        if( !empty( $rows ) )
        {
            foreach ( $rows as $v  )
            {
                if( isset($v[$col]) )
                {
                    $arr[$v[$col]] = $v;
                }
            }    
        }
        return $arr;
    } 
    protected function _exit(){
        $this->afterAction();
        exit;
    }
    protected function afterAction( $action = '' ){

        $this->log();
    } 
   /*  
    *
    *t
    */
    public function log()  {
        $re['user_host'] = Yii::app()->request->getUserHostAddress();
        $re['server_addr'] = $_SERVER['SERVER_ADDR'];
        $re['HTTP_X_FORWARDED_FOR'] = isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:'';
        $re['end_time'] = microtime(true);
        $re['start_time'] = $this->start_time;
        $re['cost'] = ceil($re['end_time']*10000 - $this->start_time*10000)/10000;
        $re['url'] = Yii::app()->request->url;
        $re['referer'] = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
        $re['cookie'] = $_COOKIE;
        $re['ua'] = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
        $re = array_merge( $re , $this->user_log);
        $log = json_encode( $re , JSON_UNESCAPED_UNICODE );
        

        Yii::log($log, CLogger::LEVEL_INFO , 'amp.platform');
    
    }
    /*
    *添加用户日志
    *
    */ 
    public function addLog( $key , $val = '' )
    {
        if( empty($key) )
        {  
            return false;
        }
        $this->user_log[$key] = $val;
        return true;
    } 
    /**
     * 获取输入参数
     * @return array 解析后的数组
     */
    protected function getParams( $type = 'JSON' ){
        if( empty($type) )
        {
            $type = 'JSON';
        }
        $type = strtoupper($type);
        if( !in_array( $type , array( 'POST' , 'GET' , 'REQUEST' , 'JSON' )) )
        {
            $type = 'JSON';
        }
        $params = array(); 
        switch ( $type ){
            case 'POST':
                $params = $_POST;
                break;
            case 'GET':
                $params = $_GET;
                break;
            case 'REQUEST':
                $params = $_REQUEST;
                break;
            case 'JSON':
            default:
                $input = file_get_contents('php://input');
                if( !empty($input) )
                {
                     $params = json_decode($input, true);
                }

        }
        return $params;
    }
    public function  addObj( $obj )
    {
        if( is_object( $obj ) )
        {
            $this->objs[] = $obj; 
            return true;  
        }
        return false;

    }
    public function onCustomer(  $arr )
    {
        $arr['content']['path'] = $this->path;
        $arr['content']['ua'] = $_SERVER['HTTP_USER_AGENT'];

        foreach ( $this->objs as $obj )
        {
            $obj->onChanged( $this , $arr );
        }
    }
    /**
     * Render Json to front app
     *
     * @param $a
     */
    public function renderJson( $msg = '' ,$a = array()){
        header ("Content-type:application/json;charset=utf-8");
        $r['ret'] = 1;
        if( is_array( $a ) && empty($a) ){
            $r['data'] = (object)$a;
        }
        else{
            $r['data'] = $a;
        }
        $r['msg'] = $msg;
        echo json_encode($r , JSON_UNESCAPED_UNICODE);
        $this->_exit();
    }
    /**
     * Render Jsonp to front app
     *
     * @param $a
     */
    public function renderJsonp($a = array(),$callback)
    {
        header ("Content-type:application/json;charset=utf-8");
        $r['ret'] = 1;
        $r['data'] = $a;
        $json = json_encode($r);
        $jsoncallback = htmlspecialchars($callback);
        echo $jsoncallback.'('.$json.')';
        $this->_exit();
    }
    public function pagination( $total = 0 , $size = 10 , $page = 1 )
    {
        $arr= array();
        $arr['total'] = $total;
        $arr['size'] = $size;
        $arr['page_size'] = ceil($total/$size);
        $arr['page'] = $page;
        return $arr;
    }
    /**
     * reutrn json error
     *
     * @param $msg
     */
    public function renderError( $msg , $errCode = 0 )
    {
        header ("Content-type:application/json;charset=utf-8");
        $a['ret'] = 0;
        $a['msg'] = $msg.'('.$errCode.')';
        $a['errCode'] = $errCode;
        echo json_encode($a , JSON_UNESCAPED_UNICODE );
        $this->_exit();
    }
    /**
     * reutrn jsonp error
     *
     * @param $msg
     */
    public function renderErrorJsonp( $msg , $errCode = 0 ,$callback)
    {
        header ("Content-type:application/json;charset=utf-8");
        $a['ret'] = 0;
        $a['msg'] = $msg.'('.$errCode.')';
        $a['errCode'] = $errCode;
        $json = json_encode($a);
        $jsoncallback = htmlspecialchars($callback);
        echo $jsoncallback.'('.$json.')';
        $this->_exit();
    }
    /**
     * reutrn json error
     *
     * @param $msg
     */
    public function renderServerApiError( $msg , $errCode = 0 )
    {
        header ("Content-type:application/json;charset=utf-8");
        $a['ret'] = 0;
        $a['error']['msg'] = $msg.'('.$errCode.')';
        $a['error']['code'] = $errCode;
        echo json_encode($a , JSON_UNESCAPED_UNICODE);
        $this->_exit();
    }

    /**
     * reutrn json error
     *
     * @param $msg
     */
    public function renderErrorPage($msg)
    {
        $this->render('/site/error' , array('msg' => $msg));
        $this->_exit();
    }

	/**
     * 统一异常处理
	 * add by panzhiqi
	 */
	public function runAction($action) {
		try{
			parent::runAction($action);
		}
		catch (ServiceException $e){
			$this->renderError($e->getMessage());
		}
	}

    protected function beforeAction($action) {
        $this->params = $_REQUEST;
    	return true;
    }

    public  function  getRawData()
    {
    	if($this->forwardParams!=null)
    		return $this->forwardParams;
    	$method = Yii::app()->request->getRequestType();

    	$decode = false;
    	if ($method == 'POST') {
    		$postStr = file_get_contents("php://input");
    		$decode = true;
    	} else {
    		$postStr = $_GET;
    	}
    	if (empty($postStr)) {
    		return;
    		// return $this->renderError('缺少请求参数');
    	} else {
    		if ($decode) {
    			$postStr = json_decode((string)$postStr, true);
    			switch (json_last_error()) {
    				case JSON_ERROR_NONE:
    					break;
    				case JSON_ERROR_DEPTH:

    				case JSON_ERROR_CTRL_CHAR:

    				case JSON_ERROR_SYNTAX:

    				case JSON_ERROR_STATE_MISMATCH:

    				case JSON_ERROR_UTF8:

    				default:
    					throw new Exception('json格式转换错误');
    			}
    		}
    	}
    	return $postStr;
    }
}
