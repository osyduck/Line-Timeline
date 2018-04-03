<?php
require("function.php");
$timeline = getTimeline();
$cookie   = 'cookiesmu';
$limit    = 10; //max 10 post
$react    = 0; // 1. love 2. haha 3. sip 4. terharu 5. kaget 6. cry 0. random

preg_match_all('~(href="/post/(.*?)")~', $timeline, $hasil);
if ($limit < 10) {
    $limit = 10;
}
for ($i = 0; $i < $limit; $i++) {
    $ex   = explode("/", $hasil[2][$i]);
    $mid  = $ex[0];
    $post = $ex[1];
    if (preg_match("/$post/", file_get_contents("dataline.txt"))) {
        echo "Already Reacted https://timeline.line.me/post/$mid/$post" . PHP_EOL;
    } else {
        $like = like($mid, $post);
        //print_r($like);
        if ($like->message == "success") {
            echo "Success React https://timeline.line.me/post/$mid/$post" . PHP_EOL;
            save("dataline.txt", $post);
        } else {
            echo "Failed" . PHP_EOL;
        }
    }
}

?>
