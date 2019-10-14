<?php


namespace App\Service;


use Http\Client\Exception;
use Nexy\Slack\Client;
use Nexy\Slack\Message;

class SlackBotService
{

    /**
     * @var Client
     */
    private $slack;

    /**
     * @var Message
     */
    private $message;

    public function __construct(Client $slack)
    {
        $this->slack = $slack;
    }

    /**
     * @param string $name
     * @param string $icone
     * @param string $content
     *
     * @return Message
     * @throws Exception
     */
    public function sendMessageSlack(string $name, string $icone = ':ghost:', string $content): Message
    {

        $this->createMessage($name, $icone, $content);
        $this->send();

        return $this->message;
    }

    /**
     * @param string $name
     * @param string $icone
     * @param string $content
     *
     * @return Message
     */
    private function createMessage(string $name, string $icon = ':ghost:', string $content)
    {
        $this->message = $this->slack->createMessage()
            ->from($name)
            ->withIcon($icon)
            ->setText($content);

        return $this->message;
    }

    /**
     * @throws Exception
     */
    private function send(): void
    {

        $this->slack->sendMessage($this->message);
    }

}