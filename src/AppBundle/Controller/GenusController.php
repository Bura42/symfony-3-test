<?php
/**
 * Created by PhpStorm.
 * User: bura
 * Date: 01.07.18
 * Time: 13:56
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\Task;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GenusController extends Controller {

  /**
   * @Route("/genus/new")
   */

  public function newAction() {
    $genus = new Genus();
    $genus ->setName('Octopus'.rand(1,100));
    $genus ->setSubFamily('Octopodianae');
    $genus ->setSpeciesCount(rand(100,99999));

    $em = $this->getDoctrine()->getManager();
    $em->persist($genus);
    $em->flush();

    return new Response('<html><body>Genus Created </body></html>');
  }

  /**
   * @Route("/genus")
   */
  public function listAction() {

    $em = $this->getDoctrine()->getManager();


    $genuses = $em->getRepository('AppBundle:Genus')
      ->findAllPublishedOrderedBySize();

    return $this->render('genus/list.html.twig', [
      'genuses'=>$genuses,
    ]);
  }
  /**
   * @Route("/genus/{genusName}", name="genus_show")
   */
  public function showAction($genusName) {

    //        $templating = $this->container->get('templating');
    //        $html = $templating->render('genus/show.html.twig', [
    //            'name' => $genusName
    //        ]);
    //
    //        return new Response($html);
   $em = $this->getDoctrine()->getManager();
   $genus = $em->getRepository('AppBundle:Genus')
     ->findOneBy(['name' => $genusName]);

   if(!$genus) {
     throw $this->createNotFoundException('No genus found');
   }


//    $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
//    $key = md5($funFact);
//    if ($cache->contains($key)) {
//      $funFact = $cache->fetch($key);
//    }
//    else {
//      sleep(1);
//      $funFact = $this->get('markdown.parser')
//        ->transform($funFact);
//
//      $cache->save($key, $funFact);
//    }


    return $this->render('genus/show.html.twig', [
      'genus' => $genus
    ]);
  }

  /**
   * @Route("/genus/{genusName}/notes", name="genus_show_notes")
   * @Method("GET")
   */

  public function getNotesAction() {
    $notes = [
      [
        'id' => 1,
        'username' => 'AquaPelham',
        'avatarUri' => '/images/leanna.jpeg',
        'note' => 'Octopus asked me a riddle, outsmarted me',
        'date' => 'Dec. 10, 2018',
      ],
      [
        'id' => 2,
        'username' => 'AquaWeaver',
        'avatarUri' => '/images/ryan.jpeg',
        'note' => 'I counted 8 legs... as they wrapped around me',
        'date' => 'Dec. 1, 2018',
      ],
      [
        'id' => 3,
        'username' => 'AquaPelham',
        'avatarUri' => '/images/leanna.jpeg',
        'note' => 'Inked!',
        'date' => 'Aug. 20, 2018',
      ],
    ];

    $data = [
      'notes' => $notes,
    ];

    return new JsonResponse($data);
  }

  //  /**
  //   * @Route("/testform")
  //   */
  //
  //  public function newAction(Request $request) {
  //    // creates a task and gives it some dummy data for this example
  //    $task = new Task();
  //    $task->setTask('Write a blog post');
  //    $task->setDueDate(new \DateTime('tomorrow'));
  //
  //    $form = $this->createFormBuilder($task)
  //      ->add('task', TextType::class)
  //      ->add('dueDate', DateType::class)
  //      ->add('save', SubmitType::class, array('label' => 'Create Task'))
  //      ->getForm();
  //
  //    return $this->render('genus/testform.html.twig', array(
  //      'form' => $form->createView(),
  //    ));
  //  }


}