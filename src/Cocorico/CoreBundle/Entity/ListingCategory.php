<?php

/*
 * This file is part of the Cocorico package.
 *
 * (c) Cocolabs SAS <contact@cocolabs.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cocorico\CoreBundle\Entity;

use Cocorico\CoreBundle\Model\BaseListingCategory;
use Cocorico\CoreBundle\Model\ListingCategoryListingCategoryFieldInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ListingCategory
 *
 * @Gedmo\Tree(type="nested")
 *
 * @ORM\Entity(repositoryClass="Cocorico\CoreBundle\Repository\ListingCategoryRepository")
 *
 * @ORM\Table(name="listing_category")
 *
 */
class ListingCategory extends BaseListingCategory
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="ListingCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="ListingCategory", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     *
     * @ORM\OneToMany(targetEntity="Cocorico\CoreBundle\Entity\ListingListingCategory", mappedBy="category", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $listingListingCategories;

    /**
     *
     * @ORM\OneToMany(targetEntity="Cocorico\CoreBundle\Model\ListingCategoryListingCategoryFieldInterface", mappedBy="category", cascade={"persist", "remove"})
     */
    private $fields;

    /**
     * @var ListingCategoryImage
     *
     * @ORM\OneToOne(targetEntity="ListingCategoryImage", cascade={"persist", "remove"})
     */
    private $image;


    public function __construct()
    {
        $this->listingListingCategories = new ArrayCollection();
        $this->fields = new ArrayCollection();
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
     * Set parent
     *
     * @param  \Cocorico\CoreBundle\Entity\ListingCategory $parent
     * @return ListingCategory
     */
    public function setParent(ListingCategory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Cocorico\CoreBundle\Entity\ListingCategory
     */
    public function getParent()
    {
        return $this->parent;
    }


    /**
     * Add children
     *
     * @param  \Cocorico\CoreBundle\Entity\ListingCategory $children
     * @return ListingCategory
     */
    public function addChild(ListingCategory $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Cocorico\CoreBundle\Entity\ListingCategory $children
     */
    public function removeChild(ListingCategory $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add field
     *
     * @param  ListingCategoryListingCategoryFieldInterface $field
     * @return ListingCategory
     */
    public function addField($field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Remove listings
     *
     * @param  ListingCategoryListingCategoryFieldInterface $field
     */
    public function removeField($field)
    {
        $this->fields->removeElement($field);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\ArrayCollection|ListingCategoryListingCategoryFieldInterface[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set image
     *
     * @param ListingCategoryImage $image
     *
     * @return ListingCategory
     */
    public function setImage($image): ListingCategory
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     * I wanted to specify the return nullable type because php7.1 is able to do that,
     * but Symfony is too old and it breaks console commands
     *
     * @return null|ListingCategoryImage
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get image/default name
     *
     * @return string
     */
    public function getImageOrDefault()
    {
        if (!$this->getImage()) {
            return ListingCategoryImage::IMAGE_DEFAULT_NAME;
        }

        return $this->getImage()->getName();
    }

    /**
     * Get image web path
     *
     * @return string
     */
    public function getImageWebPath()
    {
        return ListingCategoryImage::IMAGE_FOLDER . $this->getImageOrDefault();
    }

    /**
     * Add category
     *
     * @param  \Cocorico\CoreBundle\Entity\ListingListingCategory $listingListingCategory
     * @return ListingCategory
     */
    public function addListingListingCategory(ListingListingCategory $listingListingCategory)
    {
        if (!$this->listingListingCategories->contains($listingListingCategory)) {
            $this->listingListingCategories[] = $listingListingCategory;
        }

        return $this;
    }

    /**
     * Remove category
     *
     * @param \Cocorico\CoreBundle\Entity\ListingListingCategory $listingListingCategory
     */
    public function removeListingListingCategory(ListingListingCategory $listingListingCategory)
    {
        $this->listingListingCategories->removeElement($listingListingCategory);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getListingListingCategories()
    {
        return $this->listingListingCategories;
    }

    /**
     * @param ArrayCollection $listingListingCategories
     * @return ArrayCollection
     */
    public function setListingListingCategories(ArrayCollection $listingListingCategories)
    {
        $this->listingListingCategories = $listingListingCategories;
    }

    public function getName()
    {
        return $this->translate()->getName();
    }

    /**
     * Get translated description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->translate()->getDescription();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
