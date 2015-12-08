<?php
/**
* @version 1.0
* @author   Ben
* @date 2008-1-30
* @email jinmaodao116@163.com
* @��֤���ļ���
* int function imagecolorallocate(resource image, int red, int green, int blue) //Ϊһ��ͼ�������ɫ
* bool function imagefilledrectangle(resource image, int x1, int y1, int x2, int y2, int color) //��һ���β����
* bool function imagerectangle(resource image, int x1, int y1, int x2, int y2, int col)   //��һ������
* bool function imagesetpixel(resource image, int x, int y, int color)   //��һ����һ����
*/
class ValidationCode
{
private $width,$height,$codenum;
public $checkcode;     //��������֤��
private $checkimage;    //��֤��ͼƬ 
private $disturbColor = ''; //��������
/*
* ����������ȣ��߶ȣ��ַ�������
*/
function __construct($width='80',$height='20',$codenum='4')
{
   $this->width=$width;
   $this->height=$height;
   $this->codenum=$codenum;
}
function outImg()
{
   //���ͷ
   $this->outFileHeader();
   //������֤��
   $this->createCode();

   //����ͼƬ
   $this->createImage();
   //���ø�������
   $this->setDisturbColor();
   //��ͼƬ��д��֤��
   $this->writeCheckCodeToImage();
   imagepng($this->checkimage);
   imagedestroy($this->checkimage);
}
/*
   * @brief ���ͷ
   */
private function outFileHeader()
{
   header ("Content-type: image/png");
}
/**
   * ������֤��
   */
private function createCode()
{
   $this->checkcode = strtoupper(substr(rand(10000,99999),0,$this->codenum));
}
/**
   * ������֤��ͼƬ
   */
private function createImage()
{
   $this->checkimage = @imagecreate($this->width,$this->height);
   $back = imagecolorallocate($this->checkimage,255,255,255); 
   $border = imagecolorallocate($this->checkimage,0,0,0);  
   imagefilledrectangle($this->checkimage,0,0,$this->width - 1,$this->height - 1,$back); // ��ɫ��
   imagerectangle($this->checkimage,0,0,$this->width - 1,$this->height - 1,$border);   // ��ɫ�߿�
}
/**
   * ����ͼƬ�ĸ������� 
   */
private function setDisturbColor()
{
   for ($i=0;$i<=200;$i++)
   {
    $this->disturbColor = imagecolorallocate($this->checkimage, rand(0,255), rand(0,255), rand(0,255));
    imagesetpixel($this->checkimage,rand(2,128),rand(2,38),$this->disturbColor);
   }
}
/**
   *
   * ����֤��ͼƬ�����������֤��
   *
   */
private function writeCheckCodeToImage()
{
   for ($i=0;$i<=$this->codenum;$i++)
   {
    $bg_color = imagecolorallocate ($this->checkimage, rand(0,255), rand(0,128), rand(0,255));
    $x = floor($this->width/$this->codenum)*$i+5;
    $y = rand(0,$this->height-15);
    imagechar ($this->checkimage, rand(25,30), $x, $y, $this->checkcode[$i], $bg_color);
   }
}
function __destruct()
{
   unset($this->width,$this->height,$this->codenum);
}
}
?>
