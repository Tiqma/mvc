<?php

namespace App\Controller;

use App\Adventure\Adventure;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdventureController extends AbstractController
{
    #[Route('/proj', name: 'project')]
    public function index(SessionInterface $session): Response
    {
        /** @var Adventure $adventure */
        $adventure = $session->get('adventure', new Adventure());

        $description = $adventure->describeCurrentRoom();
        $image = $adventure->getCurrentRoomImage();
        $connectedRooms = $adventure->getConnectedRooms();
        $currentRoomItems = $adventure->getCurrentRoomItems();

        return $this->render('adventure/adventure.html.twig', [
            'description' => $description,
            'image' => $image,
            'inventory' => $adventure->getInventory(),
            'connectedRooms' => $connectedRooms,
            'currentRoomItems' => $currentRoomItems,
        ]);
    }

    #[Route('/proj/move/{room}', name: 'move_room')]
    public function moveRoom(SessionInterface $session, string $room): Response
    {
        /** @var Adventure $adventure */
        $adventure = $session->get('adventure', new Adventure());

        $result = $adventure->moveToRoom($room);
        if (!$result['success']) {
            $this->addFlash('warning', $result['message']);
        }

        $session->set('adventure', $adventure);

        return $this->redirectToRoute('project');
    }

    #[Route('/proj/pickup/{item}', name: 'pickup_item')]
    public function pickUpItem(SessionInterface $session, string $item): Response
    {
        /** @var Adventure $adventure */
        $adventure = $session->get('adventure', new Adventure());

        $result = $adventure->pickUpItem($item);
        if (!$result['success']) {
            $this->addFlash('warning', $result['message']);
        }

        $session->set('adventure', $adventure);

        return $this->redirectToRoute('project');
    }

    #[Route('/proj/throw/{item}', name: 'throw_item')]
    public function throwItem(SessionInterface $session, string $item): Response
    {
        /** @var Adventure $adventure */
        $adventure = $session->get('adventure', new Adventure());

        $result = $adventure->throwItem($item);
        if (!$result['success']) {
            $this->addFlash('error', $result['message']);
        } else {
            $this->addFlash('success', $result['message']);
        }

        $session->set('adventure', $adventure);

        return $this->redirectToRoute('project');
    }

    #[Route("/proj/about", name: "proj_about", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('adventure/about.html.twig');
    }
}
