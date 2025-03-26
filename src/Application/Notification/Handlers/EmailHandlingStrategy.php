<?php

declare(strict_types=1);

namespace App\Application\Notification\Handlers;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AutoconfigureTag('notification_handling_strategy')]
readonly class EmailHandlingStrategy implements HandlingStrategyInterface
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(string $title, string $message): void
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject($title)
            ->text($message);

        $this->mailer->send($email);
    }
}