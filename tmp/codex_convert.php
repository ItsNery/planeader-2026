<?php
require 'vendor/autoload.php'; require 'tmp/codex-File.php';
$b=\PhpOffice\PhpSpreadsheet\IOFactory::load('tmp/codex-invitados.xls');
\PhpOffice\PhpSpreadsheet\IOFactory::createWriter($b,'Xlsx')->save('tmp/codex-invitados-base.xlsx');
foreach (['tmp/codex-invitados.xls','tmp/codex-clasificacion.xlsx'] as $i=>$file) {
 $s=\PhpOffice\PhpSpreadsheet\IOFactory::load($file)->getSheet(0);
 file_put_contents('tmp/codex-rows-'.$i.'.json', json_encode($s->toArray(null,true,true,false),JSON_UNESCAPED_UNICODE));
}
