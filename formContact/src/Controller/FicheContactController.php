<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\User;
use App\Form\FicheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FicheContactController extends Controller
{
    public function form(Request $request)
    {
        $user = new User();
        $formContact = $this->createForm(FicheType::class);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid())
        {
            $result = $formContact->getData();
            $user->setLastName($result['lastName']);
            $user->setFirstName($result['firstName']);
            $user->setMail($result['mail']);
            $user->setObject($result['object']);
            $user->setText($result['message']);
            $contact = $result['contact'];
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->sendMail($user, $contact);
        }
            return $this->render('fiche_contact/index.html.twig', [
                'form' => $formContact->createView(),
        ]);
    }

    public function sendMail(User $user, Contact $contact)
    {
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message($user->getObject()))
            ->setFrom($user->getMail())
            ->setTo([$contact->getFirstMail(), $contact->getSecondMail()])
            ->setBody(
                $this->renderView(
                    'fiche_contact/email.html.twig',
                    ['text' => $user->getText()]
                ),
                'text/html'
            )
        ;
        $mailer->send($message);
    }
}