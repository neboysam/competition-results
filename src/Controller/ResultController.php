<?php

namespace App\Controller;

use App\Entity\Result;
use App\Entity\ResultFileUpload;
use App\Form\ResultFileUploadType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResultController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/resultats/general-hommes", name="app_men_general")
     */
    public function menGeneral(): Response
    {        
        $competitors = $this->entityManager->getRepository(Result::class)->findAll();

        return $this->render('competitor/index.html.twig', [
            'competitors' => $competitors
        ]);
    }

    /**
     * @Route("/resultats/ajouter", name="app_add_results")
     */
    public function add(Request $request): Response
    {   
        $fileUpload = new ResultFileUpload();
             
        $form = $this->createForm(ResultFileUploadType::class, $fileUpload, [
            'action' => $this->generateUrl('app_add_results')
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
            //$this->entityManager->flush();
        
            $inputFileType = 'Xlsx';
            $inputFileName = '../public/uploads/resultats.xlsx';

            $reader = IOFactory::createReader($inputFileType);
        
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($inputFileName);

            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            echo(count($sheetData));

            $conn = new \mysqli("localhost", "root", "", "competition-results");
            /* if($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } */
            $sql1 = '';
            $sql2 = '';
            
            for($row = 2; $row <= count($sheetData); $row++) {
                $result_string = "'" . implode("', '", $sheetData[$row]) . "'";
                //var_dump($xx);
                $competitor_category_string = substr($result_string, 36, 8);
                
                $sql1 = "INSERT INTO result (result1, result2, final_result, competitor_id, category_id, competition_id) VALUES ($result_string);";
                $sql2 = "INSERT INTO competitor_category (competitor_id, category_id) VALUES ($competitor_category_string);";

                if(!$conn->query($sql1)) {
                    echo "Error: " . $sql1 . "<br>" . $conn->error;
                }
                if(!$conn->query($sql2)) {
                    echo "Error: " . $sql2 . "<br>" . $conn->error;
                }

                /* if($conn->query($sql) == 'TRUE') {
                    echo "Row $row inserted successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                } */
            }
        }
        /** End of PHPSpreadsheet solution */

        return $this->render('result/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

