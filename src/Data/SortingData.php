<?php

namespace App\Data;

use App\Entity\Category;

class SortingData
{
    /**
     * @var int
     */
    public int $page = 1;

    /**
     * @var null|string
     */
    public ?string $q = '';

    /**
     * @var Category[]
     */
    public array $categories = [];

//    /**
//     * @var null|integer
//     */
//    public ?int $min;
//
//    /**
//     * @var null|integer
//     */
//    public ?int $max;

}
