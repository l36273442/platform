<?php
class HeySkyApi
{
    const COMMAND = 'MT_REQUEST';
    public function __construct()
    {   
        $this->service_url = HEYSKY_API;
        $this->cpid = HEYSKY_CPID;
        $this->cppwd = HEYSKY_CPPWD;
    }
    static function extract_msgid($resp)
    {
        preg_match('/mtmsgid=(.*?)&/', $resp, $re);
        if (!empty($re) && count($re) >= 2)
            return $re[1];

        return "";
    }
    
    /*
     * @cpid string Api 帐号
     * @cppwd string Api 密码
     * @to  number  目的地号码，国家代码+手机号码（国家号码、手机号码均不能带开头的0）
     * @content string 短信内容
     *
     * @Return string 消息ID，如果消息ID为空，或者代码抛出异常，则是发送未成功。
    */
    public  function send( $to, $content )
    {
        $c = urlencode($content);
        // http接口，支持 https 访问，如有安全方面需求，可以访问 https开头
        $url = $this->service_url."/submit?command=".self::COMMAND."&cpid={$this->cpid}&cppwd={$this->cppwd}&da={$to}&sm={$c}";
        // 建议记录 $resp 到日志文件，$resp里有详细的出错信息
        try {
            
            $curl = curl_init();
            if( !$curl ){
                Yii::log('创建curl失败', CLogger::LEVEL_ERROR , 'system_error');
                return false;
            }

            curl_setopt($curl, CURLOPT_URL, $url );
            //设置头文件的信息作为数据流输出
            //curl_setopt($curl, CURLOPT_HEADER, 1);
            //设置获取的信息以文件流的形式返回，而不是直接输出。
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
            curl_setopt($curl, CURLOPT_TIMEOUT, 3);
            //curl_setopt($curl, CURLOPT_POST, 1);
            $d = curl_exec($curl);
            if( curl_errno($curl) ){
                throw new Exception(curl_error($curl)."(".curl_errno($curl).") ".$d);
                return false;
            }    
            curl_close($curl);
            $d = urldecode($d);
            parse_str($d,$data);
            if(  empty( $data ) || $data['mterrcode'] != '000'){

                throw new Exception( $d );
                return false;
            }    
            return $data;

        } catch(Exception $e){
            $mess = 'heyshy send sms to '.$to.' message '.$content.' fail '.$e->getMessage();
            Yii::log( $mess , CLogger::LEVEL_ERROR , 'system_error');
            return false;
        }
    }   
}
