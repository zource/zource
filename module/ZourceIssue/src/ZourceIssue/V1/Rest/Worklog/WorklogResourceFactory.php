<?php
namespace ZourceIssue\V1\Rest\Worklog;

class WorklogResourceFactory
{
    public function __invoke($services)
    {
        return new WorklogResource();
    }
}
