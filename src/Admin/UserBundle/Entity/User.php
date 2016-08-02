<?php
/**
 * Created by PhpStorm.
 * User: kalyan
 * Date: 12/11/15
 * Time: 4:39 PM
 */

namespace Admin\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class User
 * @package Admin\UserBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="admins")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
