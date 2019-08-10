<?php

namespace App\Controller\Api;

use App\Entity\User;
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
class UserController extends FOSRestController
{
    /**
     * @Rest\Get("/users", name="app_user_list")
     * @Rest\View()
     * @param Request $request
     */
    public function listAction(Request $request)
    {
        $params = json_decode(
            $request->getContent(),
            true
        );
        
        $users = $this->getDoctrine()->getRepository('App:User')->findAll();

        $users_results = [];

        foreach($users as $user){

            if($request->query->get('role') !== null){
                if (!$user->hasRole($request->query->get('role'))){
                    continue;
                }
            }

            $users_results[] = [
                'id'        =>  $user->getId(),
                'username'  =>  $user->getUsername(),
                'firstname' =>  $user->getFirstname(),
                'lastname'  =>  $user->getLastname(),
                'email'     =>  $user->getEmail(),
                'roles'     =>  $user->getRoles(),
            ];
        }

        return $users_results;
    }

    /**
     * @Get(
     *     path = "/users/{username}",
     *     name = "app_user_show",
     *     requirements = {"id"="\d+"}
     * )
     * @View
     * 
     */
    public function showAction($username)
    {
        $user = $this->getDoctrine()->getRepository('App:User')->findOneByUsername($username);

        $user_result = [
            'id'        =>  $user->getId(),
            'username'  =>  $user->getUsername(),
            'firstname' =>  $user->getFirstname(),
            'lastname'  =>  $user->getLastname(),
            'email'     =>  $user->getEmail(),
            'roles'     =>  $user->getRoles(),
        ];

        return $user_result;
    }

}