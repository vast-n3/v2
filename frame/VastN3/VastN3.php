<?php
/**
 * Created by neoan3-cli.
 */

namespace Neoan3\Frame;

use Exception;
use JetBrains\PhpStorm\ArrayShape;
use Neoan3\Core\RouteException;
use Neoan3\Core\Serve;
use Neoan3\Provider\Auth\Auth0;
use Neoan3\Provider\Auth\Auth0Wrapper;
use Neoan3\Provider\MySql\Database;
use Neoan3\Provider\MySql\DatabaseWrapper;

require_once 'VueRenderer.php';

/**
 * Class VastN3
 * @package Neoan3\Frame
 */
class VastN3 extends Serve
{
    /**
     * Db credential name
     * @var string
     */
    private string $dbCredentials = 'vastn3';
    /**
     * @var Database|DatabaseWrapper
     */
    public Database|DatabaseWrapper $db;

    /*
     * format: ['domain':..., 'client_id':..., 'client_secret':..., 'redirect_uri':..., 'scope':...]
     * */
    private string $auth0credentials = 'auth0';

    /**
     * Demo constructor.
     * @param Database|null $db
     * @throws Exception
     */
    function __construct(Database $db = null)
    {
        parent::__construct(new VueRenderer($this->constants()));
        $credentials = getCredentials();
        $this->assignProvider('auth', null, function () use ($credentials){
            $this->provider['auth'] = new Auth0Wrapper($credentials[$this->auth0credentials]);
        });
        $this->assignProvider('db', $db, function() use ($credentials) {
            $this->provider['db'] = new DatabaseWrapper($credentials[$this->dbCredentials]);
        });

    }

    function output($params = [])
    {
        $this->renderer->includeElement('Header');
        $this->hook('header', 'header');
        parent::output($params);
    }


    /**
     * Overwriting Serve's constants()
     * @return array
     */
    function constants(): array
    {

        return [
            'store' => [
                [
                    'products' => [
                        'endpoints' => ['get' => '/products'],
                        'state' => []
                    ]
                ]
            ],
            'stylesheets' => [
                path . '/frame/VastN3/css/index.css'
            ],
            'modules' => [
//                base . 'node_modules/vue/dist/vue.esm-browser.js',
            ]
        ];
    }
}
