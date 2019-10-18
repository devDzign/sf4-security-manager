<?php

namespace App\Messenger\Stamp;


use Symfony\Component\Messenger\Stamp\StampInterface;

/**
 * Class UniqueIdStamp
 * @package App\Messenger\Stamp
 */
class UniqueIdStamp implements StampInterface
{


    /**
     * @var string
     */
    private $uniqueId;

    public function __construct()
    {
        $this->uniqueId = uniqid('', true);
    }

    /**
     * @return string
     */
    public function getUniqueId(): string
    {
        return $this->uniqueId;
    }
}