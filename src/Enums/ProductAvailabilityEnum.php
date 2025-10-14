<?php

namespace Amplify\System\Backend\Enums;
enum ProductAvailabilityEnum: string
{
    case Actual = 'A';
    case Increment = 'I';
    case Restricted = 'R';
    case SpecialOrder = 'S';
}
