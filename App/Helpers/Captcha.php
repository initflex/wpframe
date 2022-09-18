<?php

namespace WPFP\App\Helpers;

class Captcha
{
	public function create_captcha($option = NULL)
	{

		// set default options or user options
		$extention = $option !== NULL && isset($option['captcha_extension']) && trim($option['captcha_extension']) !== '' ?
			ltrim(trim($option['captcha_extension']), '.') : 'png';

		$dirloc = $option !== NULL && isset($option['dir_captcha']) && trim($option['dir_captcha']) !== '' && is_dir(trim($option['dir_captcha'])) !== FALSE ?
			trim($option['dir_captcha']) : './log/';

		$font = $option !== NULL && isset($option['font_file']) && trim($option['font_file']) !== '' ?
			trim($option['font_file']) : './public/fonts/FibelVienna/Fibel Vienna.ttf';

		$imgWidth = $option !== NULL && isset($option['img_width']) && trim($option['img_width']) !== '' ?
			trim($option['img_width']) : 200;

		$imgHeight = $option !== NULL && isset($option['img_height']) && trim($option['img_height']) !== '' ?
			trim($option['img_height']) : 100;

		$random_count = $option !== NULL && isset($option['limit_random']) && trim($option['limit_random']) !== '' ?
			trim($option['limit_random']) : 8;

		$fontSize = $option !== NULL && isset($option['font_size']) && trim($option['font_size']) !== '' ?
			trim($option['font_size']) : 30;

		$text = $option !== NULL && isset($option['text_random']) && trim($option['text_random']) !== '' ?
			trim($option['text_random']) : null;

		// color set from settings
		$tc = $option !== NULL && isset($option['text_color']) && trim($option['text_color']) !== '' ?
			explode(' ', $option['text_color']) : explode(' ', '87 132 53');

		$bg = $option !== NULL && isset($option['bg_color']) && trim($option['bg_color']) !== '' ?
			explode(' ', $option['bg_color']) : explode(' ', '224 224 224');

		$angle = $option !== NULL && isset($option['text_angle']) && trim($option['text_angle']) !== '' ?
			trim($option['text_angle']) : 0;


		function random_text($text, $randomCount)
		{
			$text = trim($text) !== '' ?
				$text : '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

			// string to array & set params
			$getArrayText = str_split($text);
			$getTextRand = '';
			// array start from 0, need -1 
			$textLength = count($getArrayText) - 1;

			// set text rand 
			for ($i = 0; $i < $randomCount; $i++) {
				$splitNumber = rand(0, $textLength);
				$getTextRand = $getTextRand . $getArrayText[$splitNumber];
			}

			return $getTextRand;
		}

		$text = random_text($text, $random_count);

		// create image
		$image = imagecreatetruecolor($imgWidth, $imgHeight);

		// add color to img & txt
		$imgColor = imagecolorallocate($image, $bg[0], $bg[1], $bg[2]);
		$textColor = imagecolorallocate($image, $tc[0], $tc[1], $tc[2]);

		// set position text angle, x pos, y pos
		// set x to center
		$a = $angle;
		$x = ($imgWidth / 2 / 4) - ($imgWidth / (strlen($text) * $fontSize));
		$y = ($imgHeight / 2) + ($fontSize / (100 / 47));

		// set image text
		imagefill($image, $x, $y, $imgColor);
		imagettftext($image, $fontSize, $a, $x, $y, $textColor, $font, $text);

		// check extesion
		/// create jpg or png
		// and return array data

		$createImgCaptcha = trim($extention) == 'jpeg' ?
			imagejpeg($image, $dirloc . $text . '.jpeg') :
			imagepng($image, $dirloc . $text . '.png');

		$extention = trim($extention) == 'jpeg' ? '.jpeg' : '.png';

		// set data Captcha
		$dataCaptcha = [
			'captcha_image'		=>	$dirloc . $text . $extention,
			'captcha_code'		=>	$text
		];

		return $dataCaptcha;
	}

	public function delete_captcha($imgCaptcha = NULL)
	{
		if ($imgCaptcha !== NULL && file_exists($imgCaptcha)) {
			// delete image captcha
			@unlink($imgCaptcha);
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
