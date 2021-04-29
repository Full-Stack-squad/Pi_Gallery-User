<?php

namespace App\Controller;

use App\Entity\Userr;
use App\Repository\UserrRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserrController extends AbstractController
{
    /**
     * @Route("/userr", name="userr_index" ,  methods={"GET"})
     */
    public function index(UserrRepository $userrRepository): Response
    {
        return $this->render('userr/index.html.twig', [
            'users' => $userrRepository->findAll()
        ]);
    }


    /**
     * @Route("/deconnexion", name="deconn", methods={"GET"})
     */
    public function dec(UserrRepository $userrRepository): Response
    { session_abort();
        return $this->render('userr/index.html.twig', [
            'users' => $userrRepository->findAll()
        ]);
    }


    /**
     * @Route("/connexion", name="user_login" , methods={"GET","POST"})
     */
    public function login  (Request $request): Response
    {   $user = new Userr();
        $user->setNom("static");
        $user->setPrenom("static");

        $form = $this->createForm(connexionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $verifexite=$this->getDoctrine()->getRepository(Userr::class)->findOneBy([
                'mail'=>$user->getEmail(),'mdp'=>$user->getPassword()
            ]);

            if(is_null($verifexite)){
                return $this->render('userr/message.html.twig');
            }if($verifexite->getRole()=="Membre") {

                return $this->redirectToRoute('user_index',array('id'=>$verifexite->getId()));
            }
            elseif ($verifexite->getRole()=="admin"){
                return $this->redirectToRoute('user_index1'); }

        }


        return $this->render('userr/login.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/forgotmdp", name="user_mailing", methods={"POST"})
     */

     // public function mailing(Request $request,\Swift_Mailer $mailer): Response
    //  {
       // $value = $request->request->get('mail');


       // $message = (new \Swift_Message('Hello Email'))
            // ->setFrom('sf.hlk358@gmail.com')
             // ->setTo($value)
           // ->setBody(
              //  $this->renderView(
                // templates/emails/registration.html.twig
                  //  'user/message.html.twig'

               // )

           // );
        // $this->addFlash('nic', 'hello');
       // $mailer->send($message);



       // return $this->render('user/forgotPasswd.html.twig');
    //}


}
