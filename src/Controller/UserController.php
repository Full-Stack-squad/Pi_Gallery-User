<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\User;
use App\Form\ChangePwsdFormType;
use App\Form\UserFormType;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use App\Repository\UserrRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class UserController extends AbstractController
{

    private $userRepository;
    private $passwordEncoder;

    private $entityManager;
    private $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository,
                                UserPasswordEncoderInterface $passwordEncoder,
                                EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
        $this->roleRepository = $roleRepository;
    }


    /**
     * @Route("/userrr", name="userrr_index" ,  methods={"GET"})
     */
    public function indexx(UserrRepository $userrRepository): Response
    {
        return $this->render('userr/indexx.html.twig', [
            'users' => $userrRepository->findAll()
        ]);
    }


    /**
     * @Route("/deconnexion", name="deconn", methods={"GET"})
     */
    public function dec(UserrRepository $userrRepository): Response
    {
        session_abort();
        return $this->render('userr/index.html.twig', [
            'users' => $userrRepository->findAll()
        ]);
    }


    /**
     * @Route("/connexion", name="user_login" , methods={"GET","POST"})
     */
    public function login(Request $request): Response
    {
        $user = new User();
        $user->setNom("static");
        $user->setPrenom("static");

        $form = $this->createForm(connexionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $verifexite = $this->getDoctrine()->getRepository(User::class)->findOneBy([
                'mail' => $user->getEmail(), 'mdp' => $user->getPassword()
            ]);

            if (is_null($verifexite)) {
                return $this->render('userr/message.html.twig');
            }
            if ($verifexite->getRole() == "Membre") {

                return $this->redirectToRoute('user_index', array('id' => $verifexite->getId()));
            } elseif ($verifexite->getRole() == "admin") {
                return $this->redirectToRoute('user_index1');
            }

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

    /**
     * @Route("/admin/user",name="app_admin_users")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function users()
    {
        $users = $this->userRepository->findAll();
        return $this->render("admin/user/user.html.twig", ["users" => $users]);
    }

    /**
     * @Route("/admin/user/new",name="app_admin_new_user")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function newUser(Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(UserFormType::class, null, ["translator" => $translator]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var  User $user */
            $user = $form->getData();
            $password = $form["plainpassword"]->getData();
            /** @var Role $role */
            $role = $form["role"]->getData();
            $user->setEnable(true)
                ->setPassword($this->passwordEncoder->encodePassword($user, $password))
                ->setRoles([$role]);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash("success", $translator->trans('backend.user.add_user'));
            return $this->redirectToRoute("app_admin_users");
        }
        return $this->render("admin/user/userform.html.twig", ["userForm" => $form->createView()]);
    }

    /**
     * @Route("/admin/user/edit/{id}",name="app_admin_edit_user")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function editUser(User $user, Request $request, TranslatorInterface $translator)
    {
        $form = $this->createForm(UserFormType::class, $user, ["translator" => $translator]);
        $form->get('plainpassword')->setData($user->getPassword());
        $therole = $this->roleRepository->findOneBy(["name" => $user->getRoles()[0]]);
        $form->get('role')->setData($therole);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Role $role */
            $role = $form["role"]->getData();
            $password = $form["plainpassword"]->getData();
            $user->setRoles([$role]);
            if ($user->getPassword() != $password) {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            }
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash("success", $translator->trans('backend.user.modify_user'));
            return $this->redirectToRoute("app_admin_users");
        }
        return $this->render("admin/user/userform.html.twig", ["userForm" => $form->createView()]);
    }

    /**
     * @Route("/admin/user/changevalidite/{id}",name="app_admin_changevalidite_user",methods={"post"})
     * @IsGranted("ROLE_SUPERUSER")
     * @throws \Doctrine\ORM\ORMException
     */
    public function activate(User $user): JsonResponse
    {
        $user = $this->userRepository->updateStatus($user);
        return $this->json(["message" => "success", "value" => $user->isEnable()]);
    }

    /**
     * @Route("/admin/user/delete/{id}",name="app_admin_delete_user")
     * @IsGranted("ROLE_SUPERUSER")
     * @throws \Doctrine\ORM\ORMException
     */
    public function delete(User $user): JsonResponse
    {
        $this->userRepository->delete($user);
        /*$this->addFlash("success", "Utilisateur supprimé");
        return $this->redirectToRoute('app_admin_users');*/
        return $this->json(["message" => "success", "value" => true]);
    }

    /**
     * @Route("/admin/user/changePassword",name="app_admin_changepswd")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function changePswd(Request $request, TranslatorInterface $translator)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePwsdFormType::class, $user, ["translator" => $translator]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $form["plainpassword"]->getData();
            $newPassword = $form["newpassword"]->getData();

            if ($this->passwordEncoder->isPasswordValid($user, $password)) {
                $user->setPassword($this->passwordEncoder->encodePassword($user, $newPassword));
            } else {
                $this->addFlash("error", $translator->trans('backend.user.new_passwod_must_be'));
                return $this->render("admin/params/changeMdpForm.html.twig", ["passwordForm" => $form->createView()]);
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash("success", $translator->trans('backend.user.changed_password'));
            return $this->redirectToRoute("app_admin_index");
        }
        return $this->render("admin/params/changeMdpForm.html.twig", ["passwordForm" => $form->createView()]);
    }

    /**
     * @Route("/admin/user/groupaction",name="app_admin_groupaction_user")
     * @IsGranted("ROLE_SUPERUSER")
     */
    public function groupAction(Request $request, TranslatorInterface $translator): JsonResponse
    {
        $action = $request->get("action");
        $ids = $request->get("ids");
        $users = $this->userRepository->findBy(["id" => $ids]);

        if ($action == $translator->trans('backend.user.deactivate')) {
            foreach ($users as $user) {
                $user->setEnable(false);
                $this->entityManager->persist($user);
            }
        } else if ($action == $translator->trans('backend.user.Activate')) {
            foreach ($users as $user) {
                $user->setEnable(true);
                $this->entityManager->persist($user);
            }
        } else {
            return $this->json(["message" => "error"]);
        }
        $this->entityManager->flush();
        return $this->json(["message" => "success", "nb" => count($users)]);
    }
}
