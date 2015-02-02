<?php

namespace Aip\SeriousgameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enable
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Aip\SeriousgameBundle\Entity\EnableRepository")
 */
class Enable
{
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
     * @ORM\Column(name="enable", type="boolean", length=255)
     */
    private $enable;
     /**
     *
     *
     * @ORM\Column(name="creator", type="integer", length=255)
     */
    protected $creator;


    public function isEnable()
    {
    	return $this->enable;
    }
    
    
    public function setEnable($enable)
    {
    	$this->enable = $enable;
    }
    public function getCreator()
    {
    	return $this->creator;
    }
    public function setCreator($creator)
    {
    	$this->creator = $creator;
    }
}
