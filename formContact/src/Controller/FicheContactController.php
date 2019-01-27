<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FicheType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class FicheContactController extends Controller
{
    public function form(Request $request)
    {
        $result = new User();
        $formContact = $this->createForm(FicheType::class, $result);
        $formContact->handleRequest($request);
        if ($formContact->isSubmitted() && $formContact->isValid())
        {
            $result = $formContact->getData();
            $this->getDoctrine()->getManager()->persist($result);
            $this->getDoctrine()->getManager()->flush();
            $this->sendMail($result);
        }
            return $this->render('fiche_contact/index.html.twig', [
                'form' => $formContact->createView(),
        ]);
    }

    public function sendMail(User $user)
    {
        $mailer = $this->get('mailer');
        $message = (new \Swift_Message($user->getObject()))
            ->setFrom($user->getMail())
            ->setTo([$user->getCatId()->getFirstMail(), $user->getCatId()->getSecondMail()])
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
