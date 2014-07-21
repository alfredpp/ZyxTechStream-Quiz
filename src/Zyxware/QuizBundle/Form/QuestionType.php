<?php

namespace Zyxware\QuizBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Session\Session;


class QuestionType extends AbstractType
{
    private $session;

    public function __construct(Session $session) {
      $this->session = $session;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $session = $this->session;
      $sum_count = $sub_count = $mul_count = $div_count = 0;
      $questions = array();
      $answers = array();
      $i = 1;
      //$session = $this->getRequest()->getSession();
      $answers = $session->get('answers');
      if (isset($answers)){
        while ($i <= 12) {
          $num1 = rand (1,10);
          $num2 = rand (1,10);
          $op = rand(1,4);

          if ($op == 1){
            if ($sum_count < 3) {
              $question = $num1 . ' + ' . $num2 . ' is ';
              $answer = $num1 + $num2;
              $key = $i;
              $sum_count++;
              $answers[$i] = $answer;
              $i++;
            }
          }
          if ($op == 2){
            if ($sub_count < 3) {
              $question = $num1 . ' - ' . $num2 . ' is ';
              $answer = $num1 - $num2;
              $key = $i;
              $sub_count++;
              $answers[$i] = $answer;
              $i++;
            }
          }
          if ($op == 3){
            if ($mul_count < 3) {
              $question = $num1 . ' times ' . $num2 . ' is ';
              $answer = $num1 * $num2;
              $key = $i;
              $mul_count++;
              $answers[$i] = $answer;
              $i++;
            }
          }
          if ($op == 4){
            if ($div_count < 3) {
              $question = $num1 . ' / ' . $num2 . ' is ';
              $answer = $num1 / $num2;
              $key = $i;
              $div_count++;
              $answers[$i] = $answer;
              $i++;
            }
          }
          $builder->add($key, 'text', array(
            'label'  => $question,
          ));
        }


        $session->set('answers', $answers);

        $builder->add('Submit Your Answers', 'submit');
      }
    }

    public function getName()
    {
        return 'Question';
    }
}
