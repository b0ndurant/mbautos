<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Form\AdressChangeType;
use AppBundle\Form\CarRegistrationFRType;
use AppBundle\Form\CarRegistrationUEType;
use AppBundle\Form\PlateType;
use AppBundle\Form\QuitusType;
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
     * @Route("/cartegrise_fr", methods={"GET", "POST"}, name="carRegistrationFR")
     * @return              Response A Response instance
     */
    public function newCarRegistrationFRAction(Request $request, FileUploaderService $fileUploaderService)
    {   $document = new Document();
        $form = $this->createForm(CarRegistrationFRType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $licenseDriver = [];
            $idCard = [];
            $domJustify = [];
            $carRegistration = [];

            foreach ($document->getLicenseDriver() as $file) {
                $licenseDriver[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setLicenseDriver($licenseDriver);


            foreach ($document->getIdCard() as $file) {
                $idCard[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setIdCard($idCard);

            $controlT = $fileUploaderService->upload($document->getControlT(),$document->getName());
            $document->setControlT($controlT);

            $immatRequest = $fileUploaderService->upload($document->getImmatRequest(),$document->getName());
            $document->setImmatRequest($immatRequest);

            $mandat = $fileUploaderService->upload($document->getMandat(),$document->getName());
            $document->setMandat($mandat);

            foreach ($document->getDomJustify() as $file) {
                $domJustify[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setDomJustify($domJustify);

            $insuranceCertificate = $fileUploaderService->upload($document->getInsuranceCertificate(),$document->getName());
            $document->setInsuranceCertificate($insuranceCertificate);

            $transferOrSales = $fileUploaderService->upload($document->getTransferOrSales(),$document->getName());
            $document->setTransferOrSales($transferOrSales);

            foreach ($document->getCarRegistration() as $file) {
                $carRegistration[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setCarRegistration($carRegistration);

            $document->setType('Carte grise française');
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();

            $this->_sendEmail($form->getData());
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('carRegistrationFR');
        }
        return $this->render('carRegistration/fr/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request             $request             Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/cartegrise_ue", methods={"GET", "POST"}, name="carRegistrationUE")
     * @return              Response A Response instance
     */
    public function newCarRegistrationUEAction(Request $request, FileUploaderService $fileUploaderService)
    {   $document = new Document();
        $form = $this->createForm(CarRegistrationUEType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $licenseDriver = [];
            $idCard = [];
            $domJustify = [];
            $carRegistration = [];
            $ueConformity = [];

            foreach ($document->getLicenseDriver() as $file) {
                $licenseDriver[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setLicenseDriver($licenseDriver);


            foreach ($document->getIdCard() as $file) {
                $idCard[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setIdCard($idCard);

            $controlT = $fileUploaderService->upload($document->getControlT(),$document->getName());
            $document->setControlT($controlT);

            $immatRequest = $fileUploaderService->upload($document->getImmatRequest(),$document->getName());
            $document->setImmatRequest($immatRequest);

            $mandat = $fileUploaderService->upload($document->getMandat(),$document->getName());
            $document->setMandat($mandat);

            foreach ($document->getDomJustify() as $file) {
                $domJustify[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setDomJustify($domJustify);

            $insuranceCertificate = $fileUploaderService->upload($document->getInsuranceCertificate(),$document->getName());
            $document->setInsuranceCertificate($insuranceCertificate);

            $transferOrSales = $fileUploaderService->upload($document->getTransferOrSales(),$document->getName());
            $document->setTransferOrSales($transferOrSales);

            foreach ($document->getCarRegistration() as $file) {
                $carRegistration[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setCarRegistration($carRegistration);

            foreach ($document->getUeConformity() as $file) {
                $ueConformity[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setUeConformity($ueConformity);

            $quitus = $fileUploaderService->upload($document->getQuitus(),$document->getName());
            $document->setQuitus($quitus);

            $document->setType('Carte grise étrangère');
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();

            $this->_sendEmail($form->getData());
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('carRegistrationUE');
        }
        return $this->render('carRegistration/ue/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request             $request             Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/changement_adresse", methods={"GET", "POST"}, name="adressChange")
     * @return              Response A Response instance
     */
    public function newAdressChangeAction(Request $request, FileUploaderService $fileUploaderService)
    {   $document = new Document();
        $form = $this->createForm(AdressChangeType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idCard = [];
            $domJustify = [];
            $carRegistration = [];

            foreach ($document->getIdCard() as $file) {
                $idCard[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setIdCard($idCard);


            $mandat = $fileUploaderService->upload($document->getMandat(),$document->getName());
            $document->setMandat($mandat);

            foreach ($document->getDomJustify() as $file) {
                $domJustify[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setDomJustify($domJustify);

            foreach ($document->getCarRegistration() as $file) {
                $carRegistration[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setCarRegistration($carRegistration);

            $document->setType('Changement d\'adresse');
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();

            $this->_sendEmail($form->getData());
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('adressChange');

        }
        return $this->render('adressChange/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request             $request             Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/quitus_fiscal", methods={"GET", "POST"}, name="quitus")
     * @return              Response A Response instance
     */
    public function newQuitusAction(Request $request, FileUploaderService $fileUploaderService)
    {   $document = new Document();
        $form = $this->createForm(QuitusType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $idCard = [];
            $domJustify = [];
            $carRegistration = [];

            foreach ($document->getIdCard() as $file) {
                $idCard[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setIdCard($idCard);


            $mandat = $fileUploaderService->upload($document->getMandat(),$document->getName());
            $document->setMandat($mandat);

            foreach ($document->getDomJustify() as $file) {
                $domJustify[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setDomJustify($domJustify);

            $transferOrSales = $fileUploaderService->upload($document->getTransferOrSales(),$document->getName());
            $document->setTransferOrSales($transferOrSales);

            $immatRequest = $fileUploaderService->upload($document->getImmatRequest(),$document->getName());
            $document->setImmatRequest($immatRequest);

            foreach ($document->getCarRegistration() as $file) {
                $carRegistration[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setCarRegistration($carRegistration);

            $document->setType('Quitus fiscal');
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();

            $this->_sendEmail($form->getData());
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('quitus');
        }
        return $this->render('quitus/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request             $request             Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     *
     * @Route("/plaques_immatriculation", methods={"GET", "POST"}, name="plate")
     * @return              Response A Response instance
     */
    public function newPlateAction(Request $request, FileUploaderService $fileUploaderService)
    {   $document = new Document();
        $form = $this->createForm(PlateType::class, $document);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plate = [];

            foreach ($document->getCarRegistration() as $file) {
                $plate[] = $fileUploaderService->upload($file, $document->getName());
            }
            $document->setType('plaque immatriculation');
            $document->setCarRegistration($plate);
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();

            $this->_sendEmail($form->getData());
            $this->addFlash("success", "Votre message a bien été envoyé.");

            return $this->redirectToRoute('plate');
        }
        return $this->render('plate/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /** Creates email function for send.
     *
     * $data function to send email
     *
     * @param string int array $data function send email
     *
     * @return string int array
     */
    private function _sendEmail(Document $document)
    {
        $message = \Swift_Message::newInstance()
            ->setFrom($document->getEmail())
            ->setCharset('UTF-8')
            ->setTo($this->container->getParameter('mailer_user'))
            ->setSubject('Demande de'.' '.$document->getType())
            ->setBody(
                $this->renderView(
                    'email/registration.html.twig',
                    [
                        'name' => $document->getName(),
                        'email' => $document->getEmail(),
                        'telephone' => $document->getPhoneNumber(),
                        'message' => $document->getType(),
                    ]
                ),
                'text/html'
            );
        return $this->get('mailer')->send($message);
    }

}