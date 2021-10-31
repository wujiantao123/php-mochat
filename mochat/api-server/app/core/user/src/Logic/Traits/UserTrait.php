<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\User\Logic\Traits;

use MoChat\App\WorkDepartment\Contract\WorkDepartmentContract;
use MoChat\App\WorkEmployee\Contract\WorkEmployeeDepartmentContract;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;

trait UserTrait
{
    protected function corpId(): int
    {
        ## 当前企业
        $corpIds = user('corpIds');
        if (count($corpIds) !== 1) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '请选择一个企业，再进行操作');
        }
        return $corpIds[0];
    }

    /**
     * 获取员工同部门下所有员工id.
     * @param int $employeeId 员工id
     * @return array ...
     */
    protected function deptEmployeeIds(int $employeeId): array
    {
        $container = \Hyperf\Utils\ApplicationContext::getContainer();

        ## 员工所有部门
        $depts = $container->get(WorkEmployeeDepartmentContract::class)->getWorkEmployeeDepartmentsByEmployeeId(
            $employeeId,
            ['id', 'department_id']
        );
        if (empty($depts)) {
            return [];
        }
        ## 员工所有部门path
        $deptService = $container->get(WorkDepartmentContract::class);
        $deptPaths = $deptService->getWorkDepartmentsById(array_column($depts, 'departmentId'), ['id', 'path']);

        ## 所有子部门
        $allDepts = $deptService->getWorkDepartmentsByParentPath(array_column($deptPaths, 'path'), ['id']);

        ## 部门下所有员工
        $employees = $container->get(WorkEmployeeDepartmentContract::class)->getWorkEmployeeDepartmentsByDepartmentIds(
            array_column($allDepts, 'id'),
            ['id', 'employee_id']
        );

        return array_column($employees, 'employeeId');
    }
}
