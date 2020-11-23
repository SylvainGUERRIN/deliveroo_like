<?php

namespace App\Controller\admin;

use Twig\Environment;

class AdminController
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
