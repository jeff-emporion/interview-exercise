<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use App\Repository\PhoneTypeRepository;
use App\Service\PersonEntityPersistService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Throwable;

use function count;
use function sprintf;

class PersonController extends AbstractController
{
    /**
     * @Route("/", name="person_index")
     */
    public function indexAction(PersonRepository $personRepository): Response
    {
        return $this->render(
            'person/index.html.twig',
            [
                'persons' => $personRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("person/new", name="person_new", methods={"GET","POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, PhoneTypeRepository $phoneTypeRepository, RouterInterface $router): Response
    {
        $isFormEnabled = count($phoneTypeRepository->findAll());
        if(!$isFormEnabled) {
            $phoneTypeUrl = $router->generate('phone_type_new');
            $this->addFlash(
                'error',
                sprintf('You don\'t have any phone number types registered. Go <a href="%s">here</a> and register it.', $phoneTypeUrl)
            );
        }
        $person = new Person();
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlushPerson($person, $entityManager);

            return $this->redirectToRoute('person_index');
        }

        return $this->render(
            'person/new.html.twig',
            [
                'isFormEnabled' => $isFormEnabled,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("person/{id}/edit", name="person_edit", methods={"GET","POST"})
     */
    public function editAction(Request $request, Person $person, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PersonType::class, $person);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->persistAndFlushPerson($person, $entityManager);

            return $this->redirectToRoute('person_index');
        }

        return $this->render(
            'person/edit.html.twig',
            [
                'isFormEnabled' => true,
                'person' => $person,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/person/{id}/delete", name="person_delete", methods={"DELETE"})
     */
    public function deleteAction(Request $request, Person $person, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $entityManager->remove($person);
            $entityManager->flush();
        }

        return $this->redirectToRoute('person_index');
    }

    private function persistAndFlushPerson(Person $person, EntityManagerInterface $entityManager)
    {
        $entityManager->beginTransaction();
        try {
            $phones = $person->getPhones();
            $addresses = $person->getAddresses();
            $person->setPhones(new ArrayCollection());
            $person->setAddresses(new ArrayCollection());
            $entityManager->persist($person);
            $entityManager->flush();
            foreach ($phones as $phone) {
                $phone->setPerson($person);
                $entityManager->persist($phone);
            }
            foreach ($addresses as $address) {
                $address->setPerson($person);
                $entityManager->persist($address);
            }

            $entityManager->flush();
        } catch (Throwable $exception) {
            $entityManager->rollback();
            throw new $exception;
        }
        $entityManager->commit();
    }
}
