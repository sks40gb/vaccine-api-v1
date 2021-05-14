<?php

namespace Foundation;

// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Ziletech\Database\DAO\DAOFactory;

class DatabaseServiceProvider implements ServiceProviderInterface {

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple) {
        $pimple['daoFactory'] = function (ContainerInterface $c) {
            $isDevMode = true;
            $config = Setup ::createAnnotationMetadataConfiguration(array(__DIR__), TRUE);
            $dbConfig = $c->get('settings')["database"];
            $dbParams = array(
                'driver' => $dbConfig["driver"],
                'host' => $dbConfig["host"],
                'port' => $dbConfig["port"],
                'user' => $dbConfig["username"],
                'password' => $dbConfig["password"],
                'dbname' => $dbConfig["database"],
            );
            $entityManager = EntityManager::create($dbParams, $config);
            $platform = $entityManager->getConnection()->getDatabasePlatform();
            $platform->registerDoctrineTypeMapping('enum', 'string');

            return new DAOFactory($entityManager);
        };
    }

}
