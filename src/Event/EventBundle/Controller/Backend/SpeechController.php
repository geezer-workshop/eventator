<?php

namespace Event\EventBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Event\EventBundle\Controller\Controller;
use Event\EventBundle\Entity\Speech;
use Event\EventBundle\Entity\Translation\SpeechTranslation;
use Event\EventBundle\Form\Type\SpeechType;

class SpeechController extends Controller
{
    public function indexAction()
    {
        return $this->render('EventEventBundle:Backend/Speech:index.html.twig', array(
            'speeches' => $this->getRepository('EventEventBundle:Speech')->findAll()
        ));
    }

    public function manageAction(Request $request, $id = null)
    {
        if ($id === null) {
            $entity = new Speech();
            $entity = $this->initObjectLocales($entity, new SpeechTranslation());
        } else {
            $entity = $this->findOr404('EventEventBundle:Speech', $id);
        }

        $form = $this->createForm(SpeechType::class, $entity);

        if ($request->getMethod() === 'POST') {
            $form->submit($request);

            if ($form->isValid()) {
                $this->getManager()->persist($entity);
                $this->getManager()->flush();

                $successFlashText = sprintf('Speech %s updated.', $entity->getTitle());
                if (!$id) {
                    $successFlashText = sprintf('Speech %s added.', $entity->getTitle());
                }
                $this->setSuccessFlash($successFlashText);

                return $this->redirectToRoute('backend_speech');
            }
        }

        return $this->render('EventEventBundle:Backend/Speech:manage.html.twig', [
            'speech' => $entity,
            'form' => $form->createView(),
            'configLocales' => $this->container->getParameter('event.locales')
        ]);
    }

    public function deleteAction($id)
    {
        $this->isGrantedAdmin();

        $entity = $this->findOr404('EventEventBundle:Speech', $id);
        $this->getManager()->remove($entity);
        $this->getManager()->flush();

        $this->setSuccessFlash('Speech deleted.');

        return $this->redirectToRoute('backend_speech');
    }
}
