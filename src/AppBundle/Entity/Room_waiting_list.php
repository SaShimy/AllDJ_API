<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room_waiting_list
 *
 * @ORM\Table(name="room_waiting_list")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Room_waiting_listRepository")
 */
class Room_waiting_list
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="Room_waiting_list")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="Room_waiting_list")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="music_yt_id", type="string", length=255)
     */
    private $musicYtId;

    /**
     * @var string
     *
     * @ORM\Column(name="music_duration", type="string", length=255)
     */
    private $musicDuration;

    /**
     * @var string
     *
     * @ORM\Column(name="music_name", type="string", length=255)
     */
    private $musicName;

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
     * @return Room_waiting_list
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
     * @return Room_waiting_list
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

    /**
     * Set musicYtId
     *
     * @param string $musicYtId
     *
     * @return Room_waiting_list
     */
    public function setMusicYtId($musicYtId)
    {
        $this->musicYtId = $musicYtId;

        return $this;
    }

    /**
     * Get musicYtId
     *
     * @return string
     */
    public function getMusicYtId()
    {
        return $this->musicYtId;
    }

    /**
     * Set musicDuration
     *
     * @param string $musicDuration
     *
     * @return Room_waiting_list
     */
    public function setMusicDuration($musicDuration)
    {
        $this->musicDuration = $musicDuration;

        return $this;
    }

    /**
     * Get musicDuration
     *
     * @return string
     */
    public function getMusicDuration()
    {
        return $this->musicDuration;
    }

    /**
     * Set musicName
     *
     * @param string $musicName
     *
     * @return Room_waiting_list
     */
    public function setMusicName($musicName)
    {
        $this->musicName = $musicName;

        return $this;
    }

    /**
     * Get musicName
     *
     * @return string
     */
    public function getMusicName()
    {
        return $this->musicName;
    }
}
