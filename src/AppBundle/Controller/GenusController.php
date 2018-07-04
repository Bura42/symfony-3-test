<?php
/**
 * Created by PhpStorm.
 * User: bura
 * Date: 01.07.18
 * Time: 13:56
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use AppBundle\Entity\Task;

use AppBundle\Service\MarkdownTransformer;
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
    $genus->setName('Octopus' . rand(1, 100));
    $genus->setSubFamily('Octopodianae');
    $genus->setSpeciesCount(rand(100, 99999));

    $genusNote = new GenusNote();
    $genusNote->setUsername('AquaWeaver');
    $genusNote->setUserAvatarFilename('ryan.jpeg');
    $genusNote->setNote('I counted 8 legs... as they wrapped around me');
    $genusNote->setCreatedAt(new \DateTime('-1 month'));
    $genusNote->setGenus($genus);

    $em = $this->getDoctrine()->getManager();
    $em->persist($genus);
    $em->persist($genusNote);
    $em->flush();

    return new Response('<html><body>Genus Created </body></html>');
  }

  /**
   * @Route("/genus")
   */
  public function listAction() {

    $em = $this->getDoctrine()->getManager();


    $genuses = $em->getRepository('AppBundle:Genus')
      ->findAllPublishedOrderedByRecentryActive();

    return $this->render('genus/list.html.twig', [
      'genuses' => $genuses,
    ]);
  }

  /**
   * @Route("/genus/{genusName}", name="genus_show")
   */
  public function showAction($genusName) {

    $em = $this->getDoctrine()->getManager();
    $genus = $em->getRepository('AppBundle:Genus')
      ->findOneBy(['name' => $genusName]);

    if (!$genus) {
      throw $this->createNotFoundException('No genus found');
    }

    $transformer = $this->get('app.markdown_transformer');
    $funFact = $transformer->parse($genus->getFunFact());


    //    $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
    //    $key = md5($funFact);
    //    if ($cache->contains($key)) {
    //      $funFact = $cache->fetch($key);
    //    }
    //    else {
    //      sleep(1);

    //
    //      $cache->save($key, $funFact);
    //    }

    $this->get('logger')
      ->info('Showing genus:' . $genusName);

    $recentNotes = $em->getRepository("AppBundle:GenusNote")
      ->findAllRecentNotesForGenus($genus);

    return $this->render('genus/show.html.twig', [
      'genus' => $genus,
      'funFact'=>$funFact,
      'recentNotesCount' => count($recentNotes),
    ]);
  }

  /**
   * @Route("/genus/{name}/notes", name="genus_show_notes")
   * @Method("GET")
   */

  public function getNotesAction(Genus $genus) {
    foreach ($genus->getNotes() as $note) {
      $notes[] = [
        'id' => $note->getId(),
        'username' => $note->getUsername(),
        'avatarUri' => '/images/' . $note->getUserAvatarFilename(),
        'note' => $note->getNote(),
        'date' => $note->getCreatedAt()->format('M d, Y'),
      ];
    }

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