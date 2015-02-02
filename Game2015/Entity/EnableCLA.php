<?php

namespace Aip\SeriousgameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnableCLA
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EnableCLA
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
     * @ORM\Column(name="enablecla", type="boolean", length=255)
     */
    private $enablecla;
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

    
    public function setEnablecla($enablecla)
    {
        $this->enablecla = $enablecla;

        return $this;
    }

public function isEnablecla()
    {
    	return $this->enablecla;
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
