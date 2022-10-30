<?php

namespace App\Controller;

use App\Entity\Result;
use App\Entity\ResultFileUpload;
use App\Form\ResultFileUploadType;
use App\Form\SearchResultType;
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
     * @Route("/resultats", name="app_results")
     */
    public function results(Request $request): Response
    {   
        $form = $this->createForm(SearchResultType::class, null);

        //$competitors = $this->entityManager->getRepository(Result::class)->menGeneral();
        //dd($competitors);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->get('categoryName')->getData()->getCategoryName());
            $category_name = $form->get('categoryName')->getData()->getCategoryName();
            $competition_year = $form->get('competitionYear')->getData()->getCompetitionYear();
            $competitors = $this->entityManager->getRepository(Result::class)->results($category_name, $competition_year);

            return $this->render('result/index.html.twig', [
                'competitors' => $competitors,
                'message' => $category_name
            ]);
        }

        return $this->render('result/result_form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    

    /**
     * @Route("/resultats/ajouter", name="app_add_results")
     */
    public function addFile(Request $request): Response
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
            $this->entityManager->flush();
        
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
            $sql = '';
            
            for($row = 2; $row <= count($sheetData); $row++) {
                $result_string = "'" . implode("', '", $sheetData[$row]) . "'";
                //var_dump($xx);
                //$competitor_category_string = substr($result_string, 36, 8);
                
                $sql = "INSERT INTO result (result1, result2, final_result, competitor_id, category_id, competition_id) VALUES ($result_string);";
                
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

        return $this->render('result/add_file.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

