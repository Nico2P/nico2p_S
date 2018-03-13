<?php

namespace AppBundle\Services\Mailer;

class SendMail
{
    private $mailer;
    private $twig;
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }
    public function sendContactMail($datas){
        $message = (new \Swift_Message('Message depuis Nico2p.com'))
            ->setFrom('send@example.com')
            ->setTo('contact@nico2p.com')
            ->setBody(
                $this->twig->render(
                    'main/contact.html.twig',
                    array('name' => $datas['name'], 'email'=>$datas['email'],'message'=>$datas['message'])
                ),
                'text/html'
            )
        ;
        $this->mailer->send($message);
    }
}