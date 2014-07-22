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
            'ZyxwareQuizBundle:Quiz:start.html.twig',
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
        $session = $this->getRequest()->getSession();
        $session->invalidate();

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

          // set and get session attributes
          $session->set('user_id', $user->getId());
          $session->set('finished', 0);
          $session->set('name', $first_name . ' ' . $last_name);
          return $this->redirect($this->generateUrl('zyxware_quiz_questions'));
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
      $user_name = $session->get('name');
      $user_id = $session->get('user_id');
      $finished = $session->get('finished');
      $message = '';
      if ($user_id) {
        if(!$finished) {
          $user = new Questions();

          $form = $this->createForm(new QuestionType($session));

          $form = $form->handleRequest($request);
          if ($form->isValid()) {
            $score = 0;
            $answers = $session->get('answers');
            $data = $form->getData();

            for($i = 1; $i <= 12; $i++) {
              $user_answer = $form[$i]->getData();
              if ($user_answer == $answers[$i]) {
                $score++;
              }
            }
            $session->set('score', $score);
            $session->set('finished', 1);
            return $this->redirect($this->generateUrl('zyxware_quiz_result'));
          }

          return $this->render('ZyxwareQuizBundle:Quiz:quiz.html.twig', array(
              'form' => $form->createView(),
              'user' => $user_name,
              'message' => $message,
            )
          );
        }
        else {
          $message = 'You have already submitted the answers.';
          return $this->render('ZyxwareQuizBundle:Quiz:quiz.html.twig', array(
              'form' => '',
              'user' => $user_name,
              'message' => $message,
            )
          );
        }
      }
    }


    public function resultAction() {
      $session = $this->getRequest()->getSession();
      $score = $session->get('score');
      $username = $session->get('name');
      $user_id = $session->get('user_id');
      $user = $this->getDoctrine()
        ->getRepository('ZyxwareQuizBundle:UserScore')
        ->find($user_id);
      if (!$user) {
        throw $this->createNotFoundException('No user found for id '. $user_id);
      }
      //$user->setUname($username);
      $user->setScore($score);
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      $session->remove('answers');

      $result= $this->getDoctrine()->getEntityManager()
       ->getRepository('ZyxwareQuizBundle:UserScore')
       ->getTopTenScores();


      return $this->render('ZyxwareQuizBundle:Quiz:result.html.twig', array(
            'score' => $score,
            'user' => $username,
            'result' => $result,
          )
        );
    }
}
