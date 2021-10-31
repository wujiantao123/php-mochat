<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\SensitiveWord\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * @method static getMessage($code, array $options = []) 获取枚举值
 */
class ReceiverType extends AbstractConstants
{
    /**
     * @Message("员工")
     */
    public const EMPLOYEE = 1;

    /**
     * @Message("外部联系人")
     */
    public const CONTACT = 2;

    /**
     * @Message("群聊")
     */
    public const ROOM = 3;
}
