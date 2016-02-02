<?php
namespace AppBundle\Controller;
use AppBundle\Entity\profesor;
use AppBundle\Form\ProfesorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class ProfesorController extends Controller
{
    /**
     *  indexAction
     *
     * @Route(path="/", name="app_profesor_index")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Profesor');
        $profesor = $repository->findAll();
        //die;
        return $this->render('profesor/index.html.twig',
            [
                'profesor' => $profesor,
            ]
        );
    }
    /**
     * @Route("/update/{id}", name="app_profesor_update")
     */
    public function  updateAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Profesor');
        $profesor = $repository->find($id);
        $form = $this->createForm(ProfesorType::class, $profesor);

        return $this->render('profesor/form.html.twig',
            [
                'form'     => $form->createView(),
                'action'   => $this->generateUrl('app_profesor_doupdate', ['id' => $id]),
            ]
        );
    }
    /**
     * @Route(path="/doupdate/{id}", name="app_profesor_doupdate")
     * @param Request $request
     */
    public function doUpdateAction($id, Request $request)
    {
        $m = $this->getDoctrine()->getManager();
        $profesor = $m->getRepository('AppBundle:Profesor')->find($id);
        $form = $this->createForm(ProfeType::class, $profesor);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $m->flush();
            $this->addFlash('messages', 'Profesor Updated');
            return $this->redirectToRoute('app_profesor_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':profesor:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_profesor_doinsert')
            ]
        );
    }
    /**
     * @Route(path="/insert", name="app_profesor_insert")
     */
    public function insertAction()
    {
        $profesor = new Profesor();
        $form = $this->createForm(ProfesorType::class, $profesor);
        return $this->render(':producto:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    =>$this->generateUrl('app_profesor_doinsert')
            ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(path="/done", name="app_profesor_doinsert")
     */
    public function doInsertAction(Request $request)
    {
        $profesor = new Profesor();
        $form = $this->createForm(ProfesorType::class, $profesor);
        $form->handleRequest($request);
        if ($form->isValid())
        {
            $m = $this->getDoctrine()->getManager();
            $m->persist($profesor);
            $m->flush();
            $this->addFlash('messages', 'Profesor added');
            return $this->redirectToRoute('app_profesor_index');
        }
        $this->addFlash('messages', 'Review your form data');
        return $this->render(':profesor:form.html.twig',
            [
                'form'      => $form->createView(),
                'action'    => $this->generateUrl('app_profesor_doinsert')
            ]
        );
    }
    /**
     *
     * @Route(name="app_profesor_remove", path="/remove/{id}")
     */
    public function removeAction($id)
    {
        $m = $this->getDoctrine()->getManager();
        $repository = $m->getRepository('AppBundle:Profesor');
        $profesor = $repository->find($id);
        $m->remove($profesor);
        $m->flush();
        $this->addFlash('messages', 'Profesor has been removed');
        return $this->redirectToRoute('app_profesor_index');
    }
}
