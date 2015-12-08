<?php

   //生成验证码图片

    session_start();

        Header("Content-type: image/PNG"); 

  srand((double)microtime()*1000000); 

  $roundNum=rand(1000,9999);

  //把随机数存入session以便以后用

   $_SESSION["sessionRound"]=$roundNum;

        $im = imagecreate(48,20);

        $red = ImageColorAllocate($im, 255,255,255);
		
		$white = ImageColorAllocate($im, 255,255,255);

        $blue = ImageColorAllocate($im, 0,255,0);

 //局域填充，相当于背景

        imagefill($im,68,20,$blue);

   //将四位整数验证码绘入图片

        imagestring($im, 6, 5, 3, $roundNum, $blue);

        for($i=0;$i<50;$i++)   //加入干扰象素

        {

                imagesetpixel($im, rand()%70 , rand()%30 , $black);

        }

        ImagePNG($im);

        ImageDestroy($im);

?>