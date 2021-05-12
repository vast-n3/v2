<?php


namespace Neoan3\Provider\Auth;

use Attribute;

#[Attribute]
class Authorization
{
    public string $notation;
    public array $scope;
    public function __construct(string $notation, array $scope = [])
    {
        $this->notation = $notation;
        $this->scope = $scope;
    }
    public function execute($provider, &$returnVariable)
    {
        $returnVariable = $provider['auth']->{$this->notation}($this->scope);
    }
}