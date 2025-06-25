<?php
// src/Controller/EventsController.php
namespace App\Controller;

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
        $city = ucfirst(strtolower($request->query->get('city', '')));
        $date = $request->query->get('date', '');
        dump($date);
        dump($city);
        $events = [];

        if ($city && $date) {
            $url = 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda';
            $url .= '&refine.location_city=' . urlencode($city);
            $url .= '&refine.firstdate_begin=' . urlencode($date);
            $response = $client->request('GET', $url);
            $data = $response->toArray();

            $events = $data['records'] ?? [];
        }

        return $this->render('events/index.html.twig', [
            'events' => $events,
        ]);
    }
}
