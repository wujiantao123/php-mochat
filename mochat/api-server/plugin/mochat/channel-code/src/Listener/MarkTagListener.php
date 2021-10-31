<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\ChannelCode\Listener;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use MoChat\App\WorkContact\Contract\WorkContactTagContract;
use MoChat\App\WorkContact\Event\AddContactEvent;
use MoChat\Plugin\ChannelCode\Contract\ChannelCodeContract;
use Psr\Container\ContainerInterface;

/**
 * 新客户打标签监听.
 *
 * @Listener
 */
class MarkTagListener implements ListenerInterface
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ChannelCodeContract
     */
    private $channelCodeService;

    /**
     * @var WorkContactTagContract
     */
    private $workContactTagService;

    /**
     * @var StdoutLoggerInterface
     */
    private $logger;

    public function listen(): array
    {
        return [
            AddContactEvent::class,
        ];
    }

    /**
     * @param AddContactEvent $event
     */
    public function process(object $event)
    {
        try {
            $contact = $event->message;
            $this->channelCodeService = $this->container->get(ChannelCodeContract::class);
            $this->workContactTagService = $this->container->get(WorkContactTagContract::class);
            $this->logger = $this->container->get(StdoutLoggerInterface::class);

            // 判断是否需要打标签
            if (!$this->isNeedMarkTag($contact)) {
                return;
            }

            // 获取打标签规则
            $tagIds = $this->getMarkTagRule($contact);
            if (empty($tagIds)) {
                $this->logger->debug(sprintf('[渠道活码]客户打标签未执行，获取打标签规则为空，客户id: %s', (string) $contact['id']));
                return;
            }

            // 打标签
            $this->logger->debug(sprintf('[渠道活码]客户打标签匹配成功，即将执行，客户id: %s', (string) $contact['id']));
            $this->workContactTagService->markTags((int)$contact['corpId'], (int)$contact['id'], (int)$contact['employeeId'], $tagIds);
        } catch (\Throwable $e) {
            $this->logger->error(sprintf('[渠道活码]客户打标签失败，错误信息: %s', $e->getMessage()));
            $this->logger->error($e->getTraceAsString());
        }
    }

    /**
     * 判断是否需要打标签.
     *
     * @return bool
     */
    private function isNeedMarkTag(array $contact)
    {
        if (! isset($contact['state']) || empty($contact['state'])) {
            return false;
        }

        $stateArr = explode('-', $contact['state']);
        if ($stateArr[0] !== $this->getStateName()) {
            return false;
        }

        return true;
    }

    /**
     * 获取来源名称.
     *
     * @return string
     */
    private function getStateName()
    {
        return 'channelCode';
    }

    /**
     * 获取打标签规则.
     *
     * @param array $contact 客户
     *
     * @return array[]
     */
    private function getMarkTagRule(array $contact): array
    {
        $stateArr = explode('-', $contact['state']);
        $channelCodeId = (int) $stateArr[1];

        $data = [];

        $channelCode = $this->channelCodeService->getChannelCodeById($channelCodeId, ['tags']);

        if (empty($channelCode) || empty($channelCode['tags'])) {
            return $data;
        }

        $tagIds = array_filter(json_decode($channelCode['tags'], true));

        return $tagIds;
    }
}
