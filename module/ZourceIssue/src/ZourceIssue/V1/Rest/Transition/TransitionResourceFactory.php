<?php
namespace ZourceIssue\V1\Rest\Transition;

class TransitionResourceFactory
{
    public function __invoke($services)
    {
        return new TransitionResource();
    }
}
