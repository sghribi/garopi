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
        return  array(
            __DIR__ . '/article_categories.yml',
        );
    }
}
