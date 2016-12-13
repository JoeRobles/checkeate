<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table(name="File")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FileRepository")
 * @ORM\HasLifecycleCallbacks
 */
class File
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="uri", type="string", length=255)
     */
    private $uri;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="original", type="string", length=255, nullable=true)
     */
    private $original;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="fileCreatedBy")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    protected $createdBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status;

    private $file;

    private $temp;


    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return File
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
     * Set type
     *
     * @param string $type
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set uri
     *
     * @param string $uri
     * @return File
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }


    /**
     * Set path
     *
     * @param string $path
     * @return GelImage
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set original
     *
     * @param string $original
     * @return GelImage
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * Get original
     *
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return File
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return File
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return File
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return File
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile($file)
    {
        $this->file = $file;

        if (isset($this->path)) {
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Returns the absolute path to the file
     * @return string
     */
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * Returns the web path
     * @return string
     */
    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir() . '/' . $this->path;
    }

    /**
     * Returns the absolute directory path where uploaded users should be saved
     * @return string
     */
    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    /**
     * Gets rid of the __DIR__ so it doesn't screw up when displaying uploaded doc/image in the view
     * @return string
     */
    public function getUploadDir()
    {
        return 'uploads/files';
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return substr($this->path, -4);
    }

    /**
     * Generates unique name
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename . '.' . $this->getFile()->getClientOriginalExtension();
            $this->setOriginal($this->getFile()->getClientOriginalName());
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        $this->getFile()->move($this->getUploadRootDir(), $this->path);
        $ext = $this->getExtension();
        if ($ext === 'jpeg' || $ext === '.jpg') {
            shell_exec('jpegoptim ' . $this->getUploadRootDir() . '/' . $this->path);
        } elseif ($ext === '.png') {
            shell_exec('optipng ' . $this->getUploadRootDir() . '/' . $this->path);
        }

        if (isset($this->temp)) {
            unlink($this->getUploadRootDir() . '/' . $this->temp);
            $this->temp = null;
        }
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    /**
     * Defaults when inserting a user
     * @ORM\PrePersist()
     */
    public function prePersistTasks()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->setStatus(1);
        $this->preUpload();
    }

    /**
     * Defaults when updating a user
     * @ORM\PreUpdate()
     */
    public function preUpdateTasks()
    {
        $this->setUpdated(new \DateTime());
        $this->preUpload();
    }
}
