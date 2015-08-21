<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Class UserService
 * @package AppBundle\Service
 */
class UserService
{
    /** @var EntityManager */
    private $em;

    /** @var LdapService */
    private $ldap;

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
     * @param $login
     *
     * @return User
     */
    public function createOrUpdateUserByLogin($login)
    {
        // On récupère l'objer Member à partir du CtiUid
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(array('username' => $login));

        // S'il l'utilisateur n'existe pas en BDD : on le crée
        if (!$user) {
            $user = new User();
            $user->setUsername($login);
            $user->setEnabled(true);
        }

        // On met à jour les données depuis le LDAP
        try {
            $datas = $this->ldap->getDataByUid($login);
            $user->setFirstName($datas['givenname'][0]);
            $user->setLastName($datas['sn'][0]);
            $user->setEmail($datas['mail'][0]);
            $user->setPlainPassword(md5(uniqid(rand(), true)));
            $user->setPhoto(base64_encode($datas['jpegphoto'][0]));
        } catch (\Exception $e) {
            throw new UsernameNotFoundException(sprintf('Impossible de trouver %s dans le LDAP', $login));
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param string $login
     *
     * @return User
     */
    public function getUserByLogin($login)
    {
        return $this->em->getRepository('AppBundle:User')->findOneBy(array('username' => $login));
    }
}
