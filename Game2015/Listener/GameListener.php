<?php

namespace Aip\SeriousgameBundle\Listener;

use Aip\SeriousgameBundle\Entity\ConfigurationgameAggregate;
use Aip\SeriousgameBundle\Entity\Configurationgame;
use Aip\SeriousgameBundle\Form\ConfigurationgameType;
//use Claroline\CoreBundle\Event\CopyResourceEvent;
use Claroline\CoreBundle\Event\CreateFormResourceEvent;
use Claroline\CoreBundle\Event\CreateResourceEvent;
use Claroline\CoreBundle\Event\DeleteResourceEvent;
//use Claroline\CoreBundle\Event\DownloadResourceEvent;
use Claroline\CoreBundle\Event\OpenResourceEvent;
use Claroline\CoreBundle\Form\Factory\FormFactory;
use Claroline\CoreBundle\Manager\ResourceManager;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service()
 */
class GameListener
{
    private $formFactory;
    private $request;
    private $resourceManager;
    private $router;
    private $templating;
    private $container;

    /**
     * @DI\InjectParams({
     *     "formFactory"        = @DI\Inject("claroline.form.factory"),
     *     "requestStack"       = @DI\Inject("request_stack"),
     *     "resourceManager"    = @DI\Inject("claroline.manager.resource_manager"),
     *     "router"             = @DI\Inject("router"),
     *     "templating"         = @DI\Inject("templating")
    
     * })
     */
    public function __construct(
        FormFactory $formFactory,
        RequestStack $requestStack,
        ResourceManager $resourceManager,
        TwigEngine $templating,
        UrlGeneratorInterface $router
    )
    {
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getCurrentRequest();
        $this->resourceManager = $resourceManager;
        $this->router = $router;
        $this->templating = $templating;
    
    }

    /**
     * @DI\Observe("create_form_test")
     *
     * @param CreateFormResourceEvent $event
     */
    public function onCreateForm(CreateFormResourceEvent $event)
    {
        $form = $this->formFactory->create(
            FormFactory::TYPE_RESOURCE_RENAME,
            array(),
            new ConfigurationgameAggregate()
        );
        $content = $this->templating->render(
            'ClarolineCoreBundle:Resource:createForm.html.twig',
            array(
                'form' => $form->createView(),
                'resourceType' => 'test'
            )
        );
        $event->setResponseContent($content);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("create_test")
     *
     * @param CreateResourceEvent $event
     */
    public function onCreate(CreateResourceEvent $event)
    {
    	if (!$this->request) {
    		throw new NoHttpRequestException();
    	}
    	$form = $this->formFactory->create(
    			FormFactory::TYPE_RESOURCE_RENAME,
    			array(),
    			new ConfigurationgameAggregate()
    	);
    	$form->handleRequest($this->request);
    
    	if ($form->isValid()) {
    		$configurationgameAggregate = $form->getData();
    		$event->setResources(array($configurationgameAggregate));
    		$event->stopPropagation();
    
    		return;
    	}
    
    	$content = $this->templating->render(
    			'ClarolineCoreBundle:Resource:createForm.html.twig',
    			array(
    					'form' => $form->createView(),
    					'resourceType' => 'test'
    			)
    	);
    	$event->setErrorFormContent($content);
    	$event->stopPropagation();
    }
    /**
     * @DI\Observe("delete_test")
     *
     * @param DeleteResourceEvent $event
     */
    public function onDelete(DeleteResourceEvent $event)
    {
    	//        $this->resourceManager->delete($event->getResource());
    	$event->stopPropagation();
    }
    /**
     * @DI\Observe("open_test")
     *
     * @param OpenResourceEvent $event
     */
    public function onOpen(OpenResourceEvent $event)
    {
    	$route = $this->router->generate(
    			'claro_activitegame_list',
    			array('aggregateId' => $event->getResource()->getId())
    	);
    	$event->setResponse(new RedirectResponse($route));
    	$event->stopPropagation();
    }
    
}