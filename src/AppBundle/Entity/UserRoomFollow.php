<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRoomFollow
 *
 * @ORM\Table(name="user_room_follow")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRoomFollowRepository")
 */
class UserRoomFollow
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="UserRoomFollow")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="UserRoomFollow")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $room;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return UserRoomFollow
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return UserRoomFollow
     */
    public function setRoom(\AppBundle\Entity\Room $room)
    {
        $this->room = $room;

        return $this;
    }

    /**
     * Get room
     *
     * @return \AppBundle\Entity\Room
     */
    public function getRoom()
    {
        return $this->room;
    }
}
