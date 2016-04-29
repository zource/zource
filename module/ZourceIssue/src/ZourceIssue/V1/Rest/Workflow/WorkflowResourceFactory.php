<?php
namespace ZourceIssue\V1\Rest\Workflow;

class WorkflowResourceFactory
{
    public function __invoke($services)
    {
        return new WorkflowResource();
    }
}
