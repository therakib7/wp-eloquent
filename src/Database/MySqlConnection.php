<?php

namespace SoftTent\WpEloquent\Database;

use Doctrine\DBAL\Driver\PDOMySql\Driver as DoctrineDriver;
use SoftTent\WpEloquent\Database\Query\Grammars\MySqlGrammar as QueryGrammar;
use SoftTent\WpEloquent\Database\Query\Processors\MySqlProcessor;
use SoftTent\WpEloquent\Database\Schema\Grammars\MySqlGrammar as SchemaGrammar;
use SoftTent\WpEloquent\Database\Schema\MySqlBuilder;
use SoftTent\WpEloquent\Database\Schema\MySqlSchemaState;
use SoftTent\WpEloquent\Filesystem\Filesystem;
use PDO;

class MySqlConnection extends Connection
{
    /**
     * Determine if the connected database is a MariaDB database.
     *
     * @return bool
     */
    public function isMaria()
    {
        return strpos($this->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), 'MariaDB') !== false;
    }

    /**
     * Get the default query grammar instance.
     *
     * @return \SoftTent\WpEloquent\Database\Query\Grammars\MySqlGrammar
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \SoftTent\WpEloquent\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new MySqlBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \SoftTent\WpEloquent\Database\Schema\Grammars\MySqlGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the schema state for the connection.
     *
     * @param  \SoftTent\WpEloquent\Filesystem\Filesystem|null  $files
     * @param  callable|null  $processFactory
     * @return \SoftTent\WpEloquent\Database\Schema\MySqlSchemaState
     */
    public function getSchemaState(Filesystem $files = null, callable $processFactory = null)
    {
        return new MySqlSchemaState($this, $files, $processFactory);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \SoftTent\WpEloquent\Database\Query\Processors\MySqlProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new MySqlProcessor;
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOMySql\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver;
    }
}
