<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkContact\Contract;

interface ContactFieldContract
{
    /**
     * 查询单条 - 根据ID.
     * @param int $id ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getContactFieldById(int $id, array $columns = ['*']): array;

    /**
     * 查询多条 - 根据ID.
     * @param array $ids ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getContactFieldsById(array $ids, array $columns = ['*']): array;

    /**
     * 多条分页.
     * @param array $where 查询条件
     * @param array|string[] $columns 查询字段
     * @param array $options 可选项 ['orderByRaw'=> 'id asc', 'perPage' => 15, 'page' => null, 'pageName' => 'page']
     * @return array 分页结果 Hyperf\Paginator\Paginator::toArray
     */
    public function getContactFieldList(array $where, array $columns = ['*'], array $options = []): array;

    /**
     * 添加单条
     * @param array $data 添加的数据
     * @return int 自增ID
     */
    public function createContactField(array $data): int;

    /**
     * 添加多条
     * @param array $data 添加的数据
     * @return bool 执行结果
     */
    public function createContactFields(array $data): bool;

    /**
     * 修改单条 - 根据ID.
     * @param int $id id
     * @param array $data 修改数据
     * @return int 修改条数
     */
    public function updateContactFieldById(int $id, array $data): int;

    /**
     * 删除 - 单条
     * @param int $id 删除ID
     * @return int 删除条数
     */
    public function deleteContactField(int $id): int;

    /**
     * 删除 - 多条
     * @param array $ids 删除ID
     * @return int 删除条数
     */
    public function deleteContactFields(array $ids): int;

    /**
     * 查询多条 - 根据状态.
     * @param int $status 状态
     * @param array $columns 字段
     * @return array 返回值
     */
    public function getContactFieldsByStatus(int $status, array $columns = ['*']): array;

    /**
     * 批量修改 - 根据IDs.
     * @param array $data 数据
     * @return int 修改条数
     */
    public function updateContactFieldsCaseIds(array $data): int;

    /**
     * 查询多条 - 根据状态.按排序展示倒序.
     * @param int $status 状态
     * @param array $columns 查询字段
     * @return array 返回值
     */
    public function getContactFieldsByStatusOrderByOrder(int $status, array $columns = ['*']): array;

    /**
     * 是否存在该label.
     * @param string $label ...
     * @param array $where ...
     * @return bool ...
     */
    public function existContactFieldsByLabel(string $label, array $where = []): bool;
}
