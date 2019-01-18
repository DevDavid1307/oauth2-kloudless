<?php namespace Devdavid1307\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

/**
 * ------------------------------------------------------------------------------------
 * Resource
 * ------------------------------------------------------------------------------------
 *
 * @author david
 * @change 2019/01/18
 */
class KloudlessResourceOwner implements ResourceOwnerInterface
{

    // ------------------------------------------------------------------------------

    /**
     * response
     *
     * @var array
     */
    protected $response;

    // ------------------------------------------------------------------------------

    /**
     * resource owner id
     *
     * @var string
     */
    protected $ownerId;

    // ------------------------------------------------------------------------------

    /**
     * KloudlessResourceOwner constructor.
     *
     * @param array $response
     * @param       $resourceOwnerId
     */
    public function __construct(array $response, $resourceOwnerId)
    {
        $this->response = $response;
        $this->ownerId  = $resourceOwnerId;
    }

    // ------------------------------------------------------------------------------

    /**
     * Returns the identifier of the authorized resource owner.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->response[$this->ownerId];
    }

    // ------------------------------------------------------------------------------

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }

    // ------------------------------------------------------------------------------

}