<?php

namespace Neoan3\Component\Auth;

use Neoan3\Core\RouteException;
use Neoan3\Frame\VastN3;
use Auth0\SDK\Auth0;
use Neoan3\Provider\Auth\AuthObjectDeclaration;

/**
 * Class AuthController
 * @package Neoan3\Component\Auth
 *
 * Generated by neoan3-cli for neoan3 v3.*
 */

class AuthController extends VastN3 {
    /**
     * Route: Auth
     */
    function init(): void
    {
        if(isset($_GET['code'])){
            $this->provider['auth']->instance->setAccessToken($_GET['code']);
            $this->provider['auth']->validate();
        }
        redirect('');
    }
    function getAuth(): array
    {
        $auth = $this->provider['auth'];
        try{
            $user = $auth->validate();
        } catch (RouteException $e){
            return ['url' => $auth->instance->getLoginUrl()];
        }
        $payload = $user->getPayload();
        return [
            'email' => $payload['email'],
            'email_verified' => $payload['email_verified'],
            'name' => $payload['name'],
            'picture' => $payload['picture'],
            'userId' => $payload['sub']
        ];
    }

    function deleteAuth()
    {
        $this->provider['auth']->logout();
        return ['url' => $this->provider['auth']->logoutUrl];
    }
}