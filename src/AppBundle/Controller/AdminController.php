<?php
/**
 * Created by PhpStorm.
 * User: b0ndurant
 * Date: 26/09/18
 * Time: 18:40
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{
    /**
     * @Route("admin/index", name="indexAdmin")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/indexAdmin.html.twig');
    }
}