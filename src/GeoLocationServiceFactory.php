<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */
 
namespace Armenio\GeoLocation;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 *
 * GeoLocationServiceFactory
 * @author Rafael Armenio <rafael.armenio@gmail.com>
 *
 *
 */
class GeoLocationServiceFactory implements FactoryInterface
{
    /**
     * zend-servicemanager v2 factory for creating GeoLocation instance.
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @returns GeoLocation
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $geoLocation = new GeoLocation();
        return $geoLocation;
    }
}
