<?php


//ob_start();//combo to fix disp img issue
//ob_clean();

//echo "The HBL challenge\n";
//echo "<br>";

$voucher[0] = "330442aeacc2aa10b6c2ad65d1420965900e2a6485b78cbd7ebaa31be4749f83";
$image[0] = "pikachu1";
$voucher[1] = "4c4e1a2adb25dfdde1425bc54941388d45af2897376cc809376d8d87fa566688";
$image[1] = "pikachu1";
$voucher[2] = "81886b133a5de1b38747fe5fab9032b6cfa5b2cea9c782e4d9ed56a18a1e55af";
$image[2] = "pikachu1";
$voucher[3] = "94f02d11d1ba9e5e9768cc1c9fa840c7958d77f644058a539bbd2e029d8fdd81";
$image[3] = "pikachu1";
$voucher[4] = "c320a7155251f1ee427b92b726ffa2ae1cc940b5c37b64c7667499c90bb814da";
$image[4] = "pikachu2";
$voucher[5] = "00799551b427adbe651f212360c7570b07ed8143f6d8b93bf4986961e021188b";
$image[5] = "pikachu2";
$voucher[6] = "1a7ed6ebdc5e74db59040ad3b7d16ed664cb018a74663814df973d2f9dd2830f";
$image[6] = "pikachu2";
$voucher[7] = "dc8ebaf8db0518543c8a8f6501e24b4e55680694e75aa2b2b9b86ab0890b115e";
$image[7] = "pikachu2";
$voucher[8] = "5a8b85fb8facf518edf68df04d762fdee5d643018c1de579bfd0e85b729d888e";
$image[8] = "pikachu2";
$voucher[9] = "7933671e7744bcedc6d5c9ed22a51b562ac022b90e11b4500f2a9533a9fd829b";
$image[9] = "pikachu0";



$imagename["pikachu2"] = "pikachu2.png";
$imagename["pikachu1"] = "pikachu1.png";
$imagename["pikachu0"] = "pikachu0.png";

$cookielife = 2678400;
$password = "0xdeadbeef";

// http://url/voucher.php?a=p1234567
//http://164.78.200.43/~teosj/hbl/voucher.php?a=p1234567


//test param passing
//echo "hi ";
//print_r($_GET);
     $numAdmin = $_GET['a'];//store param pass by url
	 //echo $numAdmin;
//echo " \r\n";
//echo "<br>";

//if($_GET["a"] === "") //echo "a is an empty string\n";
//if($_GET["a"] === false) //echo "a is false\n";
//if($_GET["a"] === null) //echo "a is null\n";
//if(isset($_GET["a"])) //echo "a is set\n";
//if(!empty($_GET["a"])) //echo "a is not empty";


//if(isset($_GET["a"]){
if(!empty($_GET["a"])){
     $numAdmin = $_GET['a'];//store param pass by url
	 //echo "you are ".$numAdmin." \r\n";
     //echo "<br>";
//http://164.78.200.43/~teosj/hbl/voucher.php?a=123

	//Do the cookie stuff
	$vnum = isset($_COOKIE['vnum']) ? $_COOKIE['vnum'] : 0;
	$date = isset($_COOKIE['date']) ? $_COOKIE['date'] : date('Ymd');
	if(isset($_COOKIE['hash']) && $_COOKIE['hash'] == md5($vnum.$password.$date)) {
		if($date < date('Ymd')) {
			$vnum++;
			if($vnum >= count($voucher)) $vnum = count($voucher)-1;
			//if($vnum >= count($voucher)){
			//$vnum = 4;
			//}
			$date = date('Ymd');	
		}
	}
	else {
		$vnum = 0;
		$date = date('Ymd');
	}
	setcookie("hash", md5($vnum.$password.$date), time()+$cookielife);
	setcookie("vnum", $vnum, time()+$cookielife);
	setcookie("date", $date, time()+$cookielife);
    setcookie("adminNumber", $numAdmin, time()+$cookielife);

	//Output the Image
	//$string = $voucher[$vnum];
	$string = md5($numAdmin.$password.$voucher[$vnum]);//unique hash sig as voucher code
	////echo "debug_msg ".$numAdmin.$password.$voucher[$vnum];
	////echo "<br>";
	//echo "your discount level ".$vnum;
	//echo "<br>";
	//echo "your discount secret code ".$string;
	//echo "<br>";
	
	////echo "debug_msg image name \n";
	////echo $image[$vnum];
	////echo "<br>";
	////echo "debug_msg image path \n";
	////echo $imagename[$image[$vnum]];
	////echo "<br>";

	//====img creation================
	header("Content-type: image/png");
	$im = @imagecreatefrompng($imagename[$image[$vnum]]);//no disp pic
    //$im = @imagecreatefrompng("http://164.78.200.43/~teosj/hbl/pikachu1.png");//no disp pic too
	//$im = imagecreatefrompng("pikachu2.png");
	if(!$im)
    {
	//echo "no generated image \n";
	//echo "<br>";
	}
	else{
		//echo "the generated image \n";
		//echo "<br>";
			
		$black = imagecolorallocate($im, 0, 0, 0);
	    $size = getimagesize($im);
	    $width = $size[0];
	    $px = ($width * strlen($string))/2;
		putenv('GDFONTPATH=' . realpath('.'));//path for font
		$font = 'arial.ttf';
		//imagettftext($im, 20, 0, 10, 20, $black, $font, $string);
		imagettftext($im, 18, 0, $px, 20, $black, $font, "you are ".$numAdmin);
		imagettftext($im, 18, 0, $px, 40, $black, $font, "your discount level ".$vnum);
		imagettftext($im, 18, 0, $px, 60, $black, $font, "your discount secret code ".$string);
		imagettftext($im, 28, 0, $px, 90, $black, $font, $string);
		//imagestring($im, 18, $px, 110, "you are ".$numAdmin, $black);
		//imagestring($im, 18, $px, 130, "your discount level ".$vnum, $black);
		//imagestring($im, 18, $px, 150, "your discount secret code ".$string, $black);
	    //imagestring($im, 28, $px, 170, $string, $black);
		imagepng($im);
		imagedestroy($im);
		}
	//=====img creation======

	}
	else if(!empty($_GET["v"])){
	//http://164.78.200.43/~teosj/hbl/voucher.php?v=e2c002c61f3f3b8b5232fb1f8ec711a5
	//$string = md5($numAdmin.$password.$voucher[$vnum]);//unique hash sig as voucher code
	//echo "enter discount code secret to verify \n";
	//echo "<br>";
	 $v1 = $_GET['v'];//store param pass by url

     $vnum = isset($_COOKIE['vnum']) ? $_COOKIE['vnum'] : 0;
	 $numAdmin = isset($_COOKIE['adminNumber']) ? $_COOKIE['adminNumber'] : 0;
	 $ori = md5($numAdmin.$password.$voucher[$vnum]);
	 /*
	 echo "your voucher claimed ".$v1;
	 echo "<br>";
	 echo "computed voucher ".$ori;
	 echo "<br>";
	 echo "debug_msg vnum ".$vnum;
	 echo "<br>";
	 echo "debug_msg voucher num ".$voucher[$vnum];
	 echo "<br>";
	 echo "debug_msg str".$numAdmin.$password.$voucher[$vnum];
	 echo "<br>";
	 */
	 if ($v1 == $ori){
	 ////echo "real deal \n";
	 ////echo "<br>";
	 //$im1 = imagecreatefrompng("http://164.78.200.43/~teosj/hbl/pikachu0.png");
		
		header("Content-type: image/png");
		$im1 = imagecreatefrompng("pikachu0.png");
		$black = imagecolorallocate($im1, 0, 0, 0);
	    $size1 = getimagesize($im1);
	    $width1 = $size1[0];
	    $px1 = ($width1 * strlen($ori))/2;
	    
		putenv('GDFONTPATH=' . realpath('.'));//path for font
		$font1 = 'arial.ttf';
		imagettftext($im1, 18, 0, $px1, 120, $black, $font1, "you are ".$numAdmin);
		imagettftext($im1, 18, 0, $px1, 140, $black, $font1, "your voucher claimed ".$v1);
		imagettftext($im1, 18, 0, $px1, 160, $black, $font1, "computed voucher ".$ori);
		imagettftext($im1, 28, 0, $px1, 190, $black, $font1, "real deal");
		
		
		/*
		//font size max 5pt
		imagestring($im, 18, $px, 170, $string, $black);
		imagestring($im1, 18, $px, 100, $v1, $black);
		imagestring($im1, 18, $px, 120, $ori, $black);
		imagestring($im1, 28, $px, 140, "real deal", $black);
		*/
		imagepng($im1);
		imagedestroy($im1);
		
	}
	 else{
	 //echo "please retry again \n";
	 //echo "<br>";
	 }
	}
	
	else{
		//echo "enter admin number\n";
		//echo "<br>";
	}


/*	
//worked	
header("Content-type: image/png");
////echo "<br>";//cannot put infront or after of header()
////http://stackoverflow.com/questions/3385982/the-image-cannot-be-displayed-because-it-contains-errors
$string = "e2c002c61f3f3b8b5232fb1f8ec711a5";
$im = imagecreatefrompng("pikachu2.png");
$black = imagecolorallocate($im, 0, 0, 0);
$size = getimagesize($im);
$width = $size[0];
//$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
$px = ($width * strlen($string))/2;
imagestring($im, 18, $px, 170, $string, $black);
imagepng($im);
imagedestroy($im);
*/
?>