<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Form\PriceType;
use AppBundle\Service\FileUploaderService;
use AppBundle\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/index", name="indexAdmin")
     */
    public function indexAction()
    {
        return $this->render('default/indexAdmin.html.twig');
    }

    /**
     * @Route("/liste", name="list")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $documents = $em->getRepository(Document::class)->findAll();
        // replace this example code with whatever you need
        return $this->render('document/index.html.twig', [
            'documents' => $documents,
        ]);
    }

    /**
     * Finds and displays a article entity.
     *
     * @param Document $document
     *
     * @Route("/liste/{id}", methods={"GET"}, name="document_show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Document $document)
    {
        return $this->render('document/show.html.twig',
            ['document' => $document]
        );
    }

    /**
     * Deletes a email entity.
     *
     * @param Document $document Deleting customer
     * @param FileUploaderService $fileUploaderService
     *
     * @Route("/liste/delete/{id}", methods={"GET"}, name="document_delete")
     *
     * @return Response A Response Instance
     */
    public function deleteAction(Document $document, FileUploaderService $fileUploaderService)
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploaderService->deletePdf($document->getName());
        $em->remove($document);
        $em->flush();

        return $this->redirectToRoute('list');
    }


    /**
     * @param Document $document
     *
     * @Route("/down/{id}", methods={"GET"}, name="document_download")
     *
     * @return Response A Response Instance
     */
    public function DownloadAction(Document $document)
    {
        $directory = $this->getParameter('targetDirectory').'/'.$document->getName();
        if (is_dir($directory)) {
            $zip = new \ZipArchive();
            $zip->open($directory . '.zip', \ZipArchive::CREATE);
            $dir = scandir($directory);
            unset($dir[0], $dir[1]);
            foreach ($dir as $file) {
                $zip->addFile($directory . '/' . $file, $file);
            }
            $zip->close();

            // Generate response
            $response = new Response();

            // Set headers
            $response->headers->set('Cache-Control', 'private');
            $response->headers->set('Content-type', 'application/force-download');
            $response->headers->set('Content-Disposition',
                'attachment; filename='.$document->getName().'".zip";');
            $response->headers->set('Content-length', filesize(
                $this->getParameter('targetDirectory') . '/' .
                $document->getName() . '.zip'));

            // Send headers before outputting anything
            $response->sendHeaders();
            $response->setContent(file_get_contents(
                $this->getParameter('targetDirectory') . '/' .
                $document->getName() . '.zip'));
            unlink($this->getParameter('targetDirectory') . '/' .
                $document->getName() . '.zip');
            return $response;
        }
        $this->addFlash('danger', 'Cette demande ne contient aucun documents');
        return $this->redirectToRoute('document_show', ['id' => $document->getId()]);
    }

    /**
     * @param Document $document
     * @param int $status
     * 
     * @Route("/{id}/{status}", methods={"GET"}, name="document_status")
     * 
     * @return Response A Response Instance
     */
    public function statusAction(Document $document, $status)
    {
        if ($status >= 0 && $status <= 2) {
            $document->setStatus($status);

            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute(
            'list'
        );
    }

    /**
     * set Price for request.
     *
     * @param Request $request New posted info
     * @param Document $document The contract entity
     * @param MailerService $mailerService
     *
     * @Route("/price/{document}", methods={"POST"}, name="price")
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function priceAction(
        Request $request, Document $document, MailerService $mailerService
    ) {
        $form = $this->createForm(PriceType::class);
        $form->handleRequest($request);

        // Var for the file name
        if ($form->isSubmitted() && $form->isValid()) {
            $document->setPrice(
                $request->get("appbundle_document")['price']
            );
            $token = rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
            $document->setPriceToken($token);
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();

            $url = $this->generateUrl('payment',
                ['priceToken' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            $mailerService->sendEmail($this->getParameter('mailer_user'),
                $document->getEmail(), $document->getType(),
                $document->getPrice(),'email/send_price.html.twig',
                $document->getName(), $url
            );
            $this->addFlash("success", "Votre message a bien été envoyé.");

            return $this->redirectToRoute('list');
        }

        return $this->render(
            'default/_price.html.twig',
            [
                'form' => $form->createView(),
                'document' => $document
            ]
        );
    }
}