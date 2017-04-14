<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * music_type
 *
 * @ORM\Table(name="music_type")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\music_typeRepository")
 */
class music_type
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
    * @ORM\OneToOne(targetEntity="File")
    * @ORM\JoinColumn(nullable=true, onDelete="CASCADE")
    */
    private $file;

    /**
     * @ORM\OneToMany(targetEntity="Room_music_type", mappedBy="music_type")
     */
    private $rooms;

    public function __construct() {
        $this->rooms = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return music_type
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
     * Set file
     *
     * @param \AppBundle\Entity\File $file
     *
     * @return Lesson
     */
    public function setFile(\AppBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \AppBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return music_type
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add room
     *
     * @param \AppBundle\Entity\Room_music_type $room
     *
     * @return music_type
     */
    public function addRoom(\AppBundle\Entity\Room_music_type $room)
    {
        $this->rooms[] = $room;

        return $this;
    }

    /**
     * Remove room
     *
     * @param \AppBundle\Entity\Room_music_type $room
     */
    public function removeRoom(\AppBundle\Entity\Room_music_type $room)
    {
        $this->rooms->removeElement($room);
    }

    /**
     * Get rooms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRooms()
    {
        return $this->rooms;
    }
}
