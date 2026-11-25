<?php
require 'vendor/autoload.php'; require 'tmp/codex-File.php';
foreach (array_slice($argv,1) as $file) {
 $b=\PhpOffice\PhpSpreadsheet\IOFactory::load($file);
 echo basename($file), "\n";
 foreach($b->getWorksheetIterator() as $s) {
  echo 'SHEET ', $s->getTitle(), ' ', $s->getHighestDataRow(), 'x', $s->getHighestDataColumn(), "\n";
  for($r=1;$r<=min(12,$s->getHighestDataRow());$r++) echo json_encode($s->rangeToArray('A'.$r.':'.$s->getHighestDataColumn().$r,null,true,true,false)[0],JSON_UNESCAPED_UNICODE),"\n";
 }
}

