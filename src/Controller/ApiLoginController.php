<?php

namespace App\Controller;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Core\Security;

class ApiLoginController extends AbstractController
{

    /**
     * @var Security
     */
    private $security;

    /**
     * @Route("/api/login", name="api_login")
     */
    public function index(Security $security)
    {
        $this->security = $security;
        $user = $this->security->getUser();

        
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ]);
        }

        $token = ""; // somehow create an API token for $user

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php',
            'user'  => $user->getUserIdentifier(),
            'token' => $token,
        ]);
    }
}
