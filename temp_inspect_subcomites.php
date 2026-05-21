<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Subcomite::with('planestatal')->limit(20)->get() as $sub) {
    echo $sub->nombre . ' => ' . ($sub->planestatal ? $sub->planestatal->nombre : 'NULL') . PHP_EOL;
}
