<?php

declare (strict_types = 1);

namespace App\Prooph;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Prooph\ServiceBus\Plugin\AbstractPlugin;
use Prooph\ServiceBus\MessageBus;
use Prooph\ServiceBus\CommandBus;
use Prooph\Common\Event\ActionEvent;

final class CommandValidationPlugin extends AbstractPlugin
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function attachToMessageBus(MessageBus $messageBus): void
    {
        if (!$messageBus instanceof CommandBus) {
            throw new \InvalidArgumentException(sprintf(
                'This plugin can only be attached to an instance of "Prooph\ServiceBus\CommandBus", '
                . 'received an instance of "%s"',
                get_class($messageBus)
            ));
        }

        $this->listenerHandlers[] = $messageBus->attach(
            MessageBus::EVENT_DISPATCH,
            function (ActionEvent $event): void {
                $message = $event->getParam(MessageBus::EVENT_PARAM_MESSAGE);
                $violations = $this->validator->validate($message);

                if (count($violations) > 0) {
                    throw new InvalidCommandException($violations);
                }
            },
            MessageBus::PRIORITY_INVOKE_HANDLER + 1
        );
    }
}
