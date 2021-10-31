<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkAgent\Contract;

interface WorkAgentContract
{
    /**
     * 查询单条 - 根据ID.
     * @param int $id ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getWorkAgentById(int $id, array $columns = ['*']): array;

    /**
     * 查询多条 - 根据ID.
     * @param array $ids ID
     * @param array|string[] $columns 查询字段
     * @return array 数组
     */
    public function getWorkAgentsById(array $ids, array $columns = ['*']): array;

    /**
     * 多条分页.
     * @param array $where 查询条件
     * @param array|string[] $columns 查询字段
     * @param array $options 可选项 ['orderByRaw'=> 'id asc', 'perPage' => 15, 'page' => null, 'pageName' => 'page']
     * @return array 分页结果 Hyperf\Paginator\Paginator::toArray
     */
    public function getWorkAgentList(array $where, array $columns = ['*'], array $options = []): array;

    /**
     * 添加单条
     * @param array $data 添加的数据
     * @return int 自增ID
     */
    public function createWorkAgent(array $data): int;

    /**
     * 添加多条
     * @param array $data 添加的数据
     * @return bool 执行结果
     */
    public function createWorkAgents(array $data): bool;

    /**
     * 修改单条 - 根据ID.
     * @param int $id id
     * @param array $data 修改数据
     * @return int 修改条数
     */
    public function updateWorkAgentById(int $id, array $data): int;

    /**
     * 删除 - 单条
     * @param int $id 删除ID
     * @return int 删除条数
     */
    public function deleteWorkAgent(int $id): int;

    /**
     * 删除 - 多条
     * @param array $ids 删除ID
     * @return int 删除条数
     */
    public function deleteWorkAgents(array $ids): int;

    /**
     * 获取多条 - 未停用的所有应用.
     * @param int $corpId 企业ID
     * @param array $columns ...
     * @return array ...
     */
    public function getWorkAgentByCorpIdClose(int $corpId, array $columns = ['*']): array;

    /**
     * 根据id和企业id获取应用.
     * @param int $id 应用ID
     * @param int $corpId 企业ID
     * @param array $columns ...
     * @return array ...
     */
    public function getWorkAgentByIdCorpId(int $id, int $corpId, array $columns = ['*']): array;

    /**
     * 获取所有应用.
     * @param array $columns ...
     * @return array ...
     */
    public function getWorkAgents(array $columns = ['*']): array;

    /**
     * 获取单条 - 根据微信应用id.
     * @param string $wxAgentId 微信应用ID
     * @param array $columns ...
     * @return array ...
     */
    public function getWorkAgentByWxAgentId(string $wxAgentId, array $columns = ['*']): array;

    /**
     * 获取单条 - 根据企业id获取提醒专用应用(暂时获取第一个可用的).
     * @param int $corpId 微信应用ID
     * @param array $columns ...
     * @return array ...
     */
    public function getWorkAgentRemindByCorpId(int $corpId, array $columns = ['*']): array;
}
