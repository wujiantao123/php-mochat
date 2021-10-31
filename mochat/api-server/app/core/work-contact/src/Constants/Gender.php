<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkContact\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * 客户性别枚举.
 * @Constants
 * @method static getMessage($code, array $options = []) 获取枚举值
 */
class Gender extends AbstractConstants
{
    /**
     * @Message("未知")
     */
    public const UNKNOWN = 0;

    /**
     * @Message("男")
     */
    public const MEN = 1;

    /**
     * @Message("女")
     */
    public const WOMEN = 2;
}
