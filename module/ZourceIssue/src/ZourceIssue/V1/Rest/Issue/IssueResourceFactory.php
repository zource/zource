<?php
namespace ZourceIssue\V1\Rest\Issue;

class IssueResourceFactory
{
    public function __invoke($services)
    {
        return new IssueResource();
    }
}
