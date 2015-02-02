<?php

namespace Aip\SeriousgameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Configurationgame
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Aip\SeriousgameBundle\Repository\ConfigurationgameRepository")
 */
class Configurationgame
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
     * @ORM\Column(name="url", type="string", nullable=false)
     */
    private $url;
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="port", type="integer", nullable=true)
     */
    private $port;

    

    /**
     * @var string
     *
     * @ORM\Column(name="scenario", type="string", length=255 , nullable=false)
     */
    private $scenario;
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
     *     inversedBy="configurationgame"
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
     * Set url
     *
     * @param string $url
     * @return Configurationgame
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set port
     *
     * @param string $port
     * @return Configurationgame
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return string 
     */
    public function getPort()
    {
        return $this->port;
    }


    /**
     * Set scenario
     *
     * @param string $scenario
     * @return Configurationgame
     */
    public function setScenario($scenario)
    {
        $this->scenario = $scenario;

        return $this;
    }

    /**
     * Get scenario
     *
     * @return string 
     */
    public function getScenario()
    {
        return $this->scenario;
    }
    public function getCreator()
    {
    	return $this->creator;
    }
    
    public function setNom($nom)
    {
    	$this->nom = $nom;
    }
    public function getNom()
    {
    	return $this->nom;
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
}
