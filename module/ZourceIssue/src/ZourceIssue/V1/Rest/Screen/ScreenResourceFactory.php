<?php
namespace ZourceIssue\V1\Rest\Screen;

class ScreenResourceFactory
{
    public function __invoke($services)
    {
        return new ScreenResource();
    }
}
