<?php

namespace Aip\SeriousgameBundle\Manager;

use Aip\SeriousgameBundle\Entity\Configurationgame;
use Aip\SeriousgameBundle\Entity\ConfigurationgameAggregate;
use Aip\SeriousgameBundle\Repository\ConfigurationgameRepository;
use Claroline\CoreBundle\Entity\Workspace\AbstractWorkspace;
use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("aip.configurationgame.manager.configurationgame_manager")
 */
class ConfigurationgameManager
{
    /** @var ConfigurationgameRepository */
    private $configurationgameRepo;
    private $om;

    /**
     * Constructor.
     *
     * @DI\InjectParams({
     *     "om" = @DI\Inject("claroline.persistence.object_manager")
     * })
     */
    public function __construct(ObjectManager $om)
    {
        $this->configurationgameRepo = $om->getRepository('AipSeriousgameBundle:Configurationgame');
        $this->om = $om;
    }

    public function insertConfigurationgame(Configurationgame $configurationgame)
    {
        $this->om->persist($configurationgame);
        $this->om->flush();
    }

    public function deleteConfigurationgame(Configurationgame $configurationgame)
    {
        $this->om->remove($configurationgame);
        $this->om->flush();
    }

    public function getVisibleConfigurationgameByWorkspace(AbstractWorkspace $workspace, array $roles)
    {
        return $this->configurationgameRepo->findVisibleConfigurationgameByWorkspace($workspace, $roles);
    }

    public function getVisibleConfigurationgameByWorkspaces(array $workspaces, array $roles)
    {
        return $this->configurationgameRepo->findVisibleConfigurationgameByWorkspaces($workspaces, $roles);
    }

    public function getAllConfigurationgameByAggregate(ConfigurationgameAggregate $aggregate)
    {
        return $this->configurationgameRepo->findAllConfigurationgameByAggregate($aggregate);
    }

    public function getVisibleConfigurationgameByAggregate(ConfigurationgameAggregate $aggregate)
    {
        return $this->configurationgameRepo->findVisibleConfigurationgameByAggregate($aggregate);
    }
}