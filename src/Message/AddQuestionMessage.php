<?php


namespace App\Message;


use App\Entity\User;

class AddQuestionMessage
{
    /**
     * @var string
     */
    private $description;
    /**
     * @var User
     */
    private $user;

    public function __construct(string $content, User $user)
    {
        $this->description = $content;
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}