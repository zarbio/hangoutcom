<?php

namespace App\Controller;

use App\Entity\Hangout;
use App\Form\FilterType;
use App\Repository\HangoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HangoutRepository $hangoutRepository, Request $request): Response
    {
        $hangout = new Hangout();
        $filterForm = $this->createForm(FilterType::class,$hangout);

        $filterForm->handleRequest($request);

        if($filterForm->isSubmitted() && $filterForm->isValid()){
            $campus = $filterForm["campusOrganizerSite"]->getData();
            $name = null;
            $startDate = null;
            $endDate= null;
            $imOrginizer= null;
            $imIn= null;
            $imNotIn= null;
            $pastHangout= null;
            $hangouts = $hangoutRepository->findByFilter($campus,$name,$startDate,$endDate,$imOrginizer,$imIn,$imNotIn,$pastHangout);
        }else{
            $hangouts = $hangoutRepository->findAll();

        }

        return $this->render('hangout/hangoutList.html.twig', [
            'hangouts' => $hangouts,
            'filterForm' => $filterForm->createView(),
        ]);
    }
}
