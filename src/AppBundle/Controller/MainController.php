<?php
/**
 * Created by PhpStorm.
 * User: m.horiachev
 * Date: 02/07/18
 * Time: 17:23
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller {

  public function homepageAction(){


    return $this->render('main/homepage.html.twig');
  }
}