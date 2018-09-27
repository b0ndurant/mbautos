<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Form\DocumentType;
use AppBundle\Service\FileUploaderService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @param Request             $request             Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/new", methods={"GET", "POST"}, name="document_new")
     * @return              Response A Response instance
     */
    public function editAction(Request $request, FileUploaderService $fileUploaderService)
    {   $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filename = [];

            foreach ($document->getCarRegistration() as $file) {
                $filename[] = $fileUploaderService->upload($file, $document->getLastName());
            }
            $document->setCarRegistration($filename);
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->render('default/new.html.twig',
            ['form' => $form->createView()]
        );
    }
}
