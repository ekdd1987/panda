<?php

   //������֤��ͼƬ

    session_start();

        Header("Content-type: image/PNG"); 

  srand((double)microtime()*1000000); 

  $roundNum=rand(1000,9999);

  //�����������session�Ա��Ժ���

   $_SESSION["sessionRound"]=$roundNum;

        $im = imagecreate(48,20);

        $red = ImageColorAllocate($im, 255,255,255);
		
		$white = ImageColorAllocate($im, 255,255,255);

        $blue = ImageColorAllocate($im, 0,255,0);

 //������䣬�൱�ڱ���

        imagefill($im,68,20,$blue);

   //����λ������֤�����ͼƬ

        imagestring($im, 6, 5, 3, $roundNum, $blue);

        for($i=0;$i<50;$i++)   //�����������

        {

                imagesetpixel($im, rand()%70 , rand()%30 , $black);

        }

        ImagePNG($im);

        ImageDestroy($im);

?>