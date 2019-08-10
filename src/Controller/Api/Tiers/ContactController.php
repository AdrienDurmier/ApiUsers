<?php

namespace App\Controller\Api\Tiers;

use App\Entity\Tiers\Contact;
use App\Entity\Tiers\Client;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

/**
 * @Route("/")
 */
class ContactController extends FOSRestController
{
    /**
     * @Rest\Get("/tiers/contacts/{id_cweb_client}", name="tiers_contact_list")
     * @Rest\View()
     */
    public function listAction($id_cweb_client)
    {
        $contacts = $this->getDoctrine()->getRepository('App:Tiers\Contact')->searchByClient($id_cweb_client);
        
        $results = [];
        foreach($contacts as $contact){
            $results[] = [
                'id'            =>  $contact->getId(),
                'firstname'     =>  $contact->getFirstname(),
                'lastname'      =>  $contact->getLastname(),
                'telephone'     =>  $contact->getTelephone(),
                'mobile'        =>  $contact->getMobile(),
                'email'         =>  $contact->getEmail(),
                'fonction'      =>  $contact->getFonction(),
                'site'          =>  [
                    'id'            =>  ($contact->getSite() !== null)?$contact->getSite()->getId():null,
                    'id_cweb'       =>  ($contact->getSite() !== null)?$contact->getSite()->getIdCweb():null,
                    'societe'       =>  ($contact->getSite() !== null)?$contact->getSite()->getSociete():null,
                ],
            ];
        }

        return $results;
    }

    /**
     * @Get(
     *     path = "/tiers/contact/{id}",
     *     name = "tiers_contact_show"
     * )
     * @View
     * 
     */
    public function showAction($id)
    {
        $contact = $this->getDoctrine()->getRepository('App:Tiers\Contact')->findOneBy([
            'id' => $id,
        ]);

        $result = [
            'id'            =>  $contact->getId(),
            'firstname'     =>  $contact->getFirstname(),
            'lastname'      =>  $contact->getLastname(),
            'telephone'     =>  $contact->getTelephone(),
            'mobile'        =>  $contact->getMobile(),
            'email'         =>  $contact->getEmail(),
            'fonction'      =>  $contact->getFonction(),
            'site'          =>  [
                'id'            =>  ($contact->getSite() !== null)?$contact->getSite()->getId():null,
                'id_cweb'       =>  ($contact->getSite() !== null)?$contact->getSite()->getIdCweb():null,
                'societe'       =>  ($contact->getSite() !== null)?$contact->getSite()->getSociete():null,
            ],
        ];

        return $result;
    }

}