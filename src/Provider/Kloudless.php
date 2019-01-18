<?php namespace Devdavid1307\OAuth2\Client\Provider;

use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Grant\AbstractGrant;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * ------------------------------------------------------------------------------------
 * Oauth2 for Kloudless
 * ------------------------------------------------------------------------------------
 *
 * @author david
 * @change 2019/01/18
 */
class Kloudless extends AbstractProvider
{

    // ------------------------------------------------------------------------------

    /**
     * default scopes
     *
     * @var array
     */
    private $defaultScopes = [];

    // ------------------------------------------------------------------------------

    /**
     * Base URL
     *
     * @var string
     */
    private $baseUrl = 'https://api.kloudless.com/v1/';

    // ------------------------------------------------------------------------------

    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->baseUrl . 'oauth/services';
    }

    // ------------------------------------------------------------------------------

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->baseUrl . 'oauth/token';
    }

    // ------------------------------------------------------------------------------

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->baseUrl . 'accounts/'.$token->getResourceOwnerId();
    }

    // ------------------------------------------------------------------------------

    /**
     * Creates an access token from a response.
     *
     * @param array                                     $response
     * @param \League\OAuth2\Client\Grant\AbstractGrant $grant
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    protected function createAccessToken(array $response, AbstractGrant $grant)
    {
        $para =
        [
            'access_token'      => $response['access_token'],
            'resource_owner_id' => $response['account_id']
        ];

        return new AccessToken($para);
    }

    // ------------------------------------------------------------------------------

    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return $this->defaultScopes;
    }

    // ------------------------------------------------------------------------------

    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array|string      $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if (! isset($data['error'])) { return; }

        throw new IdentityProviderException
        (
            (isset($data['error']['message']) ? $data['error']['message'] : $response->getReasonPhrase()),
            $response->getStatusCode(),
            $response
        );
    }

    // ------------------------------------------------------------------------------

    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array       $response
     * @param  AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new KloudlessResourceOwner($response, $token->getResourceOwnerId());
    }

    // ------------------------------------------------------------------------------

    /**
     * get header
     *
     * @param  AccessToken $token
     * @return array
     */
    protected function getAuthorizationHeaders($token = null)
    {
        return
        [
            'Authorization' => 'Bearer '. $token->getToken()
        ];
    }

    // ------------------------------------------------------------------------------

}