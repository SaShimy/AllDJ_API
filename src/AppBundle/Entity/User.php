<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table("user")
 * @ORM\Entity
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @var string
    *
    * @ORM\Column(name="firstname", type="string", nullable=true)
    */
    private $firstname;

    /**
    * @var string
    *
    * @ORM\Column(name="lastname", type="string", nullable=true)
    */
    private $lastname;

    /**
    * @var string
    *
    * @ORM\Column(name="age", type="integer", nullable=true)
    */
    private $age;

    /**
    * @var string
    *
    * @ORM\Column(name="gender", type="string", nullable=true)
    */
    private $gender;

    /**
    * @var string
    *
    * @ORM\Column(name="birthday", type="string", nullable=true)
    */
    private $birthday;

    /**
    * @ORM\OneToOne(targetEntity="File")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    protected $avatar;

    /**
     * @ORM\OneToMany(targetEntity="UserRoomFollow", mappedBy="user")
     */
    private $followedRooms;

    public function __construct() {
        $this->followedRooms = new ArrayCollection();
        parent::__construct();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return User
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthday
     *
     * @param string $birthday
     *
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return string
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set avatar
     *
     * @param \AppBundle\Entity\File $avatar
     *
     * @return User
     */
    public function setAvatar(\AppBundle\Entity\File $avatar = null)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return \AppBundle\Entity\File
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add room
     *
     * @param \AppBundle\Entity\UserRoomFollow $room
     *
     * @return User
     */
    public function addRoom(\AppBundle\Entity\UserRoomFollow $room)
    {
        $this->followedRooms[] = $followedRooms;

        return $this;
    }

    /**
     * Remove room
     *
     * @param \AppBundle\Entity\UserRoomFollow $room
     */
    public function removeRoom(\AppBundle\Entity\UserRoomFollow $followedRooms)
    {
        $this->followedRooms->removeElement($followedRooms);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowedRooms()
    {
        return $this->followedRooms;
    }
}
