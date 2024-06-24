<?php
require_once 'vendor/autoload.php';
$documento = new \PhpOffice\PhpWord\PhpWord();
$seccion = $documento->addSection();
$encabezado = array('size' => 16, 'bold' => true);
$seccion->addText('Listado', $encabezado);
$seccion->addTextBreak(1);
//
$header = $seccion->addHeader();
$header->addWatermark('img/logoPHP7marcaAgua.png', array('width'=>450));
$seccion->addText('The header reference to the current section includes a watermark image.');
// Guardar documento como OOXML file...
$salida = \PhpOffice\PhpWord\IOFactory::createWriter($documento, 'Word2007');
$salida->save('documento.docx');
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=documento.docx");
header("Content-Type: application/zip");
header("Content-Transfer-Encoding: binary");
readfile("documento.docx");
exit;