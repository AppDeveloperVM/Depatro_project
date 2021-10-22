<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/login_api", name="app_login_api")
     */
    public function ajaxAction(Request $request,UserPasswordEncoderInterface $encoderService) : Response {  
        
           
        if ($request->isXmlHttpRequest() ) {  
            
            $user = new User();
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            //$encoderService = $this->container->get('security.password_encoder');
            $user->setPassword($encoderService->encodePassword($user,$password));
            

            $em = $this->getDoctrine()->getManager(); 
            $user_db = $em->getRepository(User::class)->findOneBySomeField($email);

            $is_pass_valid = $encoderService->isPasswordValid( $user, $password );
          
            if($user_db != null && $is_pass_valid != false){

               $response = new JsonResponse(['user' => $user_db->getNombre(),'status' => 'success'] );
               
               return $response;
               
            }else{

               $response = new JsonResponse(['status' => 'error'] );
               return $response;
            }
          


        } else { 
         return $this->render('security/login.html.twig');
        } 
     } 
    
     

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
