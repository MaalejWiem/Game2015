<?php

namespace Aip\SeriousgameBundle\Manager;

use Aip\SeriousgameBundle\Entity\Activitegame;
use Aip\SeriousgameBundle\Entity\ConfigurationgameAggregate;
use Aip\SeriousgameBundle\Repository\ActivitegameRepository;
use Claroline\CoreBundle\Entity\Workspace\AbstractWorkspace;
use Claroline\CoreBundle\Persistence\ObjectManager;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("aip.activitegame.manager.activitegame_manager")
 */
class ActivitegameManager
{
    /** @var ActivitegameRepository */
    private $activitegameRepo;
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
        $this->activitegameRepo = $om->getRepository('AipSeriousgameBundle:Activitegame');
        $this->om = $om;
    }

    public function insertActivitegame(Activitegame $activitegame)
    {
        $this->om->persist($activitegame);
        $this->om->flush();
    }

    public function deleteActivitegame(Activitegame $activitegame)
    {
        $this->om->remove($activitegame);
        $this->om->flush();
    }

    public function getVisibleActivitegameByWorkspace(AbstractWorkspace $workspace, array $roles)
    {
        return $this->activitegameRepo->findVisibleActivitegameByWorkspace($workspace, $roles);
    }

    public function getVisibleActivitegameByWorkspaces(array $workspaces, array $roles)
    {
        return $this->activitegameRepo->findVisibleActivitegameByWorkspaces($workspaces, $roles);
    }

    public function getAllActivitegameByAggregate(ConfigurationgameAggregate $aggregate)
    {
        return $this->activitegameRepo->findAllActivitegameByAggregate($aggregate);
    }

    public function getVisibleActivitegameByAggregate(ConfigurationgameAggregate $aggregate)
    {
        return $this->activitegameRepo->findVisibleActivitegameByAggregate($aggregate);
    }
}