<?php

namespace App\Support;

use setasign\Fpdi\Fpdi;

class CopladepPdf extends Fpdi
{
    protected function _parsepng($file)
    {
        $prefix = 'data:image/png;base64,';
        if (! str_starts_with($file, $prefix)) {
            return parent::_parsepng($file);
        }

        $png = base64_decode(substr($file, strlen($prefix)), true);
        if ($png === false) {
            $this->Error('Invalid PNG data');
        }

        $stream = fopen('php://memory', 'w+b');
        if ($stream === false) {
            $this->Error('Unable to create memory stream');
        }

        try {
            fwrite($stream, $png);
            rewind($stream);
            return $this->_parsepngstream($stream, 'QR COPLADEP');
        } finally {
            fclose($stream);
        }
    }
}
