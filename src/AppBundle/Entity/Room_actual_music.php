<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room_actual_music
 *
 * @ORM\Table(name="room_actual_music")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Room_actual_musicRepository")
 */
class Room_actual_music
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
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $user;


    /**
     * @ORM\OneToOne(targetEntity="Room", inversedBy="Room_actual_music")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $room;

    /**
     * @var string
     *
     * @ORM\Column(name="start", type="string", length=255)
     */
    private $start;

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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set start
     *
     * @param string $start
     *
     * @return Room_actual_music
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return string
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set musicYtId
     *
     * @param string $musicYtId
     *
     * @return Room_actual_music
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Room_actual_music
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
     * @return Room_actual_music
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
     * Set musicDuration
     *
     * @param string $musicDuration
     *
     * @return Room_actual_music
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
     * @return Room_actual_music
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
