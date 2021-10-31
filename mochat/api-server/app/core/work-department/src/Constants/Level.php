<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkDepartment\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 * @method static getMessage($code, array $options = []) 获取枚举值
 */
class Level extends AbstractConstants
{
    /**
     * @Message("一级部门")
     */
    public const FIRST_LEVEL = 1;

    /**
     * @Message("二级部门")
     */
    public const SECOND_LEVEL = 2;

    /**
     * @Message("三级部门")
     */
    public const THIRD_LEVEL = 3;

    /**
     * @Message("四级部门")
     */
    public const FOURTH_LEVEL = 4;

    /**
     * @Message("五级部门")
     */
    public const FIFTH_LEVEL = 5;

    /**
     * @Message("六级部门")
     */
    public const SIXTH_LEVEL = 6;

    /**
     * @Message("七级部门")
     */
    public const SEVENTH_LEVEL = 7;

    /**
     * @Message("八级部门")
     */
    public const EIGHTH_LEVEL = 8;

    /**
     * @Message("九级部门")
     */
    public const NINTH_LEVEL = 9;

    /**
     * @Message("五级部门")
     */
    public const TENTH_LEVEL = 10;
}
