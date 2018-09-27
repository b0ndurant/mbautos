<?php
/**
 * Created by PhpStorm.
 * User: b0ndurant
 * Date: 26/09/18
 * Time: 18:40
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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


    /**
     * @Route("/down/{id}", methods={"GET"}, name="document_download")
     * @param Document $document
     * @return Response
     */
    public function DownloadAction(Document $document)
    {
        $zip = new \ZipArchive();
        $zip->open($this->getParameter('targetDirectory').'/'.$document->getName().'.zip', \ZipArchive::CREATE);
        $dir = scandir($this->getParameter('targetDirectory').'/'.$document->getName());
        unset($dir[0],$dir[1]);
        foreach ($dir as $file) {
            $zip->addFile($this->getParameter('targetDirectory').'/'.$document->getName().'/'.$file,'file.png');
        }
        $zip->close();

        // Generate response
        $response = new Response();

// Set headers
        $response->headers->set('Cache-Control', 'private');
        $response->headers->set('Content-type', 'application/force-download');
        $response->headers->set('Content-Disposition', 'attachment; filename="test.zip";');
        $response->headers->set('Content-length', filesize($this->getParameter('targetDirectory').'/'.$document->getName().'.zip'));

// Send headers before outputting anything
        $response->sendHeaders();
        $response->setContent(file_get_contents($this->getParameter('targetDirectory').'/'.$document->getName().'.zip'));
        unlink($this->getParameter('targetDirectory').'/'.$document->getName().'.zip');
        return $response;
    }
}