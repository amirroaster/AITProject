<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit341b649e6bde391d309171c003bb18e8
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit341b649e6bde391d309171c003bb18e8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit341b649e6bde391d309171c003bb18e8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}