<?php

namespace App\Enums;

enum PageStatus: int
{
    case DRAFT = 0;
    case PUBLISHED = 1;
    case PRIVATE = 2;
}
