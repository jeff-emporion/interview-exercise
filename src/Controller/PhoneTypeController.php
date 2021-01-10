<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\PhoneType;
use App\Form\PhoneTypeType;
use App\Repository\PhoneTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PhoneTypeController extends AbstractController
{
    /**
     * @Route("phoneType", name="phone_type_index", methods={"GET"})
     */
    public function indexAction(PhoneTypeRepository $phoneTypeRepository): Response
    {
        return $this->render('phone_type/index.html.twig', [
            'phone_types' => $phoneTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("phoneType/new", name="phone_type_new", methods={"GET","POST"})
     */
    public function newAction(Request $request, EntityManagerInterface $entityManager): Response
    {
        $phoneType = new PhoneType();
        $form = $this->createForm(PhoneTypeType::class, $phoneType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($phoneType);
            $entityManager->flush();

            return $this->redirectToRoute('phone_type_index');
        }

        return $this->render('phone_type/new.html.twig', [
            'phone_type' => $phoneType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("phoneType/{id}/edit", name="phone_type_edit", methods={"GET","POST"})
     */
    public function editAction(Request $request, PhoneType $phoneType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhoneTypeType::class, $phoneType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('phone_type_index');
        }

        return $this->render('phone_type/edit.html.twig', [
            'phone_type' => $phoneType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/phoneType/{id}/delete", name="phone_type_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, PhoneType $phoneType, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($phoneType->getPhones()) {
            $this->addFlash('error', 'You cannot delete this type, because it has phone numbers assigned.');
            return $this->redirectToRoute('phone_type_index');
        }

        if ($this->isCsrfTokenValid('delete'.$phoneType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($phoneType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('phone_type_index');
    }
}
