<?php


namespace App\Messenger\Handler;


use App\Entity\SlackLog;
use App\Messenger\Message\SlackMessage;
use App\Service\SlackBotService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SlackMessageHandler implements MessageHandlerInterface
{

    /**
     * @var SlackBotService
     */
    private $slackBot;
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * SlackMessageHandler constructor.
     *
     * @param SlackBotService        $slackBot
     * @param EntityManagerInterface $manager
     * @param SerializerInterface    $serializer
     */
    public function __construct(SlackBotService $slackBot, EntityManagerInterface $manager, SerializerInterface $serializer)
    {
        $this->slackBot   = $slackBot;
        $this->manager    = $manager;
        $this->serializer = $serializer;
    }

    /**
     * @param SlackMessage $slackMessage
     *
     * @throws \Http\Client\Exception
     */
    public function __invoke(SlackMessage $slackMessage)
    {

        $this->slackBot->sendMessageSlack($slackMessage->getName(), $slackMessage->getContent(), $slackMessage->getIcon());
        $msgJson = $this->serializer->serialize($slackMessage, 'json');


        $test[]     = $msgJson;
        $messageLog = new SlackLog();
        $messageLog->setMessage($test);

        $this->manager->persist($messageLog);
        $this->manager->flush();


        dump($messageLog);

    }
}