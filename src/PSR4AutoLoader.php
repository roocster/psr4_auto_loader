<?php
namespace Rooc\PSR4AutoLoader;

/**
 * Class ClassLoader
 * 
 * Implementation of the PSR-4 autoloading standard
 * http://www.php-fig.org/psr/psr-4/
 *
 * @version 2.0
 * 
 * @author  Ilya Rooc <roocster@gmail.com>
 * @license https://opensource.org/licenses/MIT MIT
 */
class PSR4AutoLoader
{

    public $namespaceSeparator = '\\';
    public $fileExtension = '.php';
    protected $basePath;
    protected $prefix;

    /**
     * ClassLoader constructor
     *
     * @param string|null $basePath  Base directory
     * @param string|null $prefix    Namespace prefix
     */
    public function __construct($basePath = null, $prefix = null)
    {
        $this->prefix = $prefix;

        // Replace slashes to OS defined DIRECTORY_SEPARATOR
        $this->basePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $basePath);

        // Make sure that base path contains trailing DIRECTORY_SEPARATOR
        $this->basePath = rtrim($this->basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Installs this class loader on the SPL autoload stack
     *
     * @return bool
     */
    public function register()
    {
        return spl_autoload_register([$this, 'load']);
    }

    /**
     * Uninstalls this class loader from the SPL autoloader stack
     * 
     * @return bool
     */
    public function unregister()
    {
        return spl_autoload_unregister([$this, 'load']);
    }

    /**
     * Removes namespace prefix from beginning of the fully-qualified class name
     *
     * @param string $className  Fully-qualified class name
     *
     * @return string
     */
    public function trimPrefix($className)
    {
        // Remove leading namespace separator
        $className = ltrim($className, $this->namespaceSeparator);

        if (!$this->prefix) {
            return $className;
        }

        $prefix = $this->prefix . $this->namespaceSeparator;

        // Remove namespace prefix if it present
        if (strpos($className, $prefix) === 0) {
            $className = substr($className, strlen($prefix));
        }

        return $className;
    }

    /**
     * Retrives namespace part from fully-qualified class name
     *
     * @param string $className   Fully-qualified class name
     * @param bool   $trimPrefix  If TRUE, returns namespace without prefix
     *
     * @return null|string
     */
    public function getNamespace($className, $trimPrefix = false)
    {
        // Remove prefix or leading namespace separator
        $className = $trimPrefix ? $this->trimPrefix($className) : ltrim($className, $this->namespaceSeparator);

        $namespace = null;

        // Remove class name
        if ($lastNsPos = strrpos($className, $this->namespaceSeparator)) {
            $namespace = substr($className, 0, $lastNsPos);
        }

        return $namespace;
    }

    /**
     * Retrives class name without namespace from fully-qualified class name
     *
     * @param string $className  Fully-qualified class name
     *
     * @return string
     */
    public function getClass($className)
    {
        // Remove leading namespace separator
        $className = ltrim($className, $this->namespaceSeparator);

        // Remove namespace
        if ($lastNsPos = strrpos($className, $this->namespaceSeparator)) {
            $className = substr($className, $lastNsPos + 1);
        }

        return $className;
    }

    /**
     * Retrives file path from fully-qualified class name
     *
     * @param $className  Fully-qualified class name
     *
     * @return string
     */
    public function getPath($className)
    {
        $fileName = $this->basePath;

        // Convert namespace to path
        if ($namespace = $this->getNamespace($className, true)) {
            $fileName .= str_replace($this->namespaceSeparator, DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= $this->getClass($className) . $this->fileExtension;

        return $fileName;
    }

    /**
     * Loads the given class, interface, trait, etc.
     *
     * @param $className  Fully-qualified class name
     */
    public function load($className)
    {
        require $this->getPath($className);
    }
}
