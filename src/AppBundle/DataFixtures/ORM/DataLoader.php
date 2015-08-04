<?php

namespace AppBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

/**
 * Class DataLoader
 */
class DataLoader extends DataFixtureLoader
{
    /**
     * {@inheritdoc}
     */
    protected function getFixtures()
    {
        $fixtures = array(
            __DIR__ . '/article_categories.yml',
            __DIR__ . '/users.yml',
        );


        if ($this->container->get('kernel')->getEnvironment() != 'prod') {
            $fixtures[] = __DIR__ . '/articles.yml';

        }

        return  $fixtures;
    }
}
