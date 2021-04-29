<?php

namespace App\Controller;
use App\Entity\Abonnement2;
use App\Entity\Photo;
use App\Entity\User;
use App\Form\PhotoAddFormType;
use App\Repository\AbonnementRepository;
use App\Repository\PhotoRepository;
use App\Repository\UserRepository;
use App\Repository\UserrRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;





class PhotoController extends AbstractController
{
    /**
     * @Route("/photo", name="photo")
     */
    public function index(): Response
    {
        return $this->render('photo/index.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }

    /**
     * @Route ("/photo/main")
     */
    public function index1(): Response
    {
        return $this->render('photo/Main.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }
    /**
     * @Route ("/photo/tmp")
     */
    public function index2(): Response
    {
        return $this->render('photo/templateBack.html.twig');
    }

    /**
     * @Route("/photo/gallerie", name="photoGall")
     * @return Response
     */
    public function Gallerie()
    {
        return $this->render('photo/Gallerie.html.twig', [
            'controller_name' => 'PhotoController',
        ]);
    }


    /**
     * @Route("/photo/follow", name="fl" )
     * @param AbonnementRepository $arep
     * @param Request $req
     * @return Response
     */
    public function addfollowing(AbonnementRepository $arep, Request $req )
    { $abonnement2 = new Abonnement2();
    $abonnement2->setAnom($this->getUser()->getNom());
    $abonnement2->setIda($this->getUser()->getIdu());
    $abonnement2->setIdu(2);
    $abonnement2->setNoma("chaima omami");
    $em= $this->getDoctrine()->getManager();
    $em->persist($abonnement2);
    $em->flush();

        return $this->redirect($req->server->get('HTTP_REFERER'));
    }

    /**
     * @Route("/photo/unfollow/{id}", name="dl" )
     * @param AbonnementRepository $arep
     * @param Request $req
     * @return Response
     * @param $id
     */
    public function deletefollowing(AbonnementRepository $arep, Request $req , $id )
    { $abonnement2 =$arep->find(6);

        $em= $this->getDoctrine()->getManager();
        $em->remove($abonnement2);
        $em->flush();

        return $this->redirect($req->server->get('HTTP_REFERER'));
    }
    /**
     * @Route("/photo/add",name="recherche_nsc")
     * @param Request $req
     * @param PaginatorInterface $paginator
     * @param UserRepository $urep
     * @param PhotoRepository $prep
     * @return Response
     */
    public function addPhoto(Request $req, UserRepository $urep,PhotoRepository $prep,PaginatorInterface $paginator): Response
    {

        $users=$urep->find(24);
        $Photo = new Photo();
        $form = $this->createForm(PhotoAddFormType::class, $Photo);
        $Photo->setIdu($this->getUser());
        $Photo->setDateAjout(date("Y/m/d"));
        $form->handleRequest($req);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['url']->getData();
            $directory=".\assets\images";
            $file->move($directory, $file->getClientOriginalName());
            $Photo->setUrl($directory."\\".$file->getClientOriginalName());

            $Photo->setCouleur($form['couleur']->getData());
            $Photo->setTheme($form['theme']->getData());
            $Photo->setLocalisation($form['localisation']->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($Photo);
            $em->flush();
        }
        $donnees=$prep->UserhPhoto($this->getUser()->getIdU());
            $Pics= $paginator->paginate(
                $donnees,
                $req->query->getInt('page',1),
                3
            );


        return $this->render('photo/Gallerie.html.twig',[
            'tab' => $Pics,
            'f1' => $form->createView(),
            'user'=> $users,
        ]);

    }



    /**
     * @param PhotoRepository $rep
     * @param Request $req
     * @return Response
     * @Route ("/photo/discover",name="rechercheP")
     */
        public function Search(PhotoRepository $rep, Request $req, PaginatorInterface $paginator){
            $data=$req->get('tfrech');
            $donnees=$rep->searchPhoto($data);
            $photos= $paginator->paginate(
                $donnees,
                $req->query->getInt('page',1),
                3
            );
            return $this->render("photo/Discover.html.twig",["tab"=>$photos]);


        }

    /**
     * @param PhotoRepository $prep
     * @param $id
     * @param Request $req
     * @return Response
     * @Route ("/photo/showOne/{id}",name="ShowPic")
     */
    public function ShowPhoto(PhotoRepository $prep, $id, Request $req){
        $Photo=$prep->find($id);

        $form = $this->createFormBuilder($Photo)
            ->add('titre')
            ->add('theme')
            ->add('couleur',ColorType::class,[
                'attr' => ['class' => 'form-control form-control-color'],
            ])
            ->add('Modifier', SubmitType::class,[
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ->getForm();
        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {

            $em=$this->getDoctrine()->getManager();

            $em->flush($Photo);

            return $this->redirectToRoute('rechercheP');
        }

        return $this->render("photo/ShowPhoto.html.twig",array(
            "pic"=>$Photo,
            'f1' => $form->createView(),
        ));
    }

    /**
     * @param PhotoRepository $prep
     * @param $id
     * @param Request $req
     * @return Response
     * @Route ("/photo/DeleteOne/{id}",name="DeletePic")
     */
    public function DeletePhoto(PhotoRepository $prep, $id, Request $req){
        $Photo=$prep->find($id);
        $Pics=$prep->findAll();

        $em=$this->getDoctrine()->getManager();
        $em->remove($Photo);
        $em->flush();



        return $this->redirectToRoute('recherche_nsc');
    }


    /**
     * @param PhotoRepository $prep
     * @param Request $req
     * @return Response
     * @Route ("/photo/photoback")
     */
    public function ShowPhotoBack(PhotoRepository $prep, Request $req, PaginatorInterface $paginator){

        $donnees=$prep->findAll();
        $Pics= $paginator->paginate(
            $donnees,
            $req->query->getInt('page',1),
            4
        );
        return $this->render("photo/photoback.html.twig",[ "pic"=>$Pics]);

    }
    /**
     * @param PhotoRepository $prep
     * @param $id
     * @param Request $req
     * @return Response
     * @Route ("/photo/Deleteback/{id}",name="Deleteback")
     */
    public function DeletePhotoback(PhotoRepository $prep, $id, Request $req, \Swift_Mailer $mailer){
        $Photo=$prep->find($id);
        $Pics=$prep->findAll();
        $message= (new \Swift_Message('Alert'))
            ->setFrom('jlassi.med.yacine@gmail.com')
            ->setTo($this->getUser()->getEmail())
            ->setBody(
                'Photo supprimé'."  ".$Photo->getTitre(),
                'text/html'
            )
        ;
        $mailer->send($message);
        $this->addFlash('message',' est envoyé');

        $em=$this->getDoctrine()->getManager();
        $em->remove($Photo);
        $em->flush();



        return $this->redirect($req->server->get('HTTP_REFERER'));
    }


}