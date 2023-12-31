<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Application\Query\QueryBusInterface;
use App\Shared\Application\Query\QueryInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class MessengerQueryBus implements QueryBusInterface
{
    use MessageBusExceptionTrait;

    /**
     * @param MessageBusInterface $queryBus
     */
    public function __construct(
        private readonly MessageBusInterface $queryBus,
    ) {
    }

    /**
     * @return mixed|void
     *
     * @throws Throwable
     */
    public function ask(QueryInterface $query)
    {
        try {
            $envelope = $this->queryBus->dispatch($query);
            /** @var HandledStamp $stamp */
            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }
}
