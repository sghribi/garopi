<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
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
            __DIR__ . '/horoscopes.yml',
        );

        return  $fixtures;
    }

    public function load(ObjectManager $manager)
    {
        parent::load($manager);

        $manager->getConnection()->exec('INSERT INTO classification__context (id, name, enabled, created_at, updated_at) VALUES (\'default\', \'Default\', true, NOW(), NOW());');
        $manager->getConnection()->exec('INSERT INTO classification__category (id, parent_id, context, name, enabled, slug, description, position, created_at, updated_at, media_id) VALUES (1, NULL, \'default\', \'Root\', true, \'root\', NULL, 1, NOW(), NOW(), NULL);');
    }
}
