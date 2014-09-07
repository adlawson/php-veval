<?php
/*
 * This file is part of Veval
 *
 * Copyright (c) 2014 Andrew Lawson <http://adlawson.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use Vfs\FileSystem;
use Vfs\FileSystemRegistry;

class Veval
{
    const SCHEME = 'veval';

    /**
     * @param callable $fn
     */
    public static function debug(callable $fn)
    {
        foreach (self::iterator() as $name => $content) {
            call_user_func($fn, $name, $content);
        }
    }

    /**
     * @param string $dir
     */
    public static function dump($dir)
    {
        foreach (self::iterator() as $name => $content) {
            file_put_contents($dir . '/veval-' . $name . '.php', $content);
        }
    }

    /**
     * @param string $code
     * @param string $name
     */
    public static function execute($code, $name = null)
    {
        $fs  = self::getFileSystem();
        $url = self::getUrl($name ?: md5(mt_rand()));

        file_put_contents($url, $code);

        require $url;
    }

    /**
     * @return Iterator
     */
    public static function iterator()
    {
        $files = [];

        foreach (new DirectoryIterator(self::getUrl('')) as $file) {
            if ($file->isDot()) {
                continue;
            }

            $files[$file->getFileName()] = file_get_contents(self::getUrl($file->getFileName()));
        }

        return new ArrayIterator($files);
    }

    /**
     * @return FileSystem
     */
    protected static function getFileSystem()
    {
        $reg = FileSystemRegistry::getInstance();

        if (!$reg->has(self::SCHEME)) {
            FileSystem::factory(self::SCHEME);
        }

        return $reg->get(self::SCHEME);
    }

    /**
     * @param  string $path
     * @return string
     */
    protected static function getUrl($path)
    {
        return self::SCHEME . ':///' . $path;
    }
}
