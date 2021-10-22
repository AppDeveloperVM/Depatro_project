<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authenticator\Token;

use Symfony\Component\Security\Core;


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
    public function ajaxAction(Request $request,UserPasswordEncoderInterface $encoderService,
                                LoginFormAuthenticator $login_form_auth,AuthenticationUtils $authenticationUtils ) : Response {  
        
        //Token $post_auth
        
           
        if ($request->isXmlHttpRequest() ) {  
            
            $user = new User();
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            //$encoderService = $this->container->get('security.password_encoder');
    

            $em = $this->getDoctrine()->getManager(); 
            $user_db = $em->getRepository(User::class)->findOneBySomeField($email);

            $encoded_pass = $encoderService->encodePassword($user,$password);
            $user->setPassword($encoded_pass);

            $is_pass_valid = $encoderService->isPasswordValid( $user_db, $password );
          
            if($user_db != null && $is_pass_valid == true){

                $session = $request->getSession();
                $session->set('user', $user);

                $login_form_auth->authenticate($request);

                $firewallName = 'main';
                //$auth = new $post_auth($user,$firewallName,$user_db->getRoles()); // trying to create token for session

                $response = new JsonResponse(['user' => $user_db->getNombre(),'password' => $encoded_pass,'status' => 'success'] );
               
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
