<?php


namespace App\Message;


class AddQuestionMessage
{
    /**
     * @var string
     */
    private $description;

    public function __construct(string $content)
    {
        $this->description = $content;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}