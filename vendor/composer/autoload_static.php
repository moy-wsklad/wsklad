<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2133a5841b1b807bb9a6ffa345d49e43
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Wsklad\\' => 7,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Http\\Message\\' => 17,
        ),
        'M' => 
        array (
            'Monolog\\' => 8,
        ),
        'D' => 
        array (
            'Digiom\\Wotices\\' => 15,
            'Digiom\\Woplucore\\' => 17,
            'Digiom\\Woap\\' => 12,
            'Digiom\\Psr7wp\\' => 14,
            'Digiom\\ApiMoySklad\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Wsklad\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Monolog\\' => 
        array (
            0 => __DIR__ . '/..' . '/monolog/monolog/src/Monolog',
        ),
        'Digiom\\Wotices\\' => 
        array (
            0 => __DIR__ . '/..' . '/digiom/wotices/src',
        ),
        'Digiom\\Woplucore\\' => 
        array (
            0 => __DIR__ . '/..' . '/digiom/woplucore/src',
        ),
        'Digiom\\Woap\\' => 
        array (
            0 => __DIR__ . '/..' . '/digiom/woap/src',
        ),
        'Digiom\\Psr7wp\\' => 
        array (
            0 => __DIR__ . '/..' . '/digiom/psr7wp/src',
        ),
        'Digiom\\ApiMoySklad\\' => 
        array (
            0 => __DIR__ . '/..' . '/digiom/api-moysklad/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2133a5841b1b807bb9a6ffa345d49e43::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2133a5841b1b807bb9a6ffa345d49e43::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2133a5841b1b807bb9a6ffa345d49e43::$classMap;

        }, null, ClassLoader::class);
    }
}
