<?php

// github项目 setting/webhok 中的secret,可以自定义
$secret = "autoploy";

// $path 您的站点目录
$path = "/www/wwwroot/autoploy.52kaifa.top";

// 从github交付的标题
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if($signature) {
	$hash = "sha1=". hash_hmac('sha1', file_get_contents("php://input"), $secret);
	if(strcmp($signature, $hash) == 0 ) {
		echo shell_exec("cd {$path} && /usr/bin/git reset --hard origin/main && /usr/bin/git clean -f && /usr/bin/git pull 2>&1");
		exit();
	}
}

http_response_code(404);
?>
