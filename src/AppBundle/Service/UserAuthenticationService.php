<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * Class UserAuthenticationService
 */
class UserAuthenticationService extends EntityRepository implements UserProviderInterface
{
    /** @var EntityManager */
    protected $em;

    /** @var LdapService */
    protected $ldap;

    /**
     * @param EntityManager $em
     * @param LdapService   $ldap
     */
    public function __construct(EntityManager $em, LdapService $ldap)
    {
        $this->em = $em;
        $this->ldap = $ldap;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($login)
    {
        // On récupère l'objer Member à partir du CtiUid
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array('username' => $login));


        // S'il l'utilisateur n'existe pas en BDD : on le crée
        if (!$user) {
            $user = new User();
            $user->setUsername($login);
            $user->setEnabled(true);
        }

        //
        // On met à jour les données depuis le LDAP

        try {
            $datas = $this->ldap->getDataByUid($login);
            $user->setFirstName($datas['givenname'][0]);
            $user->setLastName($datas['sn'][0]);
            $user->setEmail($datas['mail'][0]);
            $user->setPlainPassword(md5(uniqid(rand(), true)));
            // $user->setPhoto(base64_encode($datas['jpegphoto'][0]));

        } catch (\Exception $e) {
            throw new UsernameNotFoundException(sprintf('Impossible de trouver %s dans le LDAP', $login));
        }


        $this->em->persist($user);
        $this->em->flush();

        return $user;
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

        return $this->em->getRepository('AppBundle:User')->find($user->getId());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class;
    }
}
