<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */
 
namespace Armenio\GeoLocation;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;
use Zend\Json\Json;

/**
 * GeoLocation
 */
class GeoLocation implements ServiceLocatorAwareInterface
{
    protected $serviceLocator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function getCoordinates($address)
	{
		return self::getCoordinates($address);
	}

	public static function getCoordinates($address)
	{
		$latLng = array();

		try{
			$url = sprintf('http://maps.google.com/maps/api/geocode/json?address=%s&sensor=false', $address);
			$client = new Client($url);
			$client->setAdapter(new Curl());
			$client->setMethod('GET');
			$client->setOptions(array(
				'curloptions' => array(
					CURLOPT_HEADER => false,
				),
			));

			
			$response = $client->send();
			
			$body = $response->getBody();
			
			$result = Json::decode($body, 1);

			$latLng = array(
				'lat' => $result['results'][0]['geometry']['location']['lat'],
				'lng' => $result['results'][0]['geometry']['location']['lng'],
			);

			$isException = false;
		} catch (\Zend\Http\Exception\RuntimeException $e){
			$isException = true;
		} catch (\Zend\Http\Client\Adapter\Exception\RuntimeException $e){
			$isException = true;
		} catch (\Zend\Json\Exception\RuntimeException $e) {
			$isException = true;
		} catch (\Zend\Json\Exception\RecursionException $e2) {
			$isException = true;
		} catch (\Zend\Json\Exception\InvalidArgumentException $e3) {
			$isException = true;
		} catch (\Zend\Json\Exception\BadMethodCallException $e4) {
			$isException = true;
		}

		if( $isException === true ){
			//código em caso de problemas no decode
		}

		return $latLng;
	}
}