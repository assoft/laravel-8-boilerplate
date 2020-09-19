<?php

use Illuminate\Support\Str;

function title_case($value)
{
    return Str::title(str_replace("_", " ", $value));
}

function snake_case($value, $delimiter = "_")
{
    return Str::lower(Str::snake($value, $delimiter));
}

function truncate($value, $limit, $end = "...")
{
    return Str::limit($value, $limit, $end);
}
