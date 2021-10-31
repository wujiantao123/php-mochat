<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\RoomWelcome\Contract;

interface RoomWelcomeContract
{
    /**
     * 查询单条 - 根据ID.
     * @param int $id ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomWelcomeById(int $id, array $columns = ['*']): array;

    /**
     * 查询多条 - 根据ID.
     * @param array $ids ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomWelcomesById(array $ids, array $columns = ['*']): array;

    /**
     * 多条分页.
     * @param array $where 查询条件
     * @param array|string[] $columns 查询字段
     * @param array $options 可选项 ['orderByRaw'=> 'id asc', 'perPage' => 15, 'page' => null, 'pageName' => 'page']
     * @return array 分页结果 Hyperf\Paginator\Paginator::toArray
     */
    public function getRoomWelcomeList(array $where, array $columns = ['*'], array $options = []): array;

    /**
     * 添加单条
     * @param array $data 添加的数据
     * @return int 自增ID
     */
    public function createRoomWelcome(array $data): int;

    /**
     * 添加多条
     * @param array $data 添加的数据
     * @return bool 执行结果
     */
    public function createRoomWelcomes(array $data): bool;

    /**
     * 修改单条 - 根据ID.
     * @param int $id id
     * @param array $data 修改数据
     * @return int 修改条数
     */
    public function updateRoomWelcomeById(int $id, array $data): int;

    /**
     * 删除 - 单条
     * @param int $id 删除ID
     * @return int 删除条数
     */
    public function deleteRoomWelcome(int $id): int;

    /**
     * 删除 - 多条
     * @param array $ids 删除ID
     * @return int 删除条数
     */
    public function deleteRoomWelcomes(array $ids): int;

    /**
     * 查询多条 - 根据ID.
     * @param array $ids ID
     * @param string $name 公司名称
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomWelcomesByIdName(array $ids, string $name, array $columns = ['*']): array;

    /**
     * 查询单条 - 根据ID.
     * @param string $wxRoomWelcomeId 企业微信ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomWelcomesByWxRoomWelcomeId(string $wxRoomWelcomeId, array $columns = ['*']): array;

    /**
     * 查询多条
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getRoomWelcomes(array $columns = ['*']): array;

    /**
     * 获取企业 - 根据租户.
     * @param int $tenantId 租户ID
     * @param array|string[] $columns 字段
     * @return array ...
     */
    public function getRoomWelcomesByTenantId(int $tenantId, array $columns = ['*']): array;
}
