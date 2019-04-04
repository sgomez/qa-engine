<?php

namespace spec\App\MessageHandler;

use App\Entity\Question;
use App\Message\AddQuestionMessage;
use App\MessageHandler\AddQuestionHandler;
use App\Repository\QuestionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddQuestionHandlerSpec extends ObjectBehavior
{
    public function let(
        ObjectManager $manager,
        QuestionRepository $questionRepository
    )
    {
        $this->beConstructedWith($manager, $questionRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddQuestionHandler::class);
    }

    public function it_saves_a_new_question(
        ObjectManager $manager,
        AddQuestionMessage $message,
        QuestionRepository $questionRepository
    )
    {
        $message->getDescription()->willReturn('New question')->shouldBeCalled();

        $questionRepository->findOneBy([
            'description' => 'New question',
        ])->willReturn(null)->shouldBeCalled();

        $question = new Question();
        $question->setDescription('New question');

        $manager->persist(Argument::any())->shouldBeCalled();
        $manager->flush()->shouldBeCalled();

        $this($message);
    }

    public function it_checks_a_question_is_duplicated(
        ObjectManager $manager,
        AddQuestionMessage $message,
        QuestionRepository $questionRepository,
        Question $question
    )
    {
        $message->getDescription()->willReturn('New question')->shouldBeCalled();

        $questionRepository->findOneBy([
            'description' => 'New question',
        ])->willReturn($question)->shouldBeCalled();

        $this
            ->shouldThrow(\Exception::class)
            ->during('__invoke', [$message])
        ;
    }
}
