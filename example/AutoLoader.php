<?php
/**
 * Class AutoLoader
 * Reference: http://www.php.net/manual/en/function.spl-autoload-register.php#102180
 */
class AutoLoader
{
    private $_paths = array();
    private static $_instance = NULL;

    private function __construct()
    {
        // Nothing to see here.
    }

    public static function getInstance()
    {
        if(self::$_instance === NULL)
        {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function loader($className)
    {
        try
        {
            foreach($this->_paths as $path)
            {
                $pf = $path . strtr($className, '\\', DIRECTORY_SEPARATOR) . '.php';
                //echo 'Trying: '.$pf.'<br />';

                if(is_file($pf))
                {
                    return require_once $pf;
                }
            }

            throw new \Exception('Could not locate class: ' . $className);
        }
        catch(\Exception $e)
        {
            $backtrace = debug_backtrace();
            echo $e->getMessage();
            echo '<pre>';
            print_r( $backtrace );
            echo '</pre>';
            die();
        }
    }

    public function load()
    {
        spl_autoload_register(array($this, 'loader'));

        return $this;
    }

    public function registerPaths()
    {
        $this->_paths = func_get_args();

        return $this;
    }
}