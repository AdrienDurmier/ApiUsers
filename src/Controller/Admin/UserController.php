<?php
namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @Route("/admin/user", name="user.index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'users' =>  $users
        ]);
    }

    /**
     * @Route("/admin/user/new", name="user.new", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function new(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $valeurs_recu = $request->request->all();
            $user = new User();
            $user->setUsername($valeurs_recu['email']);
            $user->setEmail($valeurs_recu['email']);
            $user->setPassword($this->encoder->encodePassword($user, $valeurs_recu['password']));
            $user->setEnabled(isset($valeurs_recu['enabled'])?$valeurs_recu['enabled']:0);
            foreach($valeurs_recu['roles'] as $role):
                $user->addRole($role);
            endforeach;
            $em->persist($user);
            $em->flush();
            
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "Utilisateur créé avec succès");
            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/new.html.twig');
    }

    /**
     * @Route("/admin/user/edit/{id}", name="user.edit", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(User $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $valeurs_recu = $request->request->all();
            $user->setUsername($valeurs_recu['email']);
            $user->setEmail($valeurs_recu['email']);
            $user->setEnabled(isset($valeurs_recu['enabled'])?$valeurs_recu['enabled']:0);
            foreach($user->getRoles() as $role):
                $user->removeRole($role);
            endforeach;
            if(isset($valeurs_recu['roles'])):
                foreach($valeurs_recu['roles'] as $role):
                    $user->addRole($role);
                endforeach;
            endif;
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "Utilisateur créé avec succès");
            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/edit.html.twig', [
            'user'      =>  $user,
        ]);
    }

    /**
     * @Route("/admin/user/password/{id}", name="user.password", methods="GET|POST")
     * @param User $user
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function password(User $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $valeurs_recu = $request->request->all();
            $user->setPassword($this->encoder->encodePassword($user, $valeurs_recu['password']));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', "Mot de passe modifié avec succès");
            return $this->redirectToRoute('user.index');
        }

        return $this->render('user/password.html.twig', [
            'user'      =>  $user,
        ]);
    }

    /**
     * @Route("/admin/user/{id}", name="user.delete", methods="DELETE")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(User $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))){
            $em->remove($user);
            $em->flush();
            $this->addFlash('success', "Utilisateur supprimé avec succès");
        }
        return $this->redirectToRoute('user.index');
    }

    /**
     * @Route("/admin/user/map", name="user.map")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function map()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        $roles = $this->getParameter('security.role_hierarchy.roles');

        return $this->render('user/map.html.twig', [
            'roles' =>  $roles
        ]);
    }
}