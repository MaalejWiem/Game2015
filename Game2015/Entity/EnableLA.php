<?php

namespace Aip\SeriousgameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnableLA
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EnableLA
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
     * @ORM\Column(name="enablela", type="boolean", length=255)
     */
    private $enablela;
    /**
     *
     *
     * @ORM\Column(name="aggregate_id", type="integer", length=255)
     */
    protected $aggregate;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    public function isEnablela()
    {
    	return $this->enablela;
    }
    
    
    public function setEnablela($enablela)
    {
    	$this->enablela = $enablela;
    }
    public function getAggregate()
    {
    	return $this->aggregate;
    }
    
    public function setAggregate($aggregate)
    {
    	$this->aggregate= $aggregate;
    }
}
