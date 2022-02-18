<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab58faea8f4d9c477d655c5c0b2533fe
{
    public static $files = array (
        '9c67151ae59aff4788964ce8eb2a0f43' => __DIR__ . '/..' . '/clue/stream-filter/src/functions_include.php',
        '8cff32064859f4559445b89279f3199c' => __DIR__ . '/..' . '/php-http/message/src/filters.php',
        'a4a119a56e50fbb293281d9a48007e0e' => __DIR__ . '/..' . '/symfony/polyfill-php80/bootstrap.php',
        '1cb469636b58a9e8799397e88ac350f9' => __DIR__ . '/../..' . '/querycypher.php',
        'a83f61d6519f0a0350da39224f7682d7' => __DIR__ . '/../..' . '/graphs.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Polyfill\\Php80\\' => 23,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Http\\Client\\' => 16,
        ),
        'L' => 
        array (
            'Laudis\\TypedEnum\\' => 17,
            'Laudis\\Neo4j\\' => 13,
        ),
        'H' => 
        array (
            'Http\\Message\\' => 13,
            'Http\\Discovery\\' => 15,
        ),
        'C' => 
        array (
            'Clue\\StreamFilter\\' => 18,
        ),
        'B' => 
        array (
            'Bolt\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Polyfill\\Php80\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php80',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-factory/src',
            1 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-client/src',
        ),
        'Laudis\\TypedEnum\\' => 
        array (
            0 => __DIR__ . '/..' . '/laudis/typed-enum/src',
        ),
        'Laudis\\Neo4j\\' => 
        array (
            0 => __DIR__ . '/..' . '/laudis/neo4j-php-client/src',
        ),
        'Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/message/src',
            1 => __DIR__ . '/..' . '/php-http/message-factory/src',
        ),
        'Http\\Discovery\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/discovery/src',
        ),
        'Clue\\StreamFilter\\' => 
        array (
            0 => __DIR__ . '/..' . '/clue/stream-filter/src',
        ),
        'Bolt\\' => 
        array (
            0 => __DIR__ . '/..' . '/stefanak-michal/bolt/src',
        ),
    );

    public static $classMap = array (
        'App\\PrintString' => __DIR__ . '/../..' . '/App/PrintString.php',
        'App\\WikiKnowledgeGraph' => __DIR__ . '/../..' . '/App/WikiKnowledgeGraph.php',
        'Attribute' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Attribute.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Stringable' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/Stringable.php',
        'UnhandledMatchError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php',
        'ValueError' => __DIR__ . '/..' . '/symfony/polyfill-php80/Resources/stubs/ValueError.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab58faea8f4d9c477d655c5c0b2533fe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab58faea8f4d9c477d655c5c0b2533fe::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitab58faea8f4d9c477d655c5c0b2533fe::$classMap;

        }, null, ClassLoader::class);
    }
}
