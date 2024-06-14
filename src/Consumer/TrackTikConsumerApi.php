<?php

namespace App\Consumer;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\CacheInterface;

class TrackTikConsumerApi extends EmployeeConsumerApi
{
    const CACHE_ACCESS_TOKEN_KEY = 'TRACKTIK_ACCESS_TOKEN';
    const CACHE_REFRESH_TOKEN_KEY = 'TRACKTIK_REFRESH_TOKEN';
    protected string $baseUrl = 'https://smoke.staffr.net';
    protected string $entityPath = '/rest/v1/employees';
    private string $accessTokenPath = '/rest/oauth2/access_token';
    private string $accessToken;


    // TODO: last minute problem, .env variables are not being loaded
    private $credentials = [
        'TEMP_ACCESS_TOKEN' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6IlJTMjU2LWN1cnJlbnQifQ.eyJhdWQiOiI3ZDBiZWJlMTliMDA1ZWViN2NjM2NmZGIiLCJqdGkiOiI2OWRjOGE5YmQ3YzUzZmZhYmI1ZGQxMzE1MDBjNzEyMTdiZWE0OThiNTc3MGJmZGYxM2I1ZDE3YmE5NTgxYTFmN2NjYTBlZWQwNmE0YjViZSIsImlhdCI6MTcxODMxNTA4Ni4wMjcyNDMsImlzcyI6InNtb2tlLnN0YWZmci5uZXQiLCJuYmYiOjE3MTgzMTUwODYuMDI3MjUxLCJleHAiOjE3MTgzMTg2ODYsInN1YiI6IjMyMTUiLCJzY29wZXMiOlsib3BlbmlkIiwicHJvZmlsZSIsImNvcmU6ZW50aXRpZXM6ZW1wbG95ZWVzOnJlYWQiLCJjb3JlOmVudGl0aWVzOmVtcGxveWVlczp3cml0ZSJdfQ.m571PaXJGhhyukGeCejCxSPe_GTOGGKCv4WIcil40Gr7x7Md6ElXgvBmrOYEs4OQSg34F-ZmkzdBp9xfaVl32CtXSckzS2HSXLLksUQum1uc65EGbmO65SApHsBoM75h_4UAPv5lEpt5b_w6lmagJbulgo9kHklEl-87GXG6y5pnZsln0VMrZ_fanz5MpWbSho34hSh3spDW914Lx3bULMiB2owk9v_hAHGp_s2cHRig7UNsuJYzL_DtqHmm6Y5bfwBMP4ESS_WiLOO32t7UHS-LDiEUMQ-kL0UB5aLAGhAxfP-f-Lp1VFA3w3T47H4E2c9PBz6ZSLEwW1elXUQMbbmonPAGW_QVl9cyvs-hyKz1OLyeYSFlsRB0rjYwSjUbAC58CNk0JcxIHKKNbLshjZJsOHFb8eMnO5Cqw-0miNNFwAdmlVsws0CbaYReubUMUMSFoQTK-yv4vsiLCbSggtyDbUkUcM2JsdhiPsBbdF3o_NE1XFrn3ifpbUNW8huBmcz2DDEYEF7AWdeNIHyK8EIT7AVy9b_A2lD9N0HJmY_5421F82a5yMeErssN_PpASkcC3EYEk7t9neqjCmP94MMOkeaqD8zBjdcXeMoEXTXMMUQ8oRb0uUHdacRL8MJpq0UTiLaa9Gvzve5coFt7rWS94zAFhnoWoRPNRm5BbzI',
        'TEMP_REFRESH_TOKEN' => 'def50200b1e6e56c250f773eba49d5dbc87e863d7b8a77799238ddb7354bc801ac6161df82ecaa4398c0f6c8ce82944d658800fa9078e407a8c171a17bcca9fd186390c35cb72679dc323dd2e8aba6fd84fe0020012944ea6747aaa8ed1e5127a006e9a0024fd9b13c689b596003df0df478afbe2fa557d9b5de03f6686112d8648f4dff80b3e182160019595f2135ddc3f7ee62994ff2af2479bcce66a67900802fc96cc4ffc0fbc61947422a44a6d19be026af1e13c7c9f9a5401614b533744dd0e1ef051d8b20c3e76517ebc0d02d96bae5db6cdc195b5cac630d6d80495147000d526fd4675be5d609cf4a31d8fbeba6e3f038498382941426882c2a3b423d3fb60351be553d48d319da7eef3c8dedada8f5e6161f4707867a61df59236c65d2190bf3511907dc517d9db64a18f82e3d6b2be081f695c3f849d440ad81b61eb92402578e5c007f185522209ab1e17d5760cd53b003b891696331a0e6cba0b460c579de586207859b27821197771e7c4e41258e2d784e955f99733df2881ce51afaae3fbda3818ce12a9ae1eaa5223fd0f751ba9f388523947bd05df11bba13e69c4ffad096cff8221ccd89efdebb74c4d149954f3cd81b0fe00bd375131d7405b6dcdc535f229191de5b49df',
        'CLIENT_ID' => '7d0bebe19b005eeb7cc3cfdb',
        'CLIENT_SECRET' => '8c2d987ddf8cb248297ea2735890de17e316e03b972c4ca2021886b914b92b2d',
    ];

    /**
     * @throws Exception
     */
    public function __construct(private readonly ParameterBagInterface $params, private readonly CacheInterface $cache)
    {
        parent::__construct();
        $this->authenticate();
        $this->setAuthorizationHeader('Bearer ' . $this->accessToken);
    }

    /**
     * @throws Exception
     */
    public function authenticate(): void
    {
        try {
            $cachedAccessToken = $this->cache->get(self::CACHE_ACCESS_TOKEN_KEY, function () {
                // Token not found in cache, fetch it from .env and cache it
                return $this->credentials['TEMP_ACCESS_TOKEN'];
            });
            $this->accessToken = $cachedAccessToken;
        } catch (RequestException $e) {
            // Handle authentication error
            throw new Exception("Failed to get accessToken: " . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            // Handle cache error
            throw new Exception("Failed to get accessToken from cache: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function refreshToken(): void
    {
        try {
            $cachedRefreshToken = $this->cache->get(self::CACHE_REFRESH_TOKEN_KEY, function () {
//                return $this->params->get('TEMP_REFRESH_TOKEN');
                return $this->credentials['TEMP_REFRESH_TOKEN'];
            });
            $response = $this->guzzleClient->post($this->accessTokenPath, [
                'form_params' => [
                    'grant_type' => 'refresh_token',
//                    'client_id' => $this->params->get('CLIENT_ID'),
//                    'client_secret' => $this->params->get('CLIENT_SECRET'),
                    'client_id' => $this->credentials['CLIENT_ID'],
                    'client_secret' => $this->credentials['CLIENT_SECRET'],
                    'refresh_token' => $cachedRefreshToken
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $accessToken = $data['access_token'];
            $refreshToken = $data['refresh_token'];
            $this->cache->getItem(self::CACHE_ACCESS_TOKEN_KEY)->set($accessToken)->expiresAfter(300);
            $this->cache->getItem(self::CACHE_REFRESH_TOKEN_KEY)->set($refreshToken)->expiresAfter(300);
            $this->accessToken = $accessToken;
        } catch (RequestException $e) {
            throw new Exception("Failed to get accessToken: " . $e->getMessage());
        } catch (InvalidArgumentException $e) {
            throw new Exception("Failed to get accessToken from cache: " . $e->getMessage());
        } catch (GuzzleException $e) {
            throw new Exception("Failed to refresh token: " . $e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    protected function handleUnauthorized(): void
    {
        try {
            $this->refreshToken();
        } catch (Exception $e) {
            // Handle refresh token error
            throw new Exception("Failed to refresh token: " . $e->getMessage());
        }
    }

}