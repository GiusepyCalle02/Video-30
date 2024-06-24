<?php
require_once 'vendor/autoload.php';
$documento = new \PhpOffice\PhpWord\PhpWord();
$seccion = $documento->addSection();
$seccion->getStyle()->setPageNumberingStart(1);
$encabezado = array('size' => 16, 'bold' => true);
$seccion->addText('Listado', $encabezado);
$seccion->addTextBreak(1);
//Creamos el header
$header = $seccion->addHeader();
$header->addWatermark('img/logoPHP7marcaAgua.png', array('width'=>450));
//Estilo de tabla
$tableStyle = array(
	'borderSize' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(.02),
	'borderColor' => 'gray', //color del borde
	'cellMargin' => 80, //margen de la celda 
	'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER, 
	'cellSpacing' => 25);

$documento->addTableStyle(
	"tablaEstilo", 
	$tableStyle);

$seccion->addImage("img/PHP7-3202-SimpleXML.png",
	array(
		'width' => 400, 
		'height' => 235, 
		'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
	)
);
$seccion->addText("Imagen: 2.1.");
$seccion->addTextBreak(1);

$table = $seccion->addTable("tablaEstilo");
//
//Lee el archivo para ser listado
//
$archivoID = fopen("documento.php", "r");
$i = 0;
$c = array();
while(!feof($archivoID)){
	//1024 es 1 k o hasta encontrar \n o \r
	$linea = fgets($archivoID, 1024);
	$c[] = htmlentities($linea);
	//&lt; <
} //llaves
//
foreach ($c as $value) {
	//if ($i>0) {
		$table->addRow();
	    $table->addCell(300)->addText($i+1);
	    $table->addCell(10000)->addText($c[$i]);
	//}
	$i++;
	if($i>=count($c)) break;
}
//
fclose($archivoID);
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