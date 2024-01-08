<?php

namespace App\Enums;

enum PostStatus: int
{
    case DRAFT = 0;
    case PUBLISHED = 1;
    case PRIVATE = 2;
    case BANNED = 3;
}
