<?php

namespace SL\ThesaurusBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SLThesaurusBundle:Default:index.html.twig');
    }
}
