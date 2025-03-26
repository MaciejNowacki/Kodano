<?php

declare(strict_types=1);

namespace App\Application\Notification\Handlers;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

#[AutoconfigureTag('notification_handling_strategy')]
readonly class EmailHandlingStrategy implements HandlingStrategyInterface
{
    public function __construct(
        private MailerInterface                        $mailer,
        #[Autowire(env: 'MAILER_FROM')] private string $from,
        #[Autowire(env: 'MAILER_TO')] private string   $to,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(string $title, string $message): void
    {
        $email = (new Email())
            ->from($this->from)
            ->to($this->to)
            ->subject($title)
            ->text($message);

        $this->mailer->send($email);
    }
}