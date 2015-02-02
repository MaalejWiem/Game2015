<?php

namespace Aip\SeriousgameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activitegame
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Aip\SeriousgameBundle\Repository\ActivitegameRepository")
 */
class Activitegame
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var string
     *
     * @ORM\Column(name="nomconfiguration", type="string", length=255)
     */
    private $nomconfiguration;
    /**
     * @var string
     *
     * @ORM\Column(name="instructions", type="string", length=255)
     */
    private $instructions;
    /**
     * @ORM\ManyToOne(
     *     targetEntity="Claroline\CoreBundle\Entity\User"
     * )
     * @ORM\JoinColumn(name="creator_id", onDelete="CASCADE", nullable=false)
     */
    protected $creator;
    /**
     * @ORM\ManyToOne(
     *     targetEntity="Aip\SeriousgameBundle\Entity\ConfigurationgameAggregate",
     *     inversedBy="activitegame"
     * )
     * @ORM\JoinColumn(name="aggregate_id", onDelete="CASCADE", nullable=false)
     */
    protected $aggregate;
    /**
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    protected $creationDate;
    /**
     * @ORM\Column(name="publication_date", type="datetime", nullable=true)
     */
    protected $publicationDate;


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
     * Set nom
     *
     * @param string $nom
     * @return Activitegame
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set instructions
     *
     * @param string $instructions
     * @return Activitegame
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;

        return $this;
    }

    /**
     * Get instructions
     *
     * @return string 
     */
    public function getInstructions()
    {
        return $this->instructions;
    }
    public function getCreator()
    {
    	return $this->creator;
    }
    
    public function setCreator($creator)
    {
    	$this->creator = $creator;
    }
    public function getAggregate()
    {
    	return $this->aggregate;
    }
    
    public function setAggregate($aggregate)
    {
    	$this->aggregate= $aggregate;
    }
    public function getCreationDate()
    {
    	return $this->creationDate;
    }
    
    public function setCreationDate($creationDate)
    {
    	$this->creationDate = $creationDate;
    }
    public function getPublicationDate()
    {
    	return $this->publicationDate;
    }
    
    public function setPublicationDate($publicationDate)
    {
    	$this->publicationDate = $publicationDate;
    }
    public function getNomconfiguration()
    {
    	return $this->nomconfiguration;
    }
    
    public function setNomconfiguration($nomconfiguration)
    {
    	$this->nomconfiguration = $nomconfiguration;
    }
}
