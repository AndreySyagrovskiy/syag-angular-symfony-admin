<?php

namespace Syagr\MediaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;

/**
 * Media
 *
 * @ORM\Table("media")
 * @ORM\Entity(repositoryClass="Syagr\MediaBundle\Entity\MediaRepository")
 */
class Media
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name", nullable=false, length=255)
     */
	protected $name;

    /**
     * @ORM\Column(type="string", name="file_name", nullable=false, length=255)
     */
    protected $fileName;

    /**
     * @ORM\Column(type="text", name="description", nullable=true, length=1024)
     */	
	protected $description;

    /**
     * @ORM\Column(type="boolean", name="enabled", nullable=false)
     */
	protected $enabled = 0;

    /**
     * @ORM\Column(type="string", name="provider_name", nullable=false, length=255)
     */
	protected $providerName;

    /**
     * @ORM\Column(type="array", name="provider_metadata", nullable=true)
     */
	protected $providerMetadata;

    /**
     * @ORM\Column(type="string", name="content_type", nullable=true, length=64)
     */
	protected $contentType;

    /**
     * @ORM\Column(type="integer", name="size", nullable=true)
     */
	protected $size;

    /**
     * @ORM\Column(type="string", name="context_name", nullable=true, length=16)
     */
	protected $contextName;

    /**
     * @var \DateTime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at")
     * @JMS\Type("DateTime<'d/m/Y h:i:s a'>")
     */
	protected $updatedAt;

    /**
     * @var \DateTime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at")
     * @JMS\Type("DateTime<'d/m/Y h:i:s a'>")
     */
	protected $createdAt;



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
     *
     * @return Media
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
     * Set description
     *
     * @param string $description
     *
     * @return Media
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Media
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set providerName
     *
     * @param string $providerName
     *
     * @return Media
     */
    public function setProviderName($providerName)
    {
        $this->providerName = $providerName;

        return $this;
    }

    /**
     * Get providerName
     *
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * Set providerMetadata
     *
     * @param array $providerMetadata
     *
     * @return Media
     */
    public function setProviderMetadata($providerMetadata)
    {
        $this->providerMetadata = $providerMetadata;

        return $this;
    }

    /**
     * Get providerMetadata
     *
     * @return array
     */
    public function getProviderMetadata()
    {
        return $this->providerMetadata;
    }

    /**
     * Set contentType
     *
     * @param string $contentType
     *
     * @return Media
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Media
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set contextName
     *
     * @param string $contextName
     *
     * @return Media
     */
    public function setContextName($contextName)
    {
        $this->contextName = $contextName;

        return $this;
    }

    /**
     * Get contextName
     *
     * @return string
     */
    public function getContextName()
    {
        return $this->contextName;
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
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Media
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
