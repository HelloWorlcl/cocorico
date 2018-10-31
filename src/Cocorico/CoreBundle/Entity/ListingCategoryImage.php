<?php

namespace Cocorico\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ListingCategoryImage
 *
 * @ORM\Table(name="listing_category_image")
 * @ORM\Entity
 */
class ListingCategoryImage
{
    // Default image name if none was provided
    const IMAGE_DEFAULT_NAME = 'category-default.png';
    // Which folder to save images
    const IMAGE_FOLDER = "./uploads/listings/images/";

    /**
     * @var integer
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
     * @var UploadedFile
     */
    private $file;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ListingCategoryImage
     */
    public function setName(string $name): ListingCategoryImage
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set file
     *
     * @param null|UploadedFile $file
     *
     * @return ListingCategoryImage
     */
    public function setFile($file): ListingCategoryImage
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return null|UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
}
