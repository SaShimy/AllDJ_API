<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room_music_type
 *
 * @ORM\Table(name="room_music_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Room_music_typeRepository")
 */
class Room_music_type
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
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="music_types")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="music_type", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $music_type;

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
     * Set room
     *
     * @param \AppBundle\Entity\Room $room
     *
     * @return Room_music_type
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
     * Set musicType
     *
     * @param \AppBundle\Entity\music_type $musicType
     *
     * @return Room_music_type
     */
    public function setMusicType(\AppBundle\Entity\music_type $musicType)
    {
        $this->music_type = $musicType;

        return $this;
    }

    /**
     * Get musicType
     *
     * @return \AppBundle\Entity\music_type
     */
    public function getMusicType()
    {
        return $this->music_type;
    }
}
