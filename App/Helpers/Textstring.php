<?php

namespace WPFP\App\Helpers;

class Textstring
{
	public function string_random($text = NULL, $limit = NULL)
	{
		// set vars
		$this->text = $text !== NULL && trim($text) !== '' ?
			trim($text) : '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$this->limit = $limit !== NULL && trim($limit) !== '' && is_numeric($limit) ?
			trim($limit) : '5';

		$this->textArray = str_split($this->text);
		$this->randomCount = count($this->textArray);
		$getTextRand = '';
		// array start from 0, need -1 
		$textLength = count($this->textArray) - 1;

		// set text rand 
		for ($i = 0; $i < $this->limit; $i++) {
			$splitNumber = rand(0, $textLength);
			$getTextRand = $getTextRand . $this->textArray[$splitNumber];
		}

		return $getTextRand;
	}

	public function string_replace($text = NULL, $option = NULL)
	{
		if ($text !== NULL && is_array($option) && $text !== NULL) {

			// set params	
			$param_repl = "";
			$param_repr = "";

			// get all usus comma
			foreach ($option as $getRepl => $getRepr) {
				$param_repl = "$param_repl," . trim($getRepl);
				$param_repr = "$param_repr," . trim($getRepr);
			}

			// to array string
			$param_repl = ltrim($param_repl, ', ');
			$param_repl = explode(',', $param_repl);

			$param_repr = ltrim($param_repr, ', ');
			$param_repr = explode(',', $param_repr);

			// replace string / text
			return str_replace($param_repl, $param_repr, $text);
		} else {
			return FALSE;
		}
	}

	public function word_limit($word = NULL, $limit = NULL)
	{
		// check word, limit
		if ($word !== NULL && trim($word) !== '') {

			$limit = $limit !== NULL && is_numeric($limit) ? trim($limit) : '5';
			$getPerWord = explode(' ', $word);
			$countWord = count($getPerWord);
			$counter = 1;
			$wordTemp = '';

			// counter limit
			for ($i = 0; $i < $countWord; $i++) {
				$wordGet = trim($getPerWord[$i]);

				if ($wordGet !== '') {

					$wordTemp = $wordTemp . ' ' . $wordGet;
					if ($counter >= $limit) break;
					$counter++;
				} else {
					// code is empty
				}
			}

			return $wordTemp;
		} else {
			return FALSE;
		}
	}

	public function to_object($dataArr = NULL)
	{
		if ($dataArr !== NULL) {

			// convert array to object 
			// json encode convert 
			$data = json_decode(json_encode($dataArr), false);
			return $data;
		} else {

			// array data not set
			return FALSE;
		}
	}
}
