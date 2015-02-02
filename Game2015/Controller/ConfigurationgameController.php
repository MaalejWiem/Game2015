<?php

namespace Aip\SeriousgameBundle\Controller;

use Aip\SeriousgameBundle\Entity\Configurationgame;
use Aip\SeriousgameBundle\Entity\ConfigurationgameAggregate;
use Aip\SeriousgameBundle\Entity\Enable;
use Aip\SeriousgameBundle\Form\ConfigurationgameType;
use Aip\SeriousgameBundle\Manager\ConfigurationgameManager;
use Claroline\CoreBundle\Entity\Resource\AbstractResource;
use Claroline\CoreBundle\Entity\Workspace\AbstractWorkspace;
use Claroline\CoreBundle\Library\Resource\ResourceCollection;
use Claroline\CoreBundle\Library\Security\Utilities;
use Claroline\CoreBundle\Manager\WorkspaceManager;
use Claroline\CoreBundle\Pager\PagerFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Translation\Translator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use JMS\DiExtraBundle\Annotation as DI;

class ConfigurationgameController extends Controller
{
    private $configurationgameManager;
    private $formFactory;
    private $pagerFactory;
    private $securityContext;
    private $translator;
    private $utils;
    private $workspaceManager;

    /**
     * @DI\InjectParams({
     *     "configurationgameManager"       = @DI\Inject("aip.configurationgame.manager.configurationgame_manager"),
     *     "formFactory"             = @DI\Inject("form.factory"),
     *     "pagerFactory"            = @DI\Inject("claroline.pager.pager_factory"),
     *     "securityContext"         = @DI\Inject("security.context"),
     *     "translator"              = @DI\Inject("translator"),
     *     "utils"                   = @DI\Inject("claroline.security.utilities"),
     *     "workspaceManager"        = @DI\Inject("claroline.manager.workspace_manager")
     * })
     */
    public function __construct(
        ConfigurationgameManager $configurationgameManager,
        FormFactoryInterface $formFactory,
        PagerFactory $pagerFactory,
        SecurityContextInterface $securityContext,
        Translator $translator,
        Utilities $utils,
        WorkspaceManager $workspaceManager
    )
    {
        $this->formFactory = $formFactory;
        $this->configurationgameManager = $configurationgameManager;
        $this->pagerFactory = $pagerFactory;
        $this->securityContext = $securityContext;
        $this->translator = $translator;
        $this->utils = $utils;
        $this->workspaceManager = $workspaceManager;
    }

