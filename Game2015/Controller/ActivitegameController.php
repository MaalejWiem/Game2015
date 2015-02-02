<?php

namespace Aip\SeriousgameBundle\Controller;
use Aip\SeriousgameBundle\Entity\Activitegame;
use Aip\SeriousgameBundle\Entity\Enable;
use Aip\SeriousgameBundle\Entity\EnableLA;
use Aip\SeriousgameBundle\Entity\EnableCLA;
use Aip\SeriousgameBundle\Entity\ConfigurationgameAggregate;
use Aip\SeriousgameBundle\Form\ActivitegameType;
use Aip\SeriousgameBundle\Manager\ActivitegameManager;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Claroline\CoreBundle\Entity\Resource\Directory;
use Claroline\CoreBundle\Entity\Resource\ResourceType;
use Claroline\CoreBundle\Entity\Workspace\AbstractWorkspace;
use Claroline\CoreBundle\Library\Resource\ResourceCollection;
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Claroline\CoreBundle\Manager\ResourceManager;
use Claroline\CoreBundle\Pager\PagerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\Translator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\Finder\Finder;
use JMS\DiExtraBundle\Annotation as DI;

class ActivitegameController extends Controller
{
    private $activitegameManager;
    private $resourceManager;
    private $formFactory;
    private $pagerFactory;
    private $securityContext;
    private $translator;
    private $utils;
    private $workspaceManager;

    /**
     * @DI\InjectParams({
     *     "activitegameManager"       = @DI\Inject("aip.activitegame.manager.activitegame_manager"),
     *      "resourceManager"       = @DI\Inject("claroline.manager.resource_manager"),
     *     "formFactory"             = @DI\Inject("form.factory"),
     *     "pagerFactory"            = @DI\Inject("claroline.pager.pager_factory"),
     *     "securityContext"         = @DI\Inject("security.context"),
     *     "translator"              = @DI\Inject("translator"),
     *     "utils"                   = @DI\Inject("claroline.security.utilities"),
     *     "workspaceManager"        = @DI\Inject("claroline.manager.workspace_manager")
     * })
     */
    public function __construct(
        ActivitegameManager $activitegameManager,
    	ResourceManager 	$resourceManager,
        FormFactoryInterface $formFactory,
        PagerFactory $pagerFactory,
        SecurityContextInterface $securityContext,
        Translator $translator,
        Utilities $utils,
        WorkspaceManager $workspaceManager
    )
    {
        $this->formFactory = $formFactory;
        $this->activitegameManager = $activitegameManager;
        $this->resourceManager = $resourceManager;
        $this->pagerFactory = $pagerFactory;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
        $this->utils = $utils;
        $this->workspaceManager = $workspaceManager;
    }

    /**
     * @EXT\Route(
     *     "/activitegame/list/aggregate/{aggregateId}/page/{page}",
     *     name = "claro_activitegame_list",
     *     defaults={"page"=1}
     * )
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::activitegameList.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function activitegameListAction(ConfigurationgameAggregate $aggregate, $page)
    {
    	$collection = new ResourceCollection(array($aggregate->getResourceNode()));
    	$user = $this->securityContext->getToken()->getUser();
    	$id=$aggregate->getId();
    	try {
    		$this->checkAccess('EDIT', $aggregate);
    		$activitegame = $this->activitegameManager->getAllActivitegameByAggregate($aggregate);
    		$em=$this->getDoctrine()->getEntityManager();
    		
    		$query = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :id' );
    		$query->setParameter('id', $id);
    		$configgame=$query->getResult();
    		$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\EnableLA u WHERE u.aggregate = :id' );
    		$query1->setParameter('id', $id);
    		$enablela=$query1->getResult();
    		$query2 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\EnableCLA u WHERE u.aggregate = :id' );
    		$query2->setParameter('id', $id);
    		$enablecla=$query2->getResult();
    		
    		
    		
    	}
    	catch(AccessDeniedException $e) {
    		$this->checkAccess('OPEN', $aggregate);
    		$activitegame = $this->activitegameManager->getVisibleActivitegameByAggregate($aggregate);
    		$em=$this->getDoctrine()->getEntityManager();
    		
    		$query = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :id' );
    		$query->setParameter('id', $id);
    		$configgame=$query->getResult();
    		$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\EnableLA u WHERE u.aggregate = :id' );
    		$query1->setParameter('id', $id);
    		$enablela=$query1->getResult();
    		$query2 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\EnableCLA u WHERE u.aggregate = :id' );
    		$query2->setParameter('id', $id);
    		$enablecla=$query2->getResult();
    		
    		
    		
    		
    	}
    	$pager = $this->pagerFactory->createPagerFromArray($activitegame, $page, 5);
    
    	return array(
    			'_resource' => $aggregate,
    			'activitegame' => $pager,
    			'resourceCollection' => $collection,
    			'configgame' =>$configgame,
    			'enablela' =>$enablela,
    			'enablecla' => $enablecla
    			
    			
    	);
    }
    /**
     * @EXT\Route(
     *     "/telechargement/game/aggregate/{aggregateId}/page/{page}",
     *     name = "claro_telechargementgame_game",
     *     defaults={"page"=1}
     * )
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::telechargementgame.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function telechergementgameListAction(ConfigurationgameAggregate $aggregate, $page)
    {
    	$collection = new ResourceCollection(array($aggregate->getResourceNode()));
    
    	try {
    		$this->checkAccess('EDIT', $aggregate);
    		$activitegame = $this->activitegameManager->getAllActivitegameByAggregate($aggregate);
    		
    
    	}
    	catch(AccessDeniedException $e) {
    		$this->checkAccess('OPEN', $aggregate);
    		$activitegame = $this->activitegameManager->getVisibleActivitegameByAggregate($aggregate);
    		
    
    	}
    	$pager = $this->pagerFactory->createPagerFromArray($activitegame, $page, 5);
    	
    	return array(
    			'_resource' => $aggregate,
    			'activitegame' => $pager
    			
    			 
    	);
    }
    /**
     * @EXT\Route(
     *     "/activitegame/{activitegameId}/delete",
     *     name = "claro_activite_delete",
     *     options={"expose"=true}
     * )
     * @EXT\Method("DELETE")
     * @EXT\ParamConverter(
     *      "activitegame",
     *      class="AipSeriousgameBundle:Activitegame",
     *      options={"id" = "activitegameId", "strictId" = true}
     * )
     *
     * @param Activitegame $activitegame
     *
     * @return Response
     */
    public function activitegameDeleteAction(Activitegame $activitegame)
    {
    	$resource = $activitegame->getAggregate();
    	$this->checkAccess('EDIT', $resource);
    	$this->activitegameManager->deleteActivitegame($activitegame);
    	
    	return new Response(204);
    }
    /**
     * @EXT\Route(
     *     "/activitegame/delete/aggregate/{aggregateId}/page/{page}",
     *     name = "claro_activitegame_delete",
     *     defaults={"page"=1}
     * )
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::activitegameList.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function activitegamedeleteListAction(ConfigurationgameAggregate $aggregate, $page)
    {
    	$collection = new ResourceCollection(array($aggregate->getResourceNode()));
    	$em = $this->getDoctrine()->getEntityManager();
    	$user = $this->securityContext->getToken()->getUser();
    	$id = $aggregate->getId();
    	try {
    		$this->checkAccess('EDIT', $aggregate);
    		$query = $em->createQuery('DELETE FROM Aip\SeriousgameBundle\Entity\Activitegame e WHERE e.aggregate = :aggregate');
    		$query->setParameter('aggregate',$aggregate);
    		$query->execute();
    	    $query2 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Configurationgame u WHERE u.aggregate = :aggregate ');
    	    $query2->setParameter('aggregate',$aggregate);
    		$configurationgame=$query2->getResult();
    		$query3 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :id' );
    		$query3->setParameter('id', $id);
    		$enablegame=$query3->getResult();
    		if(($configurationgame != null)&&($enablegame==null))
    		{
    		$disabledgame = new Enable();
    		$disabledgame->setEnable(true);
    		$disabledgame->setCreator($id);
    		$em->persist($disabledgame);
    		$em->flush();
    		}
    		$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :id' );
    		$query1->setParameter('id', $id);
    		$configgame=$query1->getResult();
    		$activitegame = $this->activitegameManager->getAllActivitegameByAggregate($aggregate);
    		
    		
    	}
    	catch(AccessDeniedException $e) {
    		$this->checkAccess('OPEN', $aggregate);
    		$query = $em->createQuery('DELETE FROM Aip\SeriousgameBundle\Entity\Activitegame e WHERE e.aggregate = :aggregate');
    		$query->setParameter('aggregate',$aggregate);
    		$query->execute();
    		 $query2 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Configurationgame u WHERE u.aggregate = :aggregate ');
    	    $query2->setParameter('aggregate',$aggregate);
    		$configurationgame=$query2->getResult();
    		$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :id' );
    		$query1->setParameter('id', $id);
    		$configgame=$query1->getResult();
    		if(($configurationgame != null)&&($configgame==null))
    		{
    		$disabledgame = new Enable();
    		$disabledgame->setEnable(true);
    		$disabledgame->setCreator($id);
    		$em->persist($disabledgame);
    		$em->flush();
    		}
    		$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :id' );
    		$query1->setParameter('id', $id);
    		$configgame=$query1->getResult();
    		$activitegame = $this->activitegameManager->getVisibleActivitegameByAggregate($aggregate);
    		
    
    	}
    	$pager = $this->pagerFactory->createPagerFromArray($activitegame, $page, 5);
    
    	return array(
    			'_resource' => $aggregate,
    			'activitegame' => $pager,
    			'resourceCollection' => $collection,
    			'configgame' =>$configgame
    			);
    			
    }
    /**
     * @EXT\Route(
     *     "/activitegame/{aggregateId}/page/{page}",
     *     name = "claro_activitegame_tracesac",
     *     defaults={"page"=1}
     * )
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::activitegameList.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function activitegametracesacListAction(ConfigurationgameAggregate $aggregate)
    {
    	$collection = new ResourceCollection(array($aggregate->getResourceNode()));
    	$user = $this->securityContext->getToken()->getUser();
    	$id = $aggregate->getId();
    	$em=$this->getDoctrine()->getEntityManager();
    	$restrace=new Directory();
    	$restrace->setName("TraceLA Apprenant");
    	 
    	$resourcetype = $em->getRepository('ClarolineCoreBundle:Resource\ResourceType')->findOneByName('directory');
    	$workspace=$user->getPersonalWorkspace();
    	$parent = $em->getRepository('ClarolineCoreBundle:Resource\ResourceNode')->findWorkspaceRoot($workspace);
    	$rights = array();
    	$this->container->get("claroline.manager.resource_manager")->create($restrace,$resourcetype,$user, $workspace, $parent,null, $rights);
    	$ressac=new Directory();
    	$ressac->setName("SacLA Apprenant");
    	 
    	$resourcetype = $em->getRepository('ClarolineCoreBundle:Resource\ResourceType')->findOneByName('directory');
    	$workspace=$user->getPersonalWorkspace();
    	$parent = $em->getRepository('ClarolineCoreBundle:Resource\ResourceNode')->findWorkspaceRoot($workspace);
    	$rights = array();
    	$this->container->get("claroline.manager.resource_manager")->create($ressac,$resourcetype,$user, $workspace, $parent,null, $rights);
    	$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\EnableLA u WHERE u.aggregate = :id' );
    	$query1->setParameter('id', $id);
    	$query = $em->createQuery('DELETE FROM Aip\SeriousgameBundle\Entity\EnableCLA e WHERE e.aggregate = :id ');
    	$query->setParameter('id', $id);
    	$query->execute();
    	$enablela=$query1->getResult();
    	if($enablela==null)
    	{
    		$lA = new EnableLA();
    		$lA ->setEnablela(true);
    		$lA ->setAggregate($id);
    		$em->persist($lA);
    		$em->flush();
    	}
    	
    	return $this->redirect(
    			$this->generateUrl(
    					'claro_activitegame_list',
    					array('aggregateId' => $aggregate->getId())
    			)
    	);
    	return array(
    			'_resource' => $aggregate,
    			'resourceCollection' => $collection,
    			'enablela' => $enablela
    			
    	);
    }
    /**
     * @EXT\Route(
     *     "/configame/{activitegameId}/config",
     *     name = "claro_configgame_edit_form"
     * )
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *      "activitegame",
     *      class="AipSeriousgameBundle:Activitegame",
     *      options={"id"="activitegameId","strictId"= true}
     * )
     * @EXT\Template("AipSeriousgameBundle::activitegameconfig.html.twig")
     *
     * @param Activitegame $activitegame
     *
     * @return Response
     */
    public function configgameConfigAction( Activitegame $activitegame)
    {
    
    	$collection = new ResourceCollection(array($activitegame->getAggregate()));
    	$nomconfiguration = $activitegame->getNomconfiguration();
    	$user = $this->securityContext->getToken()->getUser();
    	$resource = $activitegame->getAggregate();
    	$id = $resource->getId();
    	$em=$this->getDoctrine()->getEntityManager();
    	$query = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Configurationgame u WHERE u.nom = :name AND u.aggregate = :aggregate ');
    	$query->setParameter('name', $nomconfiguration);
    	$query->setParameter('aggregate', $resource);
    	$activitegame=$query->getResult();
    	$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\EnableCLA u WHERE u.aggregate = :id' );
    	$query1->setParameter('id', $id);
    	
    	$enablecla=$query1->getResult();
    	if($enablecla==null)
    	{
    		$lA = new EnableCLA();
    		$lA ->setEnablecla(true);
    		$lA ->setAggregate($id);
    		$em->persist($lA);
    		$em->flush();
    	}
    	
    	return array(
    
    			'activitegame' => $activitegame,
    			'resourceCollection' => $collection,
    			'_resource' => $resource,
    			'enablecla' =>$enablecla
    
    	);
    }
    /**
     * @EXT\Route(
     *     "/aggregate/{aggregateId}/createactivite/form",
     *     name = "claro_activitegame_create_form"
     * )
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::createFormActivite.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function createFormAction(ConfigurationgameAggregate $aggregate)
    {
    	 
    	$this->checkAccess('EDIT', $aggregate);
    	$activitegame = new Activitegame();
    	$activitegame->setAggregate($aggregate);
    	$form = $this->formFactory->create(new ActivitegameType(), $activitegame);
    
    	return array(
    			'form' => $form->createView(),
    			'type' => 'create',
    			'_resource' => $aggregate
    	);
    }
    

/**
 * @EXT\Route(
 *     "/aggregate/{aggregateId}/createactivite",
 *     name = "claro_activitegame_create"
 * )
 * @EXT\Method("POST")
 * @EXT\ParamConverter(
 *      "aggregate",
 *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
 *      options={"id" = "aggregateId", "strictId" = true}
 * )
 * @EXT\Template("AipSeriousgameBundle::createFormActivite.html.twig")
 *
 * @param ConfigurationgameAggregate $aggregate
 *
 * @return Response
 */
public function createAction(ConfigurationgameAggregate $aggregate)
{
	$this->checkAccess('EDIT', $aggregate);
	
	$user = $this->securityContext->getToken()->getUser();
	$id = $aggregate->getId();
	$activitegame = new Activitegame();
	$activitegame->setAggregate($aggregate);
	$form = $this->formFactory->create(new ActivitegameType(), $activitegame);
	$request = $this->getRequest();
	$form->handleRequest($request);
	
	
		$now = new \DateTime();
	
		 
		
			
			 
		 
		$activitegame->setAggregate($aggregate);
		$activitegame->setCreationDate($now);
		$activitegame->setPublicationDate($now);
		
		$activitegame->setCreator($user);
		$nom = $form->get('nomconfiguration')->getData()->getNom();
		$activitegame->setNomconfiguration($nom);
		$em=$this->getDoctrine()->getEntityManager();
		
		$query = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Configurationgame u WHERE u.nom = :name AND u.aggregate = :aggregate ');
		$query->setParameter('name', $nom);
		$query->setParameter('aggregate', $aggregate);
		$activiteconf=$query->getResult();
		
		
		$this->activitegameManager->insertActivitegame($activitegame);
		$query = $em->createQuery('DELETE FROM Aip\SeriousgameBundle\Entity\Enable e WHERE e.creator = :id ');
		$query->setParameter('id', $id);
		$query->execute();
		return $this->redirect(
				$this->generateUrl(
						'claro_activitegame_list',
						array('aggregateId' => $aggregate->getId())
				)
		);
	
	
	return array(
			'form' => $form->createView(),
			'type' => 'create',
			'_resource' => $aggregate,
			'$activiteconf' =>$activiteconf
	);
}
/**
 * @EXT\Route(
 *     "/activitegame/{activitegameId}/edit/form",
 *     name = "claro_activitegame_edit_form"
 * )
 * @EXT\Method("GET")
 * @EXT\ParamConverter(
 *      "activitegame",
 *      class="AipSeriousgameBundle:Activitegame",
 *      options={"id"="activitegameId","strictId"= true}
 * )
 * @EXT\Template("AipSeriousgameBundle::createFormActivite.html.twig")
 *
 * @param Activitegame $activitegame
 *
 * @return Response
 */
public function activitegameEditFormAction(Activitegame $activitegame)
{
	$resource = $activitegame->getAggregate();

	$this->checkAccess('EDIT', $resource);
	$activitegame->setAggregate($resource);
	$form = $this->formFactory->create(new ActivitegameType(), $activitegame);

	return array(
			'form' => $form->createView(),
			'type' => 'edit',
			'activitegame' => $activitegame,
			'_resource' => $resource
	);
}
/**
 * @EXT\Route(
 *     "/activitegame/{activitegameId}/edit",
 *     name = "claro_activitegame_edit"
 * )
 * @EXT\Method("POST")
 * @EXT\ParamConverter(
 *      "activitegame",
 *      class="AipSeriousgameBundle:Activitegame",
 *      options={"id"="activitegameId","strictId"= true}
 * )
 * @EXT\Template("AipSeriousgameBundle::createFormActivite.html.twig")
 *
 * @param Activitegame $activitegame
 *
 * @return Response
 */
public function activitegameEditAction(Activitegame $activitegame)
{
	
	$resource = $activitegame->getAggregate();
	 
	$this->checkAccess('EDIT', $resource);
	$form = $this->formFactory->create(new ActivitegameType(), $activitegame);
	
	$request = $this->getRequest();
	$form->handleRequest($request);
	

		$now = new \DateTime();
		
		 
		
			
			 
			
			$activitegame->setPublicationDate($now);
		 
			$nom = $form->get('nomconfiguration')->getData()->getNom();
		    $activitegame->setNomconfiguration($nom);
		$this->activitegameManager->insertActivitegame($activitegame);
		 
		return $this->redirect(
				$this->generateUrl(
						'claro_activitegame_list',
						array('aggregateId' => $resource->getId())
				)
		);
	
	 
	return array(
			'form' => $form->createView(),
			'type' => 'edit',
			'activitegame' => $activitegame,
			'_resource' => $resource
	);
}


/**
 * @EXT\Route(
 *     "/activitegame/workspace/{workspaceId}/page/{page}",
 *     name="claro_workspace_activitegame_pager",
 *     defaults={"page"=1},
 *     options={"expose"=true}
 * )
 * @EXT\Method("GET")
 * @EXT\ParamConverter(
 *      "workspace",
 *      class="ClarolineCoreBundle:Workspace\AbstractWorkspace",
 *      options={"id" = "workspaceId", "strictId" = true}
 * )
 *
 * @EXT\Template("AipSeriousgameBundle::activitegameWorkspaceWidgetPager.html.twig")
 *
 * Renders activitegame in a pager.
 *
 * @return Response
 */
public function activitegameWorkspaceWidgetPagerAction(AbstractWorkspace $workspace, $page)
{
	$token = $this->securityContext->getToken();
	$roles = $this->utils->getRoles($token);
	$datas = $this->activitegameManager->getVisibleActivitegameByWorkspace($workspace, $roles);
	$pager = $this->pagerFactory->createPagerFromArray($datas, $page, 5);

	return array(
			'datas' => $pager,
			'widgetType' => 'workspace',
			'workspaceId' => $workspace->getId()
	);
}
/**
 * @EXT\Route(
 *     "/activitegame/page/{page}",
 *     name="claro_desktop_activitegame_pager",
 *     defaults={"page"=1},
 *     options={"expose"=true}
 * )
 * @EXT\Method("GET")
 *
 * @EXT\Template("AipSeriousgameBundle::activitegameDesktopWidgetPager.html.twig")
 *
 * Renders activitegame in a pager.
 *
 * @return Response
 */
public function activitegameDesktopWidgetPagerAction($page)
{
	$token = $this->securityContext->getToken();
	$roles = $this->utils->getRoles($token);
	$workspaces = $this->workspaceManager->getWorkspacesByRoles($roles);
	$datas = $this->activitegameManager->getVisibleActivitegameByWorkspaces($workspaces, $roles);
	$pager = $this->pagerFactory->createPagerFromArray($datas, $page, 5);

	return array('datas' => $pager, 'widgetType' => 'desktop');
}
    /**
     * Checks if the current user has the right to perform an action on a ResourceCollection.
     * Be careful, ResourceCollection may need some aditionnal parameters.
     *
     * - for CREATE: $collection->setAttributes(array('type' => $resourceType))
     *  where $resourceType is the name of the resource type.
     * - for MOVE / COPY $collection->setAttributes(array('parent' => $parent))
     *  where $parent is the new parent entity.
     *
     * @param string             $permission
     * @param ResourceCollection $collection
     *
     * @throws AccessDeniedException
     */
    private function checkAccess($permission, AbstractResource $resource)
    {
    	$collection = new ResourceCollection(array($resource->getResourceNode()));
    
    	if (!$this->securityContext->isGranted($permission, $collection)) {
    		throw new AccessDeniedException($collection->getErrorsForDisplay());
    	}
    }
}