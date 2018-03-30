<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Http\Result;

class CsvResult extends Result
{
    protected function extractData($data)
    {
        $delimiter = $this->options['delimiter'];

        return array_map(function ($line) use ($delimiter) {
            return str_getcsv($line, $delimiter);
        }, explode("\n", $data));
    }
}
