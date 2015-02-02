<?php

namespace Aip\SeriousgameBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

use Claroline\CoreBundle\Entity\Resource\AbstractResource;

/**
 * @ORM\Entity
 * @ORM\Table(name="claro_game_aggregate")
 */
class ConfigurationgameAggregate extends AbstractResource
{
   
	/**
	 * @ORM\OneToMany(
	 *     targetEntity="Aip\SeriousgameBundle\Entity\Configurationgame",
	 *     mappedBy="aggregate"
	 * )
	 */
	
	protected $configurationgame;
	
	public function getConfigurationgame()
	{
		return $this->configurationgame;
	}
	
}