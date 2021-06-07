<?php

namespace App\Controller;

use App\Form\IconFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(IconFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $icon */
            $icon = $form->get('icon')->getData();
            $file = imagecreatefromstring($icon->getContent());
            $layer = imagecreatefrompng(__DIR__ . '/../../assets/img/' . $form->get('category')->getData() . '.png');
            $x = imagesx($file);
            $y = imagesy($file);
            $resized = imagecreatetruecolor(800, 800);
            imageLayerEffect($file, IMG_EFFECT_ALPHABLEND);
            imageLayerEffect($layer, IMG_EFFECT_ALPHABLEND);
            imageLayerEffect($resized, IMG_EFFECT_ALPHABLEND);
            imagecopyresampled($resized, $file, 0, 0, 0, 0, 800, 800, $x, $y);
            imageLayerEffect($resized, IMG_EFFECT_ALPHABLEND);
            imagecopy($resized, $layer, 0, 0, 0, 0, 800, 800);
            $filePath = '/tmp/' . Uuid::v4() . '.png';
            imagepng($resized, $filePath);
            return $this->file($filePath);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function crop(Request $request)
    {

    }
}
