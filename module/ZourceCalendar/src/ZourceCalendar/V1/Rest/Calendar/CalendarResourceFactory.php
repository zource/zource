<?php
namespace ZourceCalendar\V1\Rest\Calendar;

class CalendarResourceFactory
{
    public function __invoke($services)
    {
        return new CalendarResource();
    }
}
