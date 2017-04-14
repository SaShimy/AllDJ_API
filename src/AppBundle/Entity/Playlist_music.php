<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Playlist_music
 *
 * @ORM\Table(name="playlist_music")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Playlist_musicRepository")
 */
class Playlist_music
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
     * @ORM\Column(name="name", type="string", length=25)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="music_yt_id", type="string", length=255)
     */
    private $musicYtId;

    /**
     * @var string
     *
     * @ORM\Column(name="img_url", type="string", length=255)
     */
    private $imgUrl;

    /**
     * @ORM\ManyToOne(targetEntity="Playlist", inversedBy="Playlist")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="id", onDelete="CASCADE")
     */
    private $playlist;

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
     * @return Playlist_music
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
     * Get musicYtId
     *
     * @return string
     */
    public function getMusicYtId()
    {
        return $this->musicYtId;
    }

    /**
     * Set musicYtId
     *
     * @param string $musicYtId
     *
     * @return Playlist_music
     */
    public function setMusicYtId($musicYtId)
    {
        $this->musicYtId = $musicYtId;

        return $this;
    }

    /**
     * Set imgUrl
     *
     * @param string $imgUrl
     *
     * @return Playlist_music
     */
    public function setImgUrl($imgUrl)
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }

    /**
     * Get imgUrl
     *
     * @return string
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * Set playlist
     *
     * @param \AppBundle\Entity\Playlist $playlist
     *
     * @return Playlist_music
     */
    public function setPlaylist(\AppBundle\Entity\Playlist $playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * Get playlist
     *
     * @return \AppBundle\Entity\Playlist
     */
    public function getPlaylist()
    {
        return $this->playlist;
    }
}
