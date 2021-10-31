<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\RoomAutoPull\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * @method static getMessage($code, array $options = []) 获取枚举值
 */
class DrawState extends AbstractConstants
{
    /**
     * @Message("未开始")
     */
    public const NO_STARTED = 1;

    /**
     * @Message("拉人中")
     */
    public const DRAWING = 2;

    /**
     * @Message("已拉满")
     */
    public const FULL = 3;
}
