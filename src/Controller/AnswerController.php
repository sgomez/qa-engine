<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @Route("/question/{id}/answer/new", name="response_new")
     */
    public function new(Question $question, Request $request)
    {
        $answer = new Answer();
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $answer->setQuestion($question);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($answer);
            $manager->flush();

            return $this->redirectToRoute('question_show', ['id' => $question->getId()]);
        }

        return $this->render('answer/new.html.twig', [
           'form' => $form->createView(),
           'question' => $question,
        ]);
    }

    /**
     * @Route("/answer/{id}", name="response_edit")
     */
    public function edit(Answer $answer, Request $request)
    {
        $form = $this->createForm(AnswerType::class, $answer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();

            return $this->redirectToRoute('question_show', ['id' => $answer->getQuestion()->getId()]);
        }

        return $this->render('answer/new.html.twig', [
            'form' => $form->createView(),
            'question' => $answer->getQuestion(),
        ]);
    }

}
