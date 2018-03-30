<?php

/*
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU LGPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blast\RedmineSDK\Util;

class StringConverter
{
    public function fromSnakeCaseToCamelCase(string $string): string
    {
        return preg_replace_callback(
            '/(_\w)/',
            function ($m) { return strtoupper($m[0][1]); },
            $string
        );
    }

    public function fromCamelCaseToSnakeCase(string $string): string
    {
        return preg_replace_callback(
            '/(.?[A-Z])+/',
            function ($m) { return strtolower(strlen($m[0]) == 1 ? $m[0] : $m[0][0] . '_' . $m[0][1]); },
            $string
        );
    }
}
