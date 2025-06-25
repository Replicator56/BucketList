<?php

namespace App\Controller;

use App\Form\EventSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Annotation\Route;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(Request $request, HttpClientInterface $client): Response
    {
        $form = $this->createForm(EventSearchType::class);
        $form->handleRequest($request);

        $events = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $city = ucfirst(strtolower($data['city']));
            $date = $data['date']->format('Y-m-d');

            $url = 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda';
            $url .= '&refine.location_city=' . urlencode($city);
            $url .= '&refine.firstdate_begin=' . urlencode($date);

            $response = $client->request('GET', $url);
            $responseData = $response->toArray();

            $events = $responseData['records'] ?? [];
        }

        return $this->render('events/index.html.twig', [
            'form' => $form->createView(),
            'events' => $events,
        ]);
    }
}
