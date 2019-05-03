<?php
$url = "http://192.168.100.17/blog/api/post.php?action=getPostList";
$response = file_get_contents($url);
echo $response;
?>