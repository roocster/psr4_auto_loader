<?php

use Rooc\PSR4AutoLoader\PSR4AutoLoader;

class PSR4AutoLoaderTest extends PHPUnit\Framework\TestCase
{
    /*
     * Examples of corresponding file path for a given
     * fully qualified class name, namespace prefix,
     * and base directory from
     * http://www.php-fig.org/psr/psr-4/
     */

    public function classNamesProvider()
    {
        return [
            [
                "\Acme\Log\Writer\File_Writer",
                "Acme\Log\Writer",
                "./acme-log-writer/lib/",
                "./acme-log-writer/lib/File_Writer.php"
            ],
            [
                "\Aura\Web\Response\Status",
                "Aura\Web",
                "/path/to/aura-web/src/",
                "/path/to/aura-web/src/Response/Status.php"
            ],
            [
                "\Symfony\Core\Request",
                "Symfony\Core",
                "./vendor/Symfony/Core/",
                "./vendor/Symfony/Core/Request.php"
            ],
            [
                "\Zend\Acl",
                "Zend",
                "/usr/includes/Zend/",
                "/usr/includes/Zend/Acl.php"
            ],
        ];
    }

    /**
     * @covers Rooc\PSR4AutoLoader\PSR4AutoLoader::getPath
     * @dataProvider classNamesProvider
     * 
     * @param type $className  Fully-qualified class name
     * @param type $prefix     Namespace prefix
     * @param type $basePath   Base directory
     * @param type $filePath   Resulting file path
     */
    public function testGetPath($className, $prefix, $basePath, $filePath)
    {
        // Replace slashes to OS defined DIRECTORY_SEPARATOR
        $filePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filePath);

        $classLoader = new PSR4AutoLoader($basePath, $prefix);
        $this->assertEquals($filePath, $classLoader->getPath($className));
    }
}
