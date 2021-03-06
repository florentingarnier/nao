<?php
/**
 * Created by PhpStorm.
 * User: aigie
 * Date: 05/12/2016
 * Time: 13:38
 */

namespace Gsquad\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     * @Security("has_role('ROLE_REDACTEUR') or has_role('ROLE_CHERCHEUR')")
     */
    public function homeAction()
    {
        return $this->render('admin/home.html.twig');
    }

    /**
     * @Route("/mailing", name="mailing")
     * @Security("has_role('ROLE_SUPER_ADMIN')")
     */
    public function mailingAction(Request $request)
    {
        $users = $this->getDoctrine()->getRepository('GsquadUserBundle:User')->findAll();
        $adherents = $this->getDoctrine()->getRepository('GsquadUserBundle:User')->getUsersByRole('ROLE_ADHERENT');
        $chercheurs = $this->getDoctrine()->getRepository('GsquadUserBundle:User')->getUsersByRole('ROLE_CHERCHEUR');
        $admins = $this->getDoctrine()->getRepository('GsquadUserBundle:User')->getUsersByRole('ROLE_ADMIN');

        $formType = 'Gsquad\AdminBundle\Form\Type\MailingType';
        $form = $this->get('form.factory')->create($formType);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $emails = explode(',', $data['email']);

            $this->get('gsquad.mailer')->sendMailing($data, $emails);

            $this->addFlash('info', 'Votre message a été envoyé.');
            return $this->redirectToRoute('mailing');
        }

        return $this->render('admin/mailing/mailing.html.twig', array(
            'users' => $users,
            'adherents' => $adherents,
            'chercheurs' => $chercheurs,
            'admins' => $admins,
            'form' => $form->createView()
        ));
    }
}
