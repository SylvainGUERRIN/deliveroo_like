<?php

namespace App\Controller\owner;

use Twig\Environment;

class OwnerController
{
    private $twig;

    /**
     * SiteController constructor.
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
}
