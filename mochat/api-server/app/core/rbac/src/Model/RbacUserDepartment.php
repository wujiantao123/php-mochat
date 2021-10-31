<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\Rbac\Model;

use Hyperf\Database\Model\Concerns\CamelCase;
use MoChat\Framework\Model\AbstractModel;

/**
 * @property int $id
 * @property int $corpId
 * @property int $userId
 * @property int $workDepartmentId
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 * @property string $deletedAt
 */
class RbacUserDepartment extends AbstractModel
{
    use CamelCase;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rbac_user_department';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'corp_id' => 'integer', 'user_id' => 'integer', 'work_department_id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
