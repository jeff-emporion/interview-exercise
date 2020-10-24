<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\AddressBook;
use Doctrine\DBAL\Exception;

class AddressBookController extends AbstractController
{
	
	/**
	 *
	 * @Route("/address_book/create", methods={"POST"})
	 */
	public function add(Request $request): JsonResponse
	{
		$data = json_decode($request->getContent(), true);
		
		if (isset($data['title'])) {
			$entityManager = $this->getDoctrine()->getManager();
			$book = new AddressBook();
			$book->setTitle($data['title']);
			if (isset($data['notes'])) {
				$book->setNotes($data['notes']);
			}
			$book->setCreateDate(new \DateTime());
			$entityManager->persist($book);
			$entityManager->flush();
			
			return new JsonResponse([
				'status' => 'Row created!:'.$book->getId()
			], Response::HTTP_CREATED);
		} else {
			
			return new JsonResponse([], Response::HTTP_BAD_REQUEST);
		}
	}
	
	/**
	 *
	 * @Route ("/address_book/show_all", methods = {"GET"})
	 */
	public function show_all()
	{
		$entityManager = $this->getDoctrine()->getManager();
		
		$rows = $entityManager->getRepository(AddressBook::class)->findAll();
		
		return new JsonResponse($rows, Response::HTTP_OK);
	}
	
	/**
	 *
	 * @Route ("/address_book/get/{id}", methods = {"GET"})
	 */
	public function get($id):JsonResponse
	{
		$entityManager = $this->getDoctrine()->getManager();
		
		$row = $entityManager->getRepository(AddressBook::class)->find($id);
		if ($row) {
			return new JsonResponse($row, Response::HTTP_OK);
		}
		
		return new JsonResponse([
			'status' => 'Row doesnt exist'
		], Response::HTTP_INTERNAL_SERVER_ERROR);
	}
	
	/**
	 * @Route("/address_book/delete/{id}", methods={"DELETE"})
	 */
	public function delete($id): JsonResponse
	{
		$entityManager = $this->getDoctrine()->getManager();
		$row = $entityManager->find(AddressBook::class, $id);
		if ($row) {
			try {
				$entityManager->remove($row);
				$entityManager->flush();
				
				return new JsonResponse([
					'status' => 'Row deleted'
				], Response::HTTP_OK);
			} catch (Exception $e) {
				return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
			}
		}
		
		return new JsonResponse([
			'status' => 'Row doesnt exist'
		], Response::HTTP_INTERNAL_SERVER_ERROR);
	}
	
	/**
	 * @Route("/address_book/edit/{id}", methods={"PUT"})
	 */
	public function update($id, Request $request)
	{
		$entityManager = $this->getDoctrine()->getManager();
		$data = json_decode($request->getContent(), true);
		if ($data && (isset($data['title']) || isset($data['notes']))) {
			/*@var $row AddressBook*/
			$row = $entityManager->find(AddressBook::class, $id);
			if ($row) {
				try {
					
					if (isset($data['title'])) {
						$row->setTitle($data['title']);
					}
					
					if (isset($data['notes'])) {
						$row->setNotes($data['notes']);
					}
					$entityManager->persist($row);
					$entityManager->flush();
					
					return new JsonResponse([
						'status' => 'Row updated'
					], Response::HTTP_OK);
				} catch (Exception $e) {
					return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
				}
			}
		}
		
		return new JsonResponse([
			'status' => 'Content is empty'
		], Response::HTTP_BAD_REQUEST);
	}
}
