<?php

namespace App\Controller\Api\Tiers;

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
class ClientController extends FOSRestController
{
    /**
     * @Rest\Get("/tiers/client-autocomplete", name="tiers_client_autocomplete")
     * @Rest\View()
     * @param Request $request
     */
    public function autocompleteAction(Request $request)
    {
        $params = [
            'term'      => $request->query->get('term'),
            'limit'     => $request->query->get('limit'),
            'offset'    => $request->query->get('offset'),
        ];

        $clients_results = [];
        $clients = $this->getDoctrine()->getRepository('App:Tiers\Client')->searchBySociete($params);
        foreach($clients as $client){
            $clients_results[] = [
                'id'            =>  $client->getIdCweb(),
                'societe'       =>  $client->getSociete(),
            ];
        }

        return $clients_results;
    }

    /**
     * @Rest\Get("/tiers/client", name="tiers_client_list")
     * @Rest\View()
     */
    public function listAction()
    {
        $clients = $this->getDoctrine()->getRepository('App:Tiers\Client')->findAll();

        $clients_results = [];
        foreach($clients as $client){
            $clients_results[] = [
                'id'            =>  $client->getId(),
                'id_cweb'       =>  $client->getIdCweb(),
                'societe'       =>  $client->getSociete(),
                'categorie'     =>  $client->getCategorie(),
                'siret'         =>  $client->getSiret(),
                'naf'           =>  $client->getNaf(),
                'ville'         =>  $client->getVille(),
                'code_postal'   =>  $client->getCodePostal(),
                'adresse'       =>  $client->getAdresse(),
            ];
        }

        return $clients_results;
    }

    /**
     * @Get(
     *     path = "/tiers/client/{id_cweb}",
     *     name = "tiers_client_show",
     *     requirements = {"id_cweb"="\d+"}
     * )
     * @View
     * 
     */
    public function showAction($id_cweb)
    {
        $client = $this->getDoctrine()->getRepository('App:Tiers\Client')->findOneBy([
            'id_cweb' => $id_cweb,
        ]);

        $client_result = [
            'id'            =>  $client->getId(),
            'id_cweb'       =>  $client->getIdCweb(),
            'societe'       =>  $client->getSociete(),
            'categorie'     =>  $client->getCategorie(),
            'siret'         =>  $client->getSiret(),
            'naf'           =>  $client->getNaf(),
            'ville'         =>  $client->getVille(),
            'code_postal'   =>  $client->getCodePostal(),
            'adresse'       =>  $client->getAdresse(),
        ];

        return $client_result;
    }

}