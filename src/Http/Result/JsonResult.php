<?php

/*
 * Copyright (C) 2015-2018 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Http\Result;

class JsonResult extends Result
{
    protected function extractData($data)
    {
        return json_decode($data, $this->options['assoc'] ?? true);
    }
}
