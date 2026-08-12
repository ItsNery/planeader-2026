<?php

return [
    // Add institutional holidays as comma-separated dates in AGENDA_FESTIVOS.
    'festivos_adicionales' => array_values(array_filter(array_map(
        'trim',
        explode(',', env('AGENDA_FESTIVOS', ''))
    ))),
];
