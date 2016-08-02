<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 09.01.16
 * Time: 15:08
 */

namespace Admin\DashBoardBundle\Twig;

use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Twig\AppVariable;

/**
 * Class UserExtension
 * @package Admin\DashBoardBundle\Twig
 */
class UserExtension extends \Twig_Extension
{
    private $em;

    /**
     * UserExtension constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('countUsers', array($this, 'getCountUsers')),
        );
    }

    /**
     * @param AppVariable $app
     * @return mixed
     */
    public function getCountUsers(AppVariable $app)
    {
        $qb = $this->em->getRepository('UserBundle:User')->createQueryBuilder('u');
        $qb
            ->select('COUNT(u.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_count_extension';
    }
}
