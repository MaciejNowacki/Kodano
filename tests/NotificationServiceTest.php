<?php

declare(strict_types=1);

namespace App\Tests;

use App\Application\Notification\Handlers\EmailHandlingStrategy;
use App\Application\Notification\Handlers\LogHandlingStrategy;
use App\Application\Notification\NotificationService;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class NotificationServiceTest extends TestCase
{
    public function testNotifyExecutesAllStrategiesSuccessfully(): void
    {
        $strategy1 = $this->createMock(EmailHandlingStrategy::class);
        $strategy1->expects(self::once())
            ->method('handle')
            ->with('Test Title', 'Test Message');

        $strategy2 = $this->createMock(LogHandlingStrategy::class);
        $strategy2->expects(self::once())
            ->method('handle')
            ->with('Test Title', 'Test Message');

        $logger = $this->createMock(LoggerInterface::class);

        $service = new NotificationService([$strategy1, $strategy2], $logger);

        $service->notify('Test Title', 'Test Message');
    }

    public function testNotifyLogsErrorWhenStrategyFails(): void
    {
        $exceptionMessage = 'Test exception';

        $strategy = $this->createMock(LogHandlingStrategy::class);
        $strategy->expects(self::once())
            ->method('handle')
            ->with('Test Title', 'Test Message')
            ->willThrowException(new \RuntimeException($exceptionMessage));

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())
            ->method('error')
            ->with($exceptionMessage);

        $service = new NotificationService([$strategy], $logger);

        $service->notify('Test Title', 'Test Message');
    }

    public function testNotifyContinuesProcessingWhenOneStrategyFails(): void
    {
        $strategy1 = $this->createMock(EmailHandlingStrategy::class);
        $strategy1->expects(self::once())
            ->method('handle')
            ->with('Test Title', 'Test Message')
            ->willThrowException(new \RuntimeException('Test exception from strategy1'));

        $strategy2 = $this->createMock(LogHandlingStrategy::class);
        $strategy2->expects(self::once())
            ->method('handle')
            ->with('Test Title', 'Test Message');

        $logger = $this->createMock(LoggerInterface::class);
        $logger->expects(self::once())
            ->method('error')
            ->with('Test exception from strategy1');

        $service = new NotificationService([$strategy1, $strategy2], $logger);

        $service->notify('Test Title', 'Test Message');
    }
}