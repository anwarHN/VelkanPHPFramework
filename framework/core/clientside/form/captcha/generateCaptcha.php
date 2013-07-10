<?php 
/**
 * Velkan PHP Framework
 * Generador de imagenes captcha para validaciones
 *
 * LICENCIA: Libre de uso.
 *
 * @author     Anwar Garcia <garciaanwar@gmail.com>
 * @copyright  2013 Anwar Garcia
 * @version    v1.0
 * @see https://github.com/Jontyy/PHP-Basic-MVC-Framework
 * @see http://www.youtube.com/watch?v=O3ogaH5AOOw
 */

$registry=registry::getInstance();

/*Se genera el codigo random*/
$ranStr = md5(microtime());
$ranStr = substr($ranStr, 0, 6);

/*Se asigna el valor a la variable de sesion*/
$_SESSION['captcha_code'] = $ranStr; 

/*Se obtienen los valores de alto y ancho*/
$width=(int)$registry->args["width"];
$height=(int)$registry->args["height"];
$renderDots=$registry->args["renderDots"];
$renderLines=$registry->args["renderLines"];


$image=@imagecreate($width,$height);

$background_color = imagecolorallocate($image, 255, 255, 255);

$text_color = imagecolorallocate($image, 20, 40, 100);

$noise_color = imagecolorallocate($image, 150, 120, 180);

/*Se generan puntos aleatorios para el fondo*/
if($renderDots=="true"){
	for( $i=0; $i<($width*$height)/3; $i++ ) {
		imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 1, 1, $noise_color);
	}
}
/*Se generan lineas aleatorias para el fondo*/
if($renderLines=="true"){
	for( $i=0; $i<($width*$height)/150; $i++ ) {
		imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
	}
}

$font=SITE_PATH."framework/core/clientside/form/captcha/fonts/".velkan::$config["captcha"]["font"];

$font_size=$height*0.50;
$textbox = imagettfbbox($font_size, 0, $font, $ranStr) or die('Error in imagettfbbox function');

$x = ($width - $textbox[4])/2;

$y = ($height - $textbox[5])/2;

imagettftext($image, $font_size, 0, $x, $y, $text_color, $font , $ranStr) or die('Error in imagettftext function');

header( "Content-type: image/jpeg" ); 

imagejpeg($image); 

?>