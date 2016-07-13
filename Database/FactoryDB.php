<?
/*
 *  Factory DataBase
 * author: Vitaut Hryharovich, Joomla Framework 11
 */
class FactoryDB
{
    /**
     * Contains the current Factory instance
     *
     * @var    DatabaseFactory
     * @since  1.0
     */
    private static $instance = null;

    /**
     * Method to return a Driver instance based on the given options. There are three global options and then
     * the rest are specific to the database driver. The 'database' option determines which database is to
     * be used for the connection. The 'select' option determines whether the connector should automatically select
     * the chosen database.
     *
     * Instances are unique to the given options and new objects are only created when a unique options array is
     * passed into the method.  This ensures that we don't end up with unnecessary database connection resources.
     *
     * @param   string  $name     Name of the database driver you'd like to instantiate
     * @param   array   $options  Parameters to be passed to the database driver.
     *
     * @return  DatabaseDriver  A database driver object.
     *
     * @since   1.0
     * @throws  \RuntimeException
     */
    public function getDriver($driver, $options)
    {


        // Derive the class name from the driver.
        $class = ucfirst($driver).'Driver';
        Factory::import('Database/'.ucfirst($driver).'/', $driver.'Driver');
        // If the class still doesn't exist we have nothing left to do but throw an exception.  We did our best.
        if (!class_exists($class))
        {
            throw new \RuntimeException(sprintf('Unable to load Database Driver: %s',$driver));
        }
        // Create our new Driver connector based on the options given.
        try
        {

            $instance = new $class($options);
        }
        catch (\RuntimeException $e)
        {
            throw new \RuntimeException(sprintf('Unable to connect to the Database: %s', $e->getMessage()));
        }
        return $instance;
    }
    /**
     * Gets an instance of the factory object.
     *
     * @return  FactoryDB
     *
     * @since   1.0
     */
    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::setInstance(new self);
        }
        return self::$instance;
    }


    /**
     * Gets an instance of a factory object to return on subsequent calls of getInstance.
     *
     * @param   FactoryDB  $instance  A Factory object.
     *
     * @return  void
     *
     * @since   1.0
     */
    public static function setInstance(FactoryDB $instance = null)
    {
        self::$instance = $instance;
    }
}