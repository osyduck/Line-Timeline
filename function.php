<?php
function save($filename, $content)
{
    $save = fopen($filename, "a");
    fputs($save, "$content\r\n");
    fclose($save);
}

function headernya($cookie)
{
    $str  = 'Host: timeline.line.me
Connection: keep-alive
Accept: application/json, text/plain, */*
X-Timeline-WebVersion: 1.10.3
X-Line-AcceptLanguage: en
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.186 Safari/537.36
Origin: https://timeline.line.me
Content-Type: application/json;charset=UTF-8
Referer: https://timeline.line.me/
Accept-Language: en-US,en;q=0.9
Cookie: ' . $cookie . '
';
    $head = explode("\n", $str);
    
    return $head;
}


function getTimeline()
{
    $head = headernya();
    $c    = curl_init("https://timeline.line.me/");
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $head);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    return $body;
}


function like($mid, $postid, $react = 0, $share)
{
    
    if ($react == 0) {
        $react = mt_rand(1, 6);
    }
    if ($share == true) {
        $share = true;
    } else {
        $share = false;
    }
    $head = headernya();
    $data = '{"contentId":"' . $postid . '","actorId":"' . $mid . '","likeType":"100' . $react . '","sharable":' . $share . '}';
    $c    = curl_init("https://timeline.line.me/api/like/create.json?sourceType=TIMELINE&homeId=" . $mid);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    curl_setopt($c, CURLOPT_POST, true);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $head);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body);
    return $json;
}

?>
