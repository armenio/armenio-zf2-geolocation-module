<?php
/**
 * Rafael Armenio <rafael.armenio@gmail.com>
 *
 * @link http://github.com/armenio for the source repository
 */
 
namespace Armenio\GeoLocation;

use Zend\Http\Client;
use Zend\Http\Client\Adapter\Curl;
use Zend\Json;

/**
 * GeoLocation
 */
class GeoLocation
{
	public static function getLatLng($address)
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
			
			$result = Json\Json::decode($body, 1);

			$latLng = array(
				'lat' => $result['results'][0]['geometry']['location']['lat'],
				'lng' => $result['results'][0]['geometry']['location']['lng'],
			);

			$isException = false;
		} catch (\Zend\Http\Exception\RuntimeException $e){
			$isException = true;
		} catch (\Zend\Http\Client\Adapter\Exception\RuntimeException $e){
			$isException = true;
		} catch (Json\Exception\RuntimeException $e) {
			$isException = true;
		} catch (Json\Exception\RecursionException $e2) {
			$isException = true;
		} catch (Json\Exception\InvalidArgumentException $e3) {
			$isException = true;
		} catch (Json\Exception\BadMethodCallException $e4) {
			$isException = true;
		}

		if( $isException === true ){
			//código em caso de problemas no decode
		}

		return $latLng;
	}
}