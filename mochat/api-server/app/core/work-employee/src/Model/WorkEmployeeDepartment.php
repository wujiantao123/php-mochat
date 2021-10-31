<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkEmployee\Model;

use Hyperf\Database\Model\Concerns\CamelCase;
use Hyperf\Database\Model\SoftDeletes;
use MoChat\Framework\Model\AbstractModel;

/**
 * @property int $id
 * @property int $employeeId
 * @property int $departmentId
 * @property int $isLeaderInDept
 * @property int $order
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 * @property string $deletedAt
 */
class WorkEmployeeDepartment extends AbstractModel
{
    use CamelCase;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_employee_department';

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
    protected $casts = ['id' => 'integer', 'employee_id' => 'integer', 'department_id' => 'integer', 'is_leader_in_dept' => 'integer', 'order' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