    /**
     * @EXT\Route(
     *     "/configurationgame/list/aggregate/{aggregateId}/page/{page}",
     *     name = "claro_configurationgame_list",
     *     defaults={"page"=1}
     * )
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::configurationgameList.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function configurationgameListAction(ConfigurationgameAggregate $aggregate, $page)
    {
    	$collection = new ResourceCollection(array($aggregate->getResourceNode()));
    
    	try {
    		$this->checkAccess('EDIT', $aggregate);
    		$configurationgame = $this->configurationgameManager->getAllConfigurationgameByAggregate($aggregate);
    	}
    	catch(AccessDeniedException $e) {
    		$this->checkAccess('OPEN', $aggregate);
    		$configurationgame = $this->configurationgameManager->getVisibleConfigurationgameByAggregate($aggregate);
    	}
    	$pager = $this->pagerFactory->createPagerFromArray($configurationgame, $page, 5);
    
    	return array(
    			'_resource' => $aggregate,
    			'configurationgame' => $pager,
    			'resourceCollection' => $collection
    	);
     }
    
    /**
     * @EXT\Route(
     *     "/aggregate/{aggregateId}/create/form",
     *     name = "claro_configurationgame_create_form"
     * )
     * @EXT\Method("GET")
     * @EXT\ParamConverter(
     *      "aggregate",
     *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
     *      options={"id" = "aggregateId", "strictId" = true}
     * )
     * @EXT\Template("AipSeriousgameBundle::createForm.html.twig")
     *
     * @param ConfigurationgameAggregate $aggregate
     *
     * @return Response
     */
    public function createFormAction(ConfigurationgameAggregate $aggregate)
    {
    	 
    	$this->checkAccess('EDIT', $aggregate);
    	$configurationgame = new Configurationgame();
    	
    	$form = $this->formFactory->create(new ConfigurationgameType(), $configurationgame);
    
    	return array(
    			'form' => $form->createView(),
    			'type' => 'create',
    			'_resource' => $aggregate
    	);
    }
    

/**
 * @EXT\Route(
 *     "/aggregate/{aggregateId}/creategame",
 *     name = "claro_configurationgame_create"
 * )
 * @EXT\Method("POST")
 * @EXT\ParamConverter(
 *      "aggregate",
 *      class="AipSeriousgameBundle:ConfigurationgameAggregate",
 *      options={"id" = "aggregateId", "strictId" = true}
 * )
 * @EXT\Template("AipSeriousgameBundle::createForm.html.twig")
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
	$configurationgame = new Configurationgame();
	$form = $this->formFactory->create(new ConfigurationgameType(), $configurationgame);
	$request = $this->getRequest();
	$form->handleRequest($request);
	
	
		$now = new \DateTime();
	
		 
		
			
			 
		 
		$configurationgame->setAggregate($aggregate);
		$configurationgame->setCreationDate($now);
		$configurationgame->setPublicationDate($now);
		
		$configurationgame->setCreator($user);
		$em=$this->getDoctrine()->getEntityManager();
			
		$query = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Configurationgame u WHERE u.aggregate = :aggregate' );
		$query->setParameter('aggregate', $aggregate);
		$configgame=$query->getResult();
		$query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Activitegame u WHERE u.aggregate = :aggregate' );
		$query1->setParameter('aggregate', $aggregate);
		$activitygame=$query1->getResult();
		
		if($configgame != null)
		{
		$this->configurationgameManager->insertConfigurationgame($configurationgame);
		}
		if(($configgame == null)&&($activitygame == null))
		{
			$disabledgame = new Enable();
			$disabledgame->setEnable(true);
			$disabledgame->setCreator($id);
			$em->persist($disabledgame);
			$em->flush();
			$this->configurationgameManager->insertConfigurationgame($configurationgame);
			
			
		}
		if(($configgame == null)&&($activitygame != null))
		{
			$this->configurationgameManager->insertConfigurationgame($configurationgame);
				
				
		}
		
		return $this->redirect(
				$this->generateUrl(
						'claro_configurationgame_list',
						array('aggregateId' => $aggregate->getId())
				)
		);
	
	return array(
			'form' => $form->createView(),
			'type' => 'create',
			'_resource' => $aggregate
	);
}
/**
 * @EXT\Route(
 *     "/configurationgame/{configurationgameId}/edit/form",
 *     name = "claro_configurationgame_edit_form"
 * )
 * @EXT\Method("GET")
 * @EXT\ParamConverter(
 *      "configurationgame",
 *      class="AipSeriousgameBundle:Configurationgame",
 *      options={"id"="configurationgameId","strictId"= true}
 * )
 * @EXT\Template("AipSeriousgameBundle::createForm.html.twig")
 *
 * @param Configurationgame $configurationgame
 *
 * @return Response
 */
public function configurationgameEditFormAction(Configurationgame $configurationgame)
{
	$resource = $configurationgame->getAggregate();

	$this->checkAccess('EDIT', $resource);
	$form = $this->formFactory->create(new ConfigurationgameType(), $configurationgame);

	return array(
			'form' => $form->createView(),
			'type' => 'edit',
			'configurationgame' => $configurationgame,
			'_resource' => $resource
	);
}
/**
 * @EXT\Route(
 *     "/configurationgame/{configurationgameId}/edit",
 *     name = "claro_configurationgame_edit"
 * )
 * @EXT\Method("POST")
 * @EXT\ParamConverter(
 *      "configurationgame",
 *      class="AipSeriousgameBundle:Configurationgame",
 *      options={"id"="configurationgameId","strictId"= true}
 * )
 * @EXT\Template("AipSeriousgameBundle::createForm.html.twig")
 *
 * @param Configurationgame $configurationgame
 *
 * @return Response
 */
public function configurationgameEditAction(Configurationgame $configurationgame)
{
	
	$resource = $configurationgame->getAggregate();
	 
	$this->checkAccess('EDIT', $resource);
	$form = $this->formFactory->create(new ConfigurationgameType(), $configurationgame);
	
	$request = $this->getRequest();
	$form->handleRequest($request);
	

		$now = new \DateTime();
		
		 			
			$configurationgame->setPublicationDate($now);
		 
		
		$this->configurationgameManager->insertConfigurationgame($configurationgame);
		 
		return $this->redirect(
				$this->generateUrl(
						'claro_configurationgame_list',
						array('aggregateId' => $resource->getId())
				)
		);
	
	 
	return array(
			'form' => $form->createView(),
			'type' => 'edit',
			'configurationgame' => $configurationgame,
			'_resource' => $resource
	);
}
/**
 * @EXT\Route(
 *     "/configurationgame/{configurationgameId}/delete",
 *     name = "claro_configurationgame_delete"
 * )
 * @EXT\ParamConverter(
 *      "configurationgame",
 *      class="AipSeriousgameBundle:Configurationgame",
 *      options={"id"="configurationgameId","strictId"= true}
 * )
 *
 * @param Configurationgame $configurationgame
 *
 * @return Response
 */
public function configurationgamdeleteeEditAction(Configurationgame $configurationgame)
{

	$resource = $configurationgame->getAggregate();
	$user = $this->securityContext->getToken()->getUser();

    $id= $resource->getId();
    $idconfig=$configurationgame->getId();
    $em = $this->getDoctrine()->getEntityManager();
    $guest = $em->getRepository('AipSeriousgameBundle:Configurationgame')->find($idconfig);
    $em->remove($guest);
    $em->flush();
    $query1 = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Configurationgame u WHERE u.aggregate = :aggregate' );
    $query1->setParameter('aggregate', $resource);
    $activitygame=$query1->getResult();
    $query = $em->createQuery('SELECT u FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :aggregate' );
    $query->setParameter('aggregate', $id);
    $configgame=$query->getResult();
    if (($activitygame==null) && ($configgame!=null))
    {
    	$query2 = $em->createQuery('DELETE  FROM Aip\SeriousgameBundle\Entity\Enable u WHERE u.creator = :aggregate' );
        $query2->setParameter('aggregate', $id);
        
    	$query2->execute();
    	
    }
    if ($activitygame==null)
    		{
    			$query3 = $em->createQuery('DELETE  FROM Aip\SeriousgameBundle\Entity\Activitegame u WHERE u.aggregate = :aggregateid' );
    			$query3->setParameter('aggregateid', $resource);
    			$query3->execute();
    		}
	return $this->redirect(
			$this->generateUrl(
					'claro_configurationgame_list',
					array('aggregateId' => $id)
			)
	);


	
}

/**
 * @EXT\Route(
 *     "/configurationgame/workspace/{workspaceId}/page/{page}",
 *     name="claro_workspace_configurationgame_pager",
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
 * @EXT\Template("AipSeriousgameBundle::configurationgameWorkspaceWidgetPager.html.twig")
 *
 * Renders configurationgame in a pager.
 *
 * @return Response
 */
public function configurationgameWorkspaceWidgetPagerAction(AbstractWorkspace $workspace, $page)
{
	$token = $this->securityContext->getToken();
	$roles = $this->utils->getRoles($token);
	$datas = $this->configurationgameManager->getVisibleConfigurationgameByWorkspace($workspace, $roles);
	$pager = $this->pagerFactory->createPagerFromArray($datas, $page, 5);

	return array(
			'datas' => $pager,
			'widgetType' => 'workspace',
			'workspaceId' => $workspace->getId()
	);
}
/**
 * @EXT\Route(
 *     "/configurationgame/page/{page}",
 *     name="claro_desktop_configurationgame_pager",
 *     defaults={"page"=1},
 *     options={"expose"=true}
 * )
 * @EXT\Method("GET")
 *
 * @EXT\Template("AipSeriousgameBundle::configurationgameDesktopWidgetPager.html.twig")
 *
 * Renders configurationgame in a pager.
 *
 * @return Response
 */
public function configurationgameDesktopWidgetPagerAction($page)
{
	$token = $this->securityContext->getToken();
	$roles = $this->utils->getRoles($token);
	$workspaces = $this->workspaceManager->getWorkspacesByRoles($roles);
	$datas = $this->configurationgameManager->getVisibleConfigurationgameByWorkspaces($workspaces, $roles);
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