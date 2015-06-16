<?php
ini_set('date.timezone', 'Asia/Shanghai'); // 不设置这条会老提示date警告
set_time_limit(0);
include_once 'jsys2.php';

// 写日志 $mode='a'为追加,='w'为重新写入
function writeLogFile ($file, $str, $mode = 'a')
{
    $oldmask = @umask(0);
    $fp = @fopen($file, $mode);
    @flock($fp, 3);
    if (! $fp)
    {
        Return false;
    } else
    {
        @fwrite($fp, date("m-d h:i:s") . '  ' . $str . "\r\n");
        @fclose($fp);
        @umask($oldmask);
        Return true;
    }
}

function mlog ($old, $s) // $old没使用,懒得改了
{
    writeLogFile('c:\log.txt', $s);
}

mlog('log.txt', 'a.php运行了');

// define('HOST', 'localhost');
define('PORT', 8081);

// 初始化主socket
$master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if (! $master)
{
    mlog('log.txt', '主socket创建失败');
    exit();
}

socket_set_option($master, SOL_SOCKET, SO_REUSEADDR, 1);
$ret = socket_bind($master, '0.0.0.0', PORT);
if ($ret)
{
    mlog('log.txt', '端口绑定成功' . PORT);
} else
{
    mlog('log.txt', '端口绑定失败' . PORT);
    exit();
}

if (! socket_listen($master, 20))
{
    mlog('log.txt', 'socket侦听失败,退出');
    exit();
}
mlog('log.txt', '主socket创建成功,开始侦听');

$lstClient = array(); // 所有已验证的客户端
$sockets = array(
        $master
); // 所有新连接
function IsStartTime ()
{
    static $yjfsstart = 0;
    $nowtime = date("s");
    if ($nowtime < 40)
    {
        if ($yjfsstart != 1)
        {
            $yjfsstart = 1;
            initnew();
            return 1;
        }
    } else
    {
        if ($yjfsstart == 1)
            $yjfsstart = 0;
    }
    return 0;
}

function IsKjTime ()
{
    static $yjfskj = 0;
    $nowtime = date("s");
    if ($nowtime < 47)
    {
        if ($yjfskj == 1)
        {
            $yjfskj = 0;
        }
    } else 
        if ($yjfskj == 0)
        {
            $yjfskj = 1;
            
            return CalCKJ();
        }
    return 0;
}

do
{
    usleep(10000);
    
    $changed = $lstClient;
    $write = null;
    $except = null;
    if (count($changed) > 0 && socket_select($changed, $write, $except, 0) > 0)
    {
        foreach ($changed as $username => $usersock)
        {
            $data = @socket_read($usersock, 1024);
            if (!$data) // 如果断开
            {
                socket_close($usersock);
                $key = array_search($usersock, $lstClient);
                unset($lstClient[$key]);
                continue;
            }
            $data = trim($data);
            
            // mlog('log.txt', '收到投注--' . $data);
            $xml = simplexml_load_string($data);
            if ($xml === false)
            {
                socket_close($usersock);
                $key = array_search($usersock, $lstClient);
                unset($lstClient[$key]);
                continue;
            }
            
            $tmp = $xml->attributes();
            $type = (string) $tmp['type'];
            
            if ($type == 'TouZhu')
            {
                $arr = array();
                foreach ($xml->children() as $dw)
                {
                    $tmp = $dw->attributes();
                    $key = (string) $tmp['type'];
                    $val = (string) $tmp['jine'];
                    $arr[$key] = $val;
                }
                WriteTouZhu($username, $arr);
            }
        }
    }
    
    if (IsKjTime() == 1) // 如果到了开奖时间
    {
        // mlog('log.txt', '发送开奖结果');
        foreach ($lstClient as $username => $usersock)
        {
            $kjhm = GetKJHM();
            $zje = GetUserZJE($username);
            $zjje = GetUserZJJE($username);
            // -----------------------------------
            // $kjhm = 5;
            // $zje = 1000;
            // $zjje = 10;
            
            // 根节点
            $dom = new DomDocument();
            $smsg = $dom->createElement('SMSG');
            $dom->appendChild($smsg);
            // type属性
            $type = $dom->createAttribute('type');
            $typeval = $dom->createTextNode('JieGuo');
            $type->appendChild($typeval);
            $smsg->appendChild($type);
            // 总金额
            $nodezje = $dom->createElement('ZhongJinE');
            $nodezje->appendChild($dom->createTextNode($zje));
            $smsg->appendChild($nodezje);
            // 当期中奖金额
            $nodezjje = $dom->createElement('ZhongJiangJinE');
            $nodezjje->appendChild($dom->createTextNode($zjje));
            $smsg->appendChild($nodezjje);
            // 开奖号码
            $nodekjhm = $dom->createElement('KaiJiangHaoMa');
            $nodekjhm->appendChild($dom->createTextNode($kjhm));
            $smsg->appendChild($nodekjhm);
            
            // 发送
            $retxml = $dom->saveXML();
            socket_write($usersock, $retxml, strlen($retxml));
            // mlog('log.txt', $retxml);
        }
    }
    
    if (IsStartTime() == 1) // 如果到了每局开始的时间
    {
        
        // mlog('log.txt', '发送开局信息');
        foreach ($lstClient as $username => $usersock)
        {
            $zje = GetUserZJE($username);
            $timeleft = GetTimeLeft();
            $speilv = GetPeiLv();
            
            // 调试------------
            // $zje = 1000;
            // $timeleft = 40;
            // $speilv = "1 2 3 4 10 20 30 40";
            // --------------
            
            // 根节点
            $dom = new DomDocument();
            $smsg = $dom->createElement('SMSG');
            $dom->appendChild($smsg);
            // type属性
            $type = $dom->createAttribute('type');
            $typeval = $dom->createTextNode('StartInfo');
            $type->appendChild($typeval);
            $smsg->appendChild($type);
            // 期号
            // $nodeqihao = $dom->createElement('QiHao');
            // $nodeqihao->appendChild($dom->createTextNode($qihao));
            // $smsg->appendChild($nodeqihao);
            // 总金额
            $nodezje = $dom->createElement('ZhongJinE');
            $nodezje->appendChild($dom->createTextNode($zje));
            $smsg->appendChild($nodezje);
            // 倒计时
            $nodetimeleft = $dom->createElement('TimeLeft');
            $nodetimeleft->appendChild($dom->createTextNode($timeleft));
            $smsg->appendChild($nodetimeleft);
            
            // 赔率字符串
            $nodepeilv = $dom->createElement('PeiLv');
            $nodepeilv->appendChild($dom->createTextNode($speilv));
            $smsg->appendChild($nodepeilv);
            
            // 发送
            $retxml = $dom->saveXML();
            socket_write($usersock, $retxml, strlen($retxml));
            mlog('log.txt', $retxml);
        }
    }
    
    $changed = $sockets;
    if (socket_select($changed, $write, $except, 0) < 1) // tv_sec=0为立即返回,NULL为阻塞,
        continue; // 返回值=0为超时,返回 false为出错,成功返回有动作的连接数
    
    if (in_array($master, $changed))
    {
        // 接收用户连接
        // mlog('log.txt', '接收连接....');
        $newsock = socket_accept($master);
        if ($newsock === false)
        {
            mlog('log.txt', '接收连接失败');
        } else
        {
            array_push($sockets, $newsock);
            mlog('log.txt', '接收连接成功');
        }
        $key = array_search($master, $changed);
        unset($changed[$key]);
    }
    // 处理所有已连接但未验证的客户端,这里只会是请求安全策略文件和发送来的验证消息
    foreach ($changed as $unknowsock)
    {
        
        $data = @socket_read($unknowsock, 1024);
        if ($data)
        {
            
            $data = trim($data);
            if ($data == '<policy-file-request/>')
            {
                $policy = <<<XML
                <cross-domain-policy>  
                <allow-access-from domain="*" to-ports="8081" />  
                </cross-domain-policy>         
XML;
                socket_write($unknowsock, $policy, strlen($policy));
                // mlog('log.txt', '返回了安全策略文件');
            } else // 验证消息
            {
                $xml = @simplexml_load_string($data);
                if ($xml === false)
                {} else // 有效的XML
                {
                    // 提取出用户名密码
                    $att = $xml->attributes();
                    $type = $att['type'];
                    if ($type == 'UserNamePassword')
                    {
                        $name = (string) $xml->UsenName[0];
                        $pwd = (string) $xml->Password[0];
                        
                        if (CheckUserInfo($name, $pwd))
                        {
                            if (isset($lstClient[$name]))
                            {
                                socket_close($lstClient[$name]);
                            }
                            $lstClient[$name] = $unknowsock;
                            $key = array_search($unknowsock, $sockets);
                            unset($sockets[$key]);
                            mlog('log.txt', '用户已验证=' . $name);
                            continue;
                        }
                    }
                }
            }
        }
        $key = array_search($unknowsock, $sockets);
        socket_close($unknowsock);
        unset($sockets[$key]);
    }
} while (true);
?>