<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="documents")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentsRepository")
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Civility", type="string", length=8)
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="LastName", type="string", length=32)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="FirstName", type="string", length=32)
     */
    private $firstName;

    /**
     * @var string
     * @Assert\Regex(pattern="/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/", message="numéro invalide")
     *
     * @ORM\Column(name="PhoneNumber", type="string", length=16)
     */
    private $phoneNumber;

    /**
     * @var string
     * @ORM\Column(name="Email", type="string", length=64)
     */
    private $email;

    /**
     * @var float|null
     *
     * @ORM\Column(name="Price", type="float", nullable=true)
     */
    private $price;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PriceToken", type="string", length=128, nullable=true)
     */
    private $priceToken;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;

    /**
     * @var array|null
     *
     * @ORM\Column(name="licenseDriver", type="array", nullable=true)
     */
    private $licenseDriver;

    /**
     * @var array|null
     *
     * @ORM\Column(name="idCard", type="array", nullable=true)
     */
    private $idCard;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ControlT", type="string", length=128, nullable=true)
     */
    private $controlT;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ImmatRequest", type="string", length=128, nullable=true)
     */
    private $immatRequest;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Mandat", type="string", length=128, nullable=true)
     */
    private $mandat;

    /**
     * @var array|null
     *
     * @ORM\Column(name="DomJustify", type="array", nullable=true)
     */
    private $domJustify;

    /**
     * @var string|null
     *
     * @ORM\Column(name="insuranceCertificate", type="string", length=128, nullable=true)
     */
    private $insuranceCertificate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="TransferOrSales", type="string", length=128, nullable=true))
     */
    private $transferOrSales;

    /**
     * @var array|null
     *
     * @ORM\Column(name="UEConformity", type="array", nullable=true)
     */
    private $ueConformity;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Quitus", type="string", length=128, nullable=true)
     */
    private $quitus;

    /**
     * @var array
     *
     * @ORM\Column(name="CarRegistration", type="array")
     */
    private $carRegistration;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    public function __construct()
    {
        $this->setStatus(0);
        $this->setDate(new \DateTime('now'));
    }

    public function getName()
    {
        return $this->getCivility().' '.$this->getLastName(). ' '.$this->getFirstName();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * @param string $civility
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return float|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return null|string
     */
    public function getPriceToken()
    {
        return $this->priceToken;
    }

    /**
     * @param null|string $priceToken
     */
    public function setPriceToken($priceToken)
    {
        $this->priceToken = $priceToken;
    }

    /**
     * @return array|null
     */
    public function getLicenseDriver()
    {
        return $this->licenseDriver;
    }

    /**
     * @param array|null $licenseDriver
     */
    public function setLicenseDriver($licenseDriver)
    {
        $this->licenseDriver = $licenseDriver;
    }

    /**
     * @return array|null
     */
    public function getIdCard()
    {
        return $this->idCard;
    }

    /**
     * @param array|null $idCard
     */
    public function setIdCard($idCard)
    {
        $this->idCard = $idCard;
    }

    /**
     * @return null|string
     */
    public function getControlT()
    {
        return $this->controlT;
    }

    /**
     * @param null|string $controlT
     */
    public function setControlT($controlT)
    {
        $this->controlT = $controlT;
    }

    /**
     * @return null|string
     */
    public function getImmatRequest()
    {
        return $this->immatRequest;
    }

    /**
     * @param null|string $immatRequest
     */
    public function setImmatRequest($immatRequest)
    {
        $this->immatRequest = $immatRequest;
    }

    /**
     * @return null|string
     */
    public function getMandat()
    {
        return $this->mandat;
    }

    /**
     * @param null|string $mandat
     */
    public function setMandat($mandat)
    {
        $this->mandat = $mandat;
    }

    /**
     * @return array|null
     */
    public function getDomJustify()
    {
        return $this->domJustify;
    }

    /**
     * @param array|null $domJustify
     */
    public function setDomJustify($domJustify)
    {
        $this->domJustify = $domJustify;
    }

    /**
     * @return null|string
     */
    public function getInsuranceCertificate()
    {
        return $this->insuranceCertificate;
    }

    /**
     * @param null|string $insuranceCertificate
     */
    public function setInsuranceCertificate($insuranceCertificate)
    {
        $this->insuranceCertificate = $insuranceCertificate;
    }

    /**
     * @return null|string
     */
    public function getTransferOrSales()
    {
        return $this->transferOrSales;
    }

    /**
     * @param null|string $transferOrSales
     */
    public function setTransferOrSales($transferOrSales)
    {
        $this->transferOrSales = $transferOrSales;
    }

    /**
     * @return array|null
     */
    public function getUeConformity()
    {
        return $this->ueConformity;
    }

    /**
     * @param array|null $ueConformity
     */
    public function setUeConformity($ueConformity)
    {
        $this->ueConformity = $ueConformity;
    }

    /**
     * @return null|string
     */
    public function getQuitus()
    {
        return $this->quitus;
    }

    /**
     * @param null|string $quitus
     */
    public function setQuitus($quitus)
    {
        $this->quitus = $quitus;
    }

    /**
     * @return array
     */
    public function getCarRegistration()
    {
        return $this->carRegistration;
    }

    /**
     * @param array $carRegistration
     */
    public function setCarRegistration($carRegistration)
    {
        $this->carRegistration = $carRegistration;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return Document
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }
}
