<?php

namespace App\Controller;

use App\Entity\User;
use DateTime;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // verify if the email is already used - does not work so far - no flashMessage
        $userExist = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
        if ($userExist) {
            $this->addFlash(
                'danger',
                "Cet email est déjà utilisé. Rendez-vous sur la page de connexion
                pour réinitialiser votre mot de passe."
            );
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // verify if the user is over 18
            $userBirthday = $user->getBirthday();
            if ($userBirthday !== null) {
                $currentDate = new DateTime('now');
                $diff = $currentDate->diff($userBirthday);
            //  dd($userBirthday, $currentDate, $diff->y);

                if ($diff->y < 18) {
                    $this->addFlash('danger', 'Vous devez avoir plus de 18 ans pour vous inscrire');
                    return $this->redirectToRoute('app_register');
                }
            } else {
                return $this->redirectToRoute('app_register');
            }



            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user, (
            new TemplatedEmail())
                ->from(new Address('contact@inovin.com', 'Equipe Inovin'))
                ->to($user->getEmail())
                ->subject('Merci De Confirmer Votre Email')
                ->context([
                    'firstname' => $user->getFirstname(),
                ])
                ->htmlTemplate('registration/confirmation_email.html.twig'));
            // do anything else you need here, like send an email

            $this->addFlash(
                'success',
                'Votre profil a bien été créé. Rendez-vous sur votre boite mail pour vérifier votre compte'
            );
                $this->authenticateUser($user);
            return $this->redirectToRoute('gout_new');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre email a bien été vérifié.');

        return $this->redirectToRoute('app_register');
    }

    public function authenticateUser(User $user): void
    {
        $providerKey = 'main';
        $token = new UsernamePasswordToken($user, $providerKey, $user->getRoles());
        $this->container->get('security.token_storage')->setToken($token);
    }
}
