<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit743f61886443e483d71d66133cb63b55
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'FuzzyWuzzy\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'FuzzyWuzzy\\' => 
        array (
            0 => __DIR__ . '/..' . '/wyndow/fuzzywuzzy/lib',
        ),
    );

    public static $prefixesPsr0 = array (
        'D' => 
        array (
            'Diff' => 
            array (
                0 => __DIR__ . '/..' . '/phpspec/php-diff/lib',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit743f61886443e483d71d66133cb63b55::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit743f61886443e483d71d66133cb63b55::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit743f61886443e483d71d66133cb63b55::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit743f61886443e483d71d66133cb63b55::$classMap;

        }, null, ClassLoader::class);
    }
}
