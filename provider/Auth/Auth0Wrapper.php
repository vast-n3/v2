<?php


namespace Neoan3\Provider\Auth;



use Auth0\SDK\Auth0;
use Auth0\SDK\Exception\CoreException;
use Exception;
use Neoan3\Apps\Ops;
use Neoan3\Core\RouteException;
use function mb_substr;

/**
 * Class Auth0Wrapper
 * @package Neoan3\Provider\Auth
 */
class Auth0Wrapper implements Auth
{
    /**
     * @var Auth0
     */
    public Auth0 $instance;

    public string $logoutUrl;

    /**
     * Auth0Wrapper constructor.
     * @param $credentials
     * @throws Exception
     */
    function __construct($credentials)
    {
        try {
            $this->instance = new Auth0($credentials);
        } catch (CoreException) {
            throw new Exception('initializing auth0 failed');
        }
        $this->logoutUrl = sprintf('https://%s/v2/logout?client_id=%s&returnTo=%s', $credentials['domain'], $credentials['client_id'], base);

    }
    public function setSecret(string $string): void
    {
        // TODO: Implement setSecret() method.
    }

    public function validate(?string $provided = null): AuthObjectDeclaration
    {
        if(!$user = $this->instance->getUser()){
            throw new RouteException('Authentication failed', 401);
        }
        return new AuthObject($this->unhexableId($user['sub']), ['user'], $user);
    }
    private function unhexableId(string $id): string
    {
        $userId = bin2hex($id);
        $userId = mb_substr($userId,-32);
        return $userId;
    }

    public function restrict($scope = []): AuthObjectDeclaration
    {
        $auth =  $this->validate();
        if(!empty($scope)){
            $passing = false;
            $existing = $auth->getScope();
            foreach ($scope as $mustHave){
                if(in_array($mustHave, $existing)){
                    $passing = true;
                }
            }
            if(!$passing){
                throw new RouteException('unauthorized', 401);
            }
        }
        return $auth;
    }

    public function assign($id, $scope, $payload = []): AuthObjectDeclaration
    {
        $this->instance->setUser([
            'userId' => $id,
            'payload' => $payload
        ]);
        return $this->validate();
    }

    public function logout(): bool
    {
        $this->instance->logout();
        return false;
    }
}