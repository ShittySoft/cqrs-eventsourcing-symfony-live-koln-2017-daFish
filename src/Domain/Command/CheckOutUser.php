<?php

declare(strict_types=1);

namespace Building\Domain\Command;

use Prooph\Common\Messaging\Command;
use Rhumsaa\Uuid\Uuid;

final class CheckOutUser extends Command
{
    private $buildingId;
    private $username;

    private function __construct(Uuid $buildingId, string $username)
    {
        $this->init();

        $this->buildingId = $buildingId;
        $this->username = $username;
    }

    public static function fromBuildingWithUsername(Uuid $buildingId, string $username) : self
    {
        return new self($buildingId, $username);
    }

    public function username() : string
    {
        return $this->username;
    }

    public function buildingId() : Uuid
    {
        return $this->buildingId;
    }

    /**
     * Return message payload as array
     *
     * The payload should only contain scalar types and sub arrays.
     * The payload is normally passed to json_encode to persist the message or
     * push it into a message queue.
     *
     * @return array
     */
    public function payload()
    {
        return [
            'username' => $this->username,
            'buildingid' => $this->buildingId->toString(), // be explicit
        ];
    }

    /**
     * This method is called when message is instantiated named constructor fromArray
     *
     * @param array $payload
     *
     * @return void
     */
    protected function setPayload(array $payload)
    {
        $this->buildingId = Uuid::fromString($payload['buildingid']);
        $this->username = $payload['username'];
    }
}