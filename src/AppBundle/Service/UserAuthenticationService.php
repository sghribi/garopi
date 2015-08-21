<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * Class UserAuthenticationService
 */
class UserAuthenticationService implements UserProviderInterface
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param EntityManager $em
     * @param LdapService   $ldap
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($login)
    {
        return $this->userService->createOrUpdateUserByLogin($login);
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);

        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }

        return $this->userService->getUserByLogin($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
