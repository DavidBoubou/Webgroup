<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Sonata\FormatterBundle\Form\Type\SimpleFormatterType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    //Test des blockbundle
    #[Route('/test/block', name: 'block')]
    public function block(): Response
    {
        return $this->render('Block/Example.html.twig');
        
    }

    //Test des tableau de bord
    #[Route('/test/chart')]
    public function chart(ChartBuilderInterface $chartBuilder): Response
    {
        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        $chart->setData([
            'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'black',
                    'borderColor' => 'black',
                    'data' => [0, 10, 5, 2, 20, 30, 45],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);

        return $this->render('test/chart.html.twig', [
            'chart' => $chart,
        ]);
        
    }

    //Test des form
    #[Route('/test/dropzone')]
    public function dropzone(Request $request): Response
    {
        //color-picker
        //ckeditor
        //datetime-peaker

        //instancier une entité

        $defaultData = ['message' => 'Type your message here'];
        $formbuilder = $this->createFormBuilder($defaultData);

         $formbuilder ->add('name', TextType::class, [
                        'help' => 'Add your name',
                        'label' => 'name', ])

                ->add('message', TextareaType::class)

                //Dropzone
                ->add('photo', DropzoneType::class)
                //ckeditor sans gestion des médias
                ->add('details', SimpleFormatterType::class, [
                    'format' => 'richhtml',
                    'ckeditor_context' => 'default',
                    //'ckeditor_image_format' => 'big',
                ])
                //ckeditor
                ->add('details', CKEditorType::class)

                ->add('send', SubmitType::class);

                $form =$formbuilder    ->getForm();

            //Construction du formulaire
            /*
            return $this->renderForm('test/form.html.twig', [
                'form' => $form->createView(),
            ]);
            */
            return $this->render('test/form.html.twig', [
                'form' => $form->createView(),
            ]);
    }


    //Test des menus
    #[Route('/test/menu')]
    public function menu(): Response
    {
        //KnpMenu
        return $this->render('test/menu.html.twig', [
            'controller_name' => 'TestController',
        ]);
        
    }

    //Test du SEO
    #[Route('/test/seo')]
    public function seo(): Response
    {
        //KnpMenu
        return $this->render('test/seo.html.twig', [
            'controller_name' => 'TestController',
        ]);
        
    }
}
