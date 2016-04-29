<?php
namespace ZourceIssue\V1\Rest\Version;

class VersionResourceFactory
{
    public function __invoke($services)
    {
        return new VersionResource();
    }
}
