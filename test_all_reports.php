<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$sesion = App\Models\SesionCopladep::where('clave', '2026-segunda-ordinaria')->firstOrFail();

// Test 1: RegistroCopladepController@exportarPdf
echo "Testing RegistroCopladepController::exportarPdf...\n";
$regCtrl = app(App\Http\Controllers\RegistroCopladepController::class);
$responsePdf1 = $regCtrl->exportarPdf($sesion);
echo "Exportar PDF Registros: Status " . $responsePdf1->getStatusCode() . " | Bytes: " . strlen($responsePdf1->getContent()) . "\n";

// Test 2: InvitadoCopladepController@exportarAsistenciaPdf
echo "Testing InvitadoCopladepController::exportarAsistenciaPdf...\n";
$invCtrl = app(App\Http\Controllers\InvitadoCopladepController::class);
$responsePdf2 = $invCtrl->exportarAsistenciaPdf($sesion);
echo "Exportar PDF Asistencia: Status " . $responsePdf2->getStatusCode() . " | Bytes: " . strlen($responsePdf2->getContent()) . "\n";

// Test 3: InvitadoCopladepController@exportarAsistenciaExcel
echo "Testing InvitadoCopladepController::exportarAsistenciaExcel...\n";
$responseXls = $invCtrl->exportarAsistenciaExcel($sesion);
echo "Exportar Excel Asistencia: Class " . get_class($responseXls) . "\n";

echo "ALL CONTROLLER TESTS PASSED!\n";
