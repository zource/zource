<?php
namespace ZourceIssue\V1\Rest\WorkflowScheme;

class WorkflowSchemeResourceFactory
{
    public function __invoke($services)
    {
        return new WorkflowSchemeResource();
    }
}
