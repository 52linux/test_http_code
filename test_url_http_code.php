<?php
function get_header($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
    $header = array('User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.131 Safari/537.36');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_HEADER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); 
    curl_setopt($ch, CURLOPT_HEADER, 1); //返回response头部信息
    curl_setopt($ch, CURLINFO_HEADER_OUT, 1); //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header
    curl_setopt($ch, CURLOPT_URL, $url);
    $result = curl_exec($ch);
    $resp_header = curl_getinfo($ch, CURLINFO_HTTP_CODE); //官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看
    curl_close($ch);
    return $resp_header;
}


if(isset($_GET["ajax_check"]))
{
	if(get_header($_GET["url"]) == 200)
	{
		echo json_encode(array("status"=>"200","id"=>$_GET["id"]));
	}else { 
	 	echo json_encode(array("status"=>"999","id"=>$_GET["id"]));
	}
	
	die();
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>zjpro</title>
    <script >
    	

	//在页面未加载完毕之前显示的loading Html自定义内容
	var _LoadingHtml = '<div id="loadingDiv" style="display: none; "><div id="over" style=" position: absolute;top: 0;left: 0; width: 100%;height: 100%; background-color: #f5f5f5;opacity:0.5;z-index: 1000;"></div><div id="layout" style="position: absolute;top: 40%; left: 40%;width: 20%; height: 20%;  z-index: 1001;text-align:center;"><img src="loading.gif" /></div></div>';
	//呈现loading效果
	document.write(_LoadingHtml);

	//移除loading效果
	function completeLoading() {  
			document.getElementById("loadingDiv").style.display="none";
	}
	//展示loading效果http://localhost:2006/
	function showLoading()
	{
	document.getElementById("loadingDiv").style.display="block";
	}

    </script>
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>


	<script> 
		showLoading();
		window.onload=function()
		{
			//completeLoading();
		};
	</script>
	

</head>
<body >
	 
	<h1 id="h1">正在检测最佳线路</h1>

 <script type="text/javascript">
 	var obj = ["http://www.bbafasdfasbb.com","http://test.phpsir.com/php.php","http://test.phpsir.com/"];
    var myurl = false;
	for (var prop in obj) {
		// console.log(   prop  );
 
  		$.ajax({
			url:"?ajax_check=1&id="+prop+"&url="+obj[prop], 
			async : true,
			dataType: "json", 
			success:function(result){
   
	 				
				//console.log(   result  );
				console.log(   obj[result['id']] + "  "  + result.status + " " + result.id );
				 
				 
				if( result['status'] == "200")
				{
					 
					 if(!myurl) { 
					 	setTimeout(function(){completeLoading()},2000);
						myurl =  obj[result['id']]; 
						console.log(  "-----200------" + myurl );
						$("#h1").html("跳转到" + myurl );
						//top.location.href=myurl;
					 }
				}else{
					//console.log("-----999------"  + obj[result['id']] );
				}
				  
		    	}});

 	}
		/*
		 setTimeout( function(){ 
		 					if(!myurl) { myurl = obj[0];}
		 					console.log("last " + myurl ); 
		 					top.location.href=myurl;
		 					}, 10000);
		 */
		
 </script>
</body>
</html>