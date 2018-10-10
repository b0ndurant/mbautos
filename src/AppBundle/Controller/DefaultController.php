<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Document;
use AppBundle\Form\AdressChangeType;
use AppBundle\Form\CarRegistrationFRType;
use AppBundle\Form\CarRegistrationUEType;
use AppBundle\Form\PlateType;
use AppBundle\Form\QuitusType;
use AppBundle\Service\FileUploaderService;
use AppBundle\Service\MailerService;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @param Request $request Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     * @param MailerService $mailerService
     *
     * @Route("/cartegrise_fr", methods={"GET", "POST"}, name="carRegistrationFR")
     *
     * @return              Response A Response instance
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newCarRegistrationFRAction(
        Request $request, FileUploaderService $fileUploaderService,
        MailerService $mailerService
    ){
        $document = new Document();
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

            $mailerService->sendEmail($document->getEmail(),
                $this->getParameter('mailer_user'), $document->getType(),
                $document->getType(), 'email/notification.html.twig',
                $document->getName(), $document->getPhoneNumber()
            );
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('carRegistrationFR');
        }
        return $this->render('carRegistration/fr/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request $request Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     * @param MailerService $mailerService
     *
     * @Route("/cartegrise_ue", methods={"GET", "POST"}, name="carRegistrationUE")
     *
     * @return              Response A Response instance
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newCarRegistrationUEAction(Request $request, FileUploaderService $fileUploaderService, MailerService $mailerService)
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

            $mailerService->sendEmail($document->getEmail(),
                $this->getParameter('mailer_user'), $document->getType(),
                $document->getType(), 'email/notification.html.twig',
                $document->getName(), $document->getPhoneNumber()
            );
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('carRegistrationUE');
        }
        return $this->render('carRegistration/ue/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request $request Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     * @param MailerService $mailerService
     *
     * @Route("/changement_adresse", methods={"GET", "POST"}, name="adressChange")
     *
     * @return              Response A Response instance
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newAdressChangeAction(Request $request, FileUploaderService $fileUploaderService, MailerService $mailerService)
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

            $mailerService->sendEmail($document->getEmail(),
                $this->getParameter('mailer_user'), $document->getType(),
                $document->getType(), 'email/notification.html.twig',
                $document->getName(), $document->getPhoneNumber()
            );
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('adressChange');

        }
        return $this->render('adressChange/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request $request Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     * @param MailerService $mailerService
     *
     * @Route("/quitus_fiscal", methods={"GET", "POST"}, name="quitus")
     *
     * @return              Response A Response instance
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newQuitusAction(Request $request, FileUploaderService $fileUploaderService, MailerService $mailerService)
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

            $mailerService->sendEmail($document->getEmail(),
                $this->getParameter('mailer_user'), $document->getType(),
                $document->getType(), 'email/notification.html.twig',
                $document->getName(), $document->getPhoneNumber()
            );
            $this->addFlash("success", "Votre demande a bien été envoyé.");

            return $this->redirectToRoute('quitus');
        }
        return $this->render('quitus/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Request $request Edit posted info
     * @param FileUploaderService $fileUploaderService Uploader Service
     * @param MailerService $mailerService
     *
     * @Route("/plaques_immatriculation", methods={"GET", "POST"}, name="plate")
     *
     * @return  Response A Response instance
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function newPlateAction(
        Request $request, FileUploaderService $fileUploaderService,
        MailerService $mailerService
    ) {
        $document = new Document();
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

            $mailerService->sendEmail($document->getEmail(),
                $this->getParameter('mailer_user'), $document->getType(),
                $document->getType(), 'email/notification.html.twig',
                $document->getName(), $document->getPhoneNumber()
            );
            $this->addFlash("success", "Votre message a bien été envoyé.");

            return $this->redirectToRoute('plate');
        }
        return $this->render('plate/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @param $priceToken
     *
     * @Route("/payer/{priceToken}", methods={"GET"}, name="payment")
     *
     * @return Response A Response Instance
     */
    public function paymentAction($priceToken)
    {
        $document = $this->getDoctrine()->getRepository(
            Document::class)->findOneBy(['priceToken' => $priceToken]);

        if ($document) {
            return $this->render('payment/index.html.twig',
                [
                    'amount' => $document->getPrice()*100,
                    'priceToken' => $document->getPriceToken(),
                    'description' => $document->getType(),
                ]);
        } else {
            $this->addFlash('danger', 'La commande n\'existe pas');

            return $this->redirectToRoute('homepage');
        }
    }


    /**
     * method payment stripe
     *
     * @param Request $request
     * @param $priceToken
     * @param MailerService $mailerService
     *
     * @Route("/paiement/{priceToken}", methods={"GET", "POST"}, name="stripeIPN")
     *
     * @return Response A Response Instance
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     */
    public function stripeAction(Request $request, $priceToken, MailerService $mailerService)
    {
        $document = $this->getDoctrine()->getRepository(
            Document::class)->findOneBy(['priceToken' => $priceToken]);
        if ($document) {
            // Set your secret key: remember to change this to your live secret key in production
            // See your keys here: https://dashboard.stripe.com/account/apikeys
            Stripe::setApiKey($this->getParameter('stripe_api_key'));

            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $token = $request->request->get('stripeToken');

            \Stripe\Charge::create([
                'amount' => $document->getPrice() * 100,
                'currency' => 'eur',
                'description' => $document->getType(),
                "source" => $token,
            ]);

            $mailerService->sendEmail(
                $document->getEmail(), $this->getParameter('mailer_user'),
                'paiement de la commande' . $document->getType(),
                'Un paiement a été éfféctué d\'un montant de <strong>' .
                $document->getPrice() . '</strong> de la part de <strong>' .
                $document->getName() . '</strong> pour la demande de <strong>' . $document->getType() . '</strong>'
                , 'email/payment.html.twig'
            );

            $mailerService->sendEmail(
                $this->getParameter('mailer_user'), $document->getEmail(),
                'paiement de la commande' . $document->getType(),
                'Bonjour ' . $document->getName() .
                '<br><br> Le paiement pour la demande de <strong>' . $document->getType() .
                '</strong> d\'un montant de <strong>' . $document->getPrice() . '</strong> a été effectué'
                , 'email/payment.html.twig'
            );

            $this->addFlash('success', 'Votre paiement a bien été pris en compte,
        un email vous a été envoyé');

            $document->setPriceToken(null);
            $this->getDoctrine()->getManager()->persist($document);
            $this->getDoctrine()->getManager()->flush();
        } else {
            $this->addFlash('danger', 'La commande n\'existe pas');
        }
        return $this->redirectToRoute('homepage');

    }
}