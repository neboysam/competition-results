<?php

namespace App\Controller;

use App\Entity\Competitor;
use App\Form\CompetitorType;
use App\Entity\CompetitorFileUpload;
use App\Form\CompetitorFileUploadType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetitorController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/participants", name="app_competitors")
     */
    public function index(): Response
    {        
        $competitors = $this->entityManager->getRepository(Competitor::class)->findAll();

        return $this->render('competitor/index.html.twig', [
            'competitors' => $competitors
        ]);
    }

    /**
     * @Route("/participants/ajouter", name="app_competitor")
     */
    public function new(Request $request): Response
    {        
        $competitor = new Competitor();
        $form = $this->createForm(CompetitorType::class, $competitor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($competitor);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_competitors');
        }

        return $this->render('competitor/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/participants/ajouter-fichier", name="app_add_competitor_file")
     */
    public function add(Request $request): Response
    {   
        $fileUpload = new CompetitorFileUpload();
             
        $form = $this->createForm(CompetitorFileUploadType::class, $fileUpload, [
            'action' => $this->generateUrl('app_add_competitors')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $excelFile = $form->get('my_file')->getData();
            $originalFilename = pathinfo($excelFile->getClientOriginalName(), PATHINFO_FILENAME);

            $newFilename = $originalFilename . '.' . $excelFile->guessExtension();
            
            $uploads_directory = $this->getParameter('uploads_directory');
            
            $excelFile->move(
                $uploads_directory,
                $newFilename
            );

            $this->entityManager->persist($fileUpload);
            $this->entityManager->flush();
        
            $inputFileType = 'Xlsx';
            $inputFileName = '../public/uploads/participants.xlsx';

            $reader = IOFactory::createReader($inputFileType);
        
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            $conn = new \mysqli("localhost", "root", "", "competition-results");
            /* if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } */
            $sql = '';
            
            
            for($row = 2; $row <= count($sheetData); $row++) {
                $xx = "'" . implode("', '", $sheetData[$row]) . "'";
                $sql = "INSERT INTO competitor (firstname, lastname, email, city) VALUES ($xx);";
                $conn->query($sql);

                if(!$conn->query($sql)) {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                /* if($conn->query($sql) == 'TRUE') {
                    echo "Row $row inserted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                } */
            }
        }
        /** End of PHPSpreadsheet solution */

        return $this->render('competitor/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
