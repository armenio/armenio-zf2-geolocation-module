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
 * Class GeoLocation
 * @package Armenio\GeoLocation
 */
class GeoLocation
{
    /**
     * @param string $address
     * @param string $key
     * @return array
     */
    public static function getLatLng($address, $key)
    {
        $url = 'https://maps.google.com/maps/api/geocode/json';
        $client = new Client($url);
        $client->setAdapter(new Curl());
        $client->setMethod('GET');
        $client->setOptions([
            'curloptions' => [
                CURLOPT_HEADER => false,
                CURLOPT_CONNECTTIMEOUT => 0,
                CURLOPT_TIMEOUT => 60,
            ],
        ]);

        $client->setParameterGet([
            'address' => $address,
            'sensor' => false,
            'key' => $key,
        ]);

        try {
            $response = $client->send();

            $body = $response->getBody();

            $arrResults = Json\Json::decode($body, 1);

            if (!empty($arrResults)) {
                $result = [
                    'lat' => $arrResults['results'][0]['geometry']['location']['lat'],
                    'lng' => $arrResults['results'][0]['geometry']['location']['lng'],
                ];
            } else {
                $result = [
                    'error' => 'Dados não encontrados.',
                ];
            }

        } catch (Client\Adapter\Exception\TimeoutException $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        } catch (Client\Adapter\Exception\RuntimeException $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        } catch (Json\Exception\RecursionException $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        } catch (Json\Exception\RuntimeException $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        } catch (Json\Exception\InvalidArgumentException $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        } catch (Json\Exception\BadMethodCallException $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $result;
    }
}