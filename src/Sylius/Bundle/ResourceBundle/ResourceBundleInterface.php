<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\ResourceBundle;

/**
 * @author Arnaud Langlade <arn0d.dev@gmail.com>
 */
interface ResourceBundleInterface
{
    const MAPPING_XML = 'xml';
    const MAPPING_YAML = 'yaml';
    const MAPPING_ANNOTATION = 'annotation';

    /**
     * Returns a vector of supported drivers.
     *
     * @see SyliusResourceBundle::DRIVER_DOCTRINE_ORM
     * @see SyliusResourceBundle::DRIVER_DOCTRINE_MONGODB_ODM
     * @see SyliusResourceBundle::DRIVER_DOCTRINE_PHPCR_ODM
     *
     * @return array
     */
    public function getSupportedDrivers();
}
