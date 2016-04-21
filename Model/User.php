<?php

namespace PC\Aws4AuthBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * ORM\Entity(repositoryClass="PC\Aws4AuthBundle\Repository\AwsUserRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user")
 */
abstract class User implements UserInterface, AccessKeyableInterface
{
    protected $id;

    /**
     * @var string
     */
    protected $accessKeys;
}
