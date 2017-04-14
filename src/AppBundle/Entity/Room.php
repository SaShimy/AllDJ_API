<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Room
 *
 * @ORM\Table("room")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoomRepository")
 */
class Room
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
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_followers", type="integer")
     */
    private $nbFollowers;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="Room_music_type", mappedBy="room")
     */
    private $music_types;

    /**
     * @ORM\OneToMany(targetEntity="Room_waiting_list", mappedBy="room")
     */
    private $waiting_list;

    /**
     * @ORM\OneToOne(targetEntity="Room_actual_music", mappedBy="room")
     */
    private $actual_music;

    public function __construct() {
        $this->music_types = new ArrayCollection();
        $this->waiting_list = new ArrayCollection();
        //parent::__construct();
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Room
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Room
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nbFollowers
     *
     * @param integer $nbFollowers
     *
     * @return Room
     */
    public function setNbFollowers($nbFollowers)
    {
        $this->nbFollowers = $nbFollowers;

        return $this;
    }

    /**
     * Get nbFollowers
     *
     * @return integer
     */
    public function getNbFollowers()
    {
        return $this->nbFollowers;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Room
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Room
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add musicType
     *
     * @param \AppBundle\Entity\Room_music_type $musicType
     *
     * @return Room
     */
    public function addMusicType(\AppBundle\Entity\Room_music_type $musicType)
    {
        $this->music_types[] = $musicType;

        return $this;
    }

    /**
     * Remove musicType
     *
     * @param \AppBundle\Entity\Room_music_type $musicType
     */
    public function removeMusicType(\AppBundle\Entity\Room_music_type $musicType)
    {
        $this->music_types->removeElement($musicType);
    }

    /**
     * Get musicTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMusicTypes()
    {
        return $this->music_types;
    }

    /**
     * Add waitingList
     *
     * @param \AppBundle\Entity\Room_waiting_list $waitingList
     *
     * @return Room
     */
    public function addWaitingList(\AppBundle\Entity\Room_waiting_list $waitingList)
    {
        $this->waiting_list[] = $waitingList;

        return $this;
    }

    /**
     * Remove waitingList
     *
     * @param \AppBundle\Entity\Room_waiting_list $waitingList
     */
    public function removeWaitingList(\AppBundle\Entity\Room_waiting_list $waitingList)
    {
        $this->waiting_list->removeElement($waitingList);
    }

    /**
     * Get waitingList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWaitingList()
    {
        return $this->waiting_list;
    }

    /**
     * Set actualMusic
     *
     * @param \AppBundle\Entity\Room_actual_music $actualMusic
     *
     * @return Room
     */
    public function setActualMusic(\AppBundle\Entity\Room_actual_music $actualMusic = null)
    {
        $this->actual_music = $actualMusic;

        return $this;
    }

    /**
     * Get actualMusic
     *
     * @return \AppBundle\Entity\Room_actual_music
     */
    public function getActualMusic()
    {
        return $this->actual_music;
    }
}
