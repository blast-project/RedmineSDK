<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\Redmine\SDK\Http\Result;

class ResultFactory
{
    public static function fromResponse($format, $dataKey, $response): Result
    {
        switch ($format) {
          case 'json':
              return  JsonResult::fromResponse($response, $dataKey, ['assoc' => true]);
          case 'csv':
              return  CsvResult::fromResponse($response, $dataKey,['delimiter' => ';', 'encodings' => ['LATIN1', 'UTF8']]);
          default:
              return  PlainResult::fromResponse($response, $dataKey);
      }
    }
}
