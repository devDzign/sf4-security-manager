<?php


namespace App\Messenger\Message;


class SlackMessage
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $content;
    /**
     * @var string
     */
    private $icon;

    /**
     * SlackMessage constructor.
     *
     * @param string $name
     * @param string $content
     * @param string $icon
     */
    public function __construct(string $name, string $content, string $icon)
    {
        $this->name    = $name;
        $this->content = $content;
        $this->icon    = $icon;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return SlackMessage
     */
    public function setName(string $name): SlackMessage
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return SlackMessage
     */
    public function setContent(string $content): SlackMessage
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return SlackMessage
     */
    public function setIcon(string $icon): SlackMessage
    {
        $this->icon = $icon;

        return $this;
    }

}