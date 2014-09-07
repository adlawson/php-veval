<?php
/*
 * This file is part of Veval
 *
 * Copyright (c) 2014 Andrew Lawson <http://adlawson.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Veval;

const SCHEME = \Veval::SCHEME;

/**
 * @param callable $fn
 */
function debug(callable $fn)
{
    return \Veval::debug($fn);
}

/**
 * @param string $dir
 */
function dump($dir)
{
    return \Veval::dump($dir);
}

/**
 * @param string $code
 * @param string $name
 */
function execute($code, $name = null)
{
    return \Veval::execute($code, $name);
}

/**
 * @return Iterator
 */
function iterator()
{
    return \Veval::iterator();
}
