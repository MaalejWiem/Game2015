<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aip\SeriousgameBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Claroline\KernelBundle\Bundle\ConfigurationProviderInterface;
use Claroline\CoreBundle\Library\PluginBundle;
use Claroline\KernelBundle\Bundle\ConfigurationBuilder;
use Claroline\KernelBundle\Bundle\AutoConfigurableInterface;
use Aip\SeriousgameBundle\Installation\AdditionalInstaller;

class AipSeriousgameBundle extends PluginBundle implements AutoConfigurableInterface, ConfigurationProviderInterface

{
    public function supports($environment)
    {
        return true;
    }

    public function getConfiguration($environment)
    {
        $config = new ConfigurationBuilder();

        return $config->addRoutingResource(__DIR__ . '/Resources/config/routing.yml', null, 'test');
    }

    public function suggestConfigurationFor(Bundle $bundle, $environment)
    {
        
    }

    public function getAdditionalInstaller()
    {
        return new AdditionalInstaller();
    }
    
   
}

