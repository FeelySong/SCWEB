<?php
    try{
        header("Content-type:text/html; charset=gb2312");
        ini_set("soap.wsdl_cache_enabled","0");
        $Mer_code="000015";
        $Mer_key="GDgLwwdK270Qj1w4xho8lyTpRQZV9Jm5x4NwWOTThUa4fMhEBK9jOXFrKRT6xhlJuU2FEa89ov0ryyjfJuuPkcGzO5CeVx5ZIrkkt1aBlZV36ySvHOMcNv8rncRiy3DQ";
        $SignMD5=md5($Mer_code.$Mer_key);
        $client = new SoapClient('https://webservice.ips.net.cn/web/Service.asmx?wsdl');
        class param
        {
            public $Mercode;
            public $SignMD5;
            public function __construct($Mer_code,$SignMd5) {
                $this->Mercode=$Mer_code;
                $this->SignMD5=$SignMd5;      
            }
        }
        $p=new param($Mer_code,$SignMD5);
        $res=$client->__soapCall('GetBankList',array($p));
        $arr=explode('#',urldecode($res->GetBankListResult));
        print_r($arr);
    }catch(SoapFault $e){
        echo $e->getMessage();
    }catch(Exception $e){
        echo $e->getMessage();
    }
?>