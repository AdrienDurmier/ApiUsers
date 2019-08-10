<?php

namespace App\Controller\Api\Tiers;

use App\Entity\Tiers\Site;
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
class SiteController extends FOSRestController
{
    /**
     * @Rest\Get("/tiers/sites/{id_cweb_client}", name="tiers_site_list")
     * @Rest\View()
     */
    public function listAction($id_cweb_client)
    {
        $client = $this->getDoctrine()->getRepository('App:Tiers\Client')->findOneBy([
            'id_cweb' => $id_cweb_client
        ]);
        $sites = $this->getDoctrine()->getRepository('App:Tiers\Site')->findByClient($client);

        $results = [];
        foreach($sites as $site){
            $results[] = [
                'id'                =>  $site->getId(),
                'id_cweb'           =>  $site->getIdCweb(),
                'societe'           =>  $site->getSociete(),
                'adresse'           =>  $site->getAdresse(),
                'code_postal'       =>  $site->getCodePostal(),
                'ville'             =>  $site->getVille(),
                'siret'             =>  $site->getSiret(),
                'naf'               =>  $site->getNaf(),
                'horaire'           =>  $site->getHoraire(),
                'client_id_cweb'    =>  $site->getClient()->getIdCweb(),
            ];
        }

        return $results;
    }

    /**
     * @Get(
     *     path = "/tiers/site/{id}",
     *     name = "tiers_site_show"
     * )
     * @View
     * 
     */
    public function showAction($id)
    {
        $site = $this->getDoctrine()->getRepository('App:Tiers\Site')->findOneBy([
            'id' => $id,
        ]);

        $result = [
            'id'            =>  $site->getId(),
            'id_cweb'       =>  $site->getIdCweb(),
            'societe'       =>  $site->getSociete(),
            'adresse'       =>  $site->getAdresse(),
            'code_postal'   =>  $site->getCodePostal(),
            'ville'         =>  $site->getVille(),
            'siret'         =>  $site->getSiret(),
            'naf'           =>  $site->getNaf(),
            'horaire'       =>  $site->getHoraire(),
            'client'        =>  $site->getClient(),
        ];

        return $result;
    }

}