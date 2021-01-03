<?php
/**
 * Created by neoan3-cli.
 */

namespace Neoan3\Frame;

use Exception;
use Neoan3\Core\Serve;
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
    private string $dbCredentials = 'neoan3_db';
    /**
     * @var Database|DatabaseWrapper
     */
    public Database|DatabaseWrapper $db;

    /**
     * Demo constructor.
     * @param Database|null $db
     * @throws Exception
     */
    function __construct(Database $db = null)
    {
        parent::__construct(new VueRenderer($this->constants()));
       /* $this->assignProvider('db', $db, function(){
            $credentials = getCredentials();
            $this->provider['db'] = new DatabaseWrapper($credentials[$this->dbCredentials]);
        });*/

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
    function constants()
    {
        return [
            'modules' => [
//                base . 'node_modules/vue/dist/vue.esm-browser.js',
            ]
        ];
    }
}
