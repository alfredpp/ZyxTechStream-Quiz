<?php

namespace Zyxware\QuizBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zyxware\QuizBundle\Entity\UserScore;
use Zyxware\QuizBundle\Entity\Questions;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Zyxware\QuizBundle\Form\QuestionType;



class QuizController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'ZyxwareQuizBundle:Quiz:quiz.html.twig',
            array('text' => 'Hello Hi!'));
    }

    public function createAction(Request $request)
    {
        $user = new UserScore();

        $form = $this->createFormBuilder($user)
            ->add('first_name', 'text')
            ->add('last_name', 'text')
            ->add('email', 'email')
            ->add('Enter', 'submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
          // perform some action, such as saving the task to the database
          $first_name = $form['first_name']->getData();
          $last_name = $form['last_name']->getData();
          $user->setFirstName($first_name);
          $user->setLastName($last_name);
          $user->setEmail($form['email']->getData());
          $user->setScore(0);
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();

          $session = $this->getRequest()->getSession();
          // set and get session attributes
          print_r($user->getId());
          $session->set('user_id', $user->getId());
          $session->set('name', $first_name . $last_name);
          print_r($session->get('user_id'));
          print_r($session->get('name'));
          //return $this->redirect($this->generateUrl('zyxware_quiz_questions'));
        }
        return $this->render('ZyxwareQuizBundle:Quiz:user.html.twig', array(
            'text' => $form->createView(),
            'message' => '',
          )
        );
    }

    public function questionsAction(Request $request)
    {
      $session = $this->getRequest()->getSession();
      $message = '';
      if ($session->get('user_id')) {
        $user = new Questions();
        $user_name = $session->get('name');
        $user_id = $session->get('user_id');
        $form = $this->createForm(new QuestionType($session));

        $form = $form->handleRequest($request);
        if ($form->isValid()) {
          $score = 0;
          $answers = $session->get('answers');
          for($i = 1; $i <= 12; $i++) {
            $user_answer = $form[$i]->getData();
            echo '</pre>' . print_r($user_answer . '-' . $answers[$i]) . '</pre>';
            if ($user_answer == $answers[$i]) {
              $score++;
            }
          }
          $session->set('score', $score);
          return $this->redirect($this->generateUrl('zyxware_quiz_result'));
        }

        return $this->render('ZyxwareQuizBundle:Quiz:quiz.html.twig', array(
            'form' => $form->createView(),
            'user' => $session->get('user_name'),
            'message' => $message,
          )
        );
      }
    }


    public function resultAction() {
      $session = $this->getRequest()->getSession();
      $score = $session->get('score');
      $username = $session->get('name');
      // $session->remove('user_id');
      // $session->remove('user_name');
      // $session->remove('answers');
      return $this->render('ZyxwareQuizBundle:Quiz:result.html.twig', array(
            'score' => $score,
            'user' => $username,
          )
        );
    }
}
