<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Items;
use App\Form\CreateItemType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ItemsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

class ItemsController extends AbstractController
{
    #[Route('/items', name: 'app_items')]
    public function index(ItemsRepository $itemsRepository): Response
    {
        $items = $itemsRepository -> findAll();
        return $this->render('items/index.html.twig', [
            'controller_name' => 'ItemsController',
            'items' => $items,
        ]);
    }

    #[Route('/items/{id}', name: 'app_items_show')]
    public function showItemById(EntityManagerInterface $entityManager, $id): Response
    {
        $item = $entityManager->getRepository(Items::class)->find($id);
        {
    
            if (!$item) {
                throw $this->createNotFoundException(
                    'No item found for id '.$id
                );
            }
    
            // or render a template
            // in the template, print things with {{ product.name }}
            // return $this->render('product/show.html.twig', ['product' => $product])

        return $this->render('items/itemPage.html.twig', [
            'controller_name' => 'ItemsController',
            'item' => $item,
        ]);
        }
    }

    #[Route('/items/categorie/{id}', name: 'app_items_categorie_show')]
public function showItemsByCategorieId(EntityManagerInterface $entityManager, int $id): Response
{
    // Récupérer la catégorie à partir de l'ID
    $category = $entityManager->getRepository(Categories::class)->find($id);

    if (!$category) {
        throw $this->createNotFoundException(
            'Aucune catégorie trouvée pour l\'ID ' . $id
        );
    }

    // Récupérer les items liés à cette catégorie
    $items = $entityManager->getRepository(Items::class)->findBy(['Categorie' => $category]);

    if (!$items) {
        throw $this->createNotFoundException(
            'Aucun item trouvé pour la catégorie id ' . $id
        );
    }

    // Rendu du template avec les données des items et de la catégorie
    return $this->render('items/itemCategorie.html.twig', [
        'controller_name' => 'ItemsController',
        'category' => $category,
        'items' => $items,
    ]);
}

    #[Route('/profile/create_items', name: 'app_create_items')]
    public function sendItemToBdd (Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger, 
    #[Autowire('%kernel.project_dir%/public/uploads')] string $uploadsDirectory): Response
    {
        $newItem = new Items;
        $form =$this->createForm(CreateItemType::class, $newItem);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {

            $thumbnail = $form->get('thumbnail')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($thumbnail) {
                $originalFilename = pathinfo($thumbnail->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$thumbnail->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $thumbnail->move($uploadsDirectory, $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $newItem->setThumbnail($newFilename);
            }
//fin tentative image
            $newItem = $form->getData();
            $entityManager->persist($newItem);
            $entityManager->flush();
        }

        return $this->render('items/createItem.html.twig', [
            'controller_name' => 'ItemsController',
            'form' => $form,
        ]);

    }


}
