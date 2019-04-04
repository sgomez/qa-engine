<?php

namespace App\MessageHandler;

use App\Entity\Question;
use App\Message\AddQuestionMessage;
use App\Repository\QuestionRepository;
use Doctrine\Common\Persistence\ObjectManager;

class AddQuestionHandler
{
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    public function __construct(
        ObjectManager $manager,
        QuestionRepository $questionRepository
    )
    {
        $this->manager = $manager;
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(AddQuestionMessage $message)
    {
        if ($this->questionRepository->findOneBy([
            'description' => $message->getDescription()
        ])) {
            throw new \Exception('Duplicated question');
        }


        $question = new Question();
        $question->setDescription($message->getDescription());



        $this->manager->persist($question);
        $this->manager->flush();
    }
}
