<?php
use OzdemirBurak\JsonCsv\File\Json;

function debug($variable)
{
	echo '<pre>';
	print_r($variable);
	echo '</pre>';
}

function arr_to_csv($arr, $nameFile = 'report')
{
    $json = json_encode($arr);
    file_put_contents(__DIR__ . '/public/reports/'.$nameFile.'.json', $json);
    $jsonConvert = new Json(__DIR__ . '/public/reports/'.$nameFile.'.json');
    $jsonConvert->setConversionKey('utf8_encoding', true);
    $jsonConvert->setConversionKey('delimiter', ';');
    $jsonConvert->convertAndDownload();
}