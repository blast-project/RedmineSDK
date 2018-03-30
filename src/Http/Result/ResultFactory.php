<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Http\Result;

use GuzzleHttp\Psr7\Response;

class ResultFactory
{
    public static function fromResponse(string $format, string $dataKey, Response $response, bool $isCollection = false): Result
    {
        switch ($format) {
          case 'json':
              return  JsonResult::fromResponse($response, $dataKey, ['collection'=>$isCollection, 'assoc' => true]);
          case 'csv':
              return  CsvResult::fromResponse($response, $dataKey, ['collection'=>$isCollection, 'delimiter' => ';', 'encodings' => ['LATIN1', 'UTF8']]);
          default:
              return  RawResult::fromResponse($response, $dataKey, ['collection'=>$isCollection]);
      }
    }
}
