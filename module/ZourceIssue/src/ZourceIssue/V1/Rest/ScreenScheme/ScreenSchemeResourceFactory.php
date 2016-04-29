<?php
namespace ZourceIssue\V1\Rest\ScreenScheme;

class ScreenSchemeResourceFactory
{
    public function __invoke($services)
    {
        return new ScreenSchemeResource();
    }
}
