<?php

namespace Neoan3\Component\Upsale;

use Neoan3\Frame\VastN3;

/**
 * Class UpsaleController
 * @package Neoan3\Component\Upsale
 *
 * Generated by neoan3-cli for neoan3 v3.*
 */

class UpsaleController extends VastN3{

    /**
    * GET: api.v1/upsale
    * GET: api.v1/upsale/{id}
    * GET: api.v1/upsale?{query-string}
    * @param string|null $id
    * @param array $params
    * @return array
    */
    function getUpsale(?string $id = null, array $params = []): array
    {
        // Restrict access to logged in users?
        // $this->Auth->restrict();
        // (or without dependency on Demo-Frame: $this->provider['auth']->restrict())
        if($id){
            // Retrieve a model?
            // return $this->loadModel(\Neoan3\Model\Upsale\UpsaleModel::class)::get($id);
        }
        return $params;
    }

    /**
     * POST: api.v1/upsale
     * @param $body
     * @return array
     */
    function postUpsale(array $body): array
    {
        return $body;
    }
}