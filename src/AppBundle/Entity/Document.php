<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
}
