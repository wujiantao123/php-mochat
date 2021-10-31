<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\Plugin\RoomAutoPull\Logic;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Inject;
use MoChat\App\Common\Constants\BusinessLog\Event;
use MoChat\App\Common\Contract\BusinessLogContract;
use MoChat\App\Corp\Utils\WeWorkFactory;
use MoChat\App\WorkEmployee\Contract\WorkEmployeeContract;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;
use MoChat\Plugin\RoomAutoPull\Constants\IsVerified;
use MoChat\Plugin\RoomAutoPull\Contract\WorkRoomAutoPullContract;

/**
 * 自动拉群管理- 更新提交.
 *
 * Class UpdateLogic
 */
class UpdateLogic
{
    /**
     * @Inject
     * @var WorkRoomAutoPullContract
     */
    protected $workRoomAutoPullService;

    /**
     * @Inject
     * @var WorkEmployeeContract
     */
    protected $workEmployeeService;

    /**
     * @Inject
     * @var BusinessLogContract
     */
    private $businessLogService;

    /**
     * @Inject()
     * @var WeWorkFactory
     */
    private $weWorkFactory;

    /**
     * @Inject
     * @var StdoutLoggerInterface
     */
    private $logger;

    /**
     * @param array $params 请求参数

     * @return array 响应数组
     */
    public function handle(array $params): array
    {
        // 处理请求参数
        $workRoomAutoPullId = (int) $params['workRoomAutoPullId'];
        // 获取自动拉群信息
        $workRoomAutoPull = $this->workRoomAutoPullService->getWorkRoomAutoPullById($workRoomAutoPullId, ['corp_id', 'wx_config_id']);
        if (empty($workRoomAutoPull)) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '自动拉群信息不存在');
        }
        $params = $this->handleParams($params);
        // 获取使用者的通讯录信息
        $employeeList = $this->getEmployeeList(json_decode($params['employees'], true));

        // 数据操作
        Db::beginTransaction();
        try {
            // 自动拉群
            $this->workRoomAutoPullService->updateWorkRoomAutoPullById($workRoomAutoPullId, $params);
            // 记录业务日志
            $businessLog = [
                'business_id' => $workRoomAutoPullId,
                'params' => json_encode($params),
                'event' => Event::ROOM_AUTO_PULL_UPDATE,
                'operation_id' => user()['workEmployeeId'],
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $this->businessLogService->createBusinessLog($businessLog);

            Db::commit();
        } catch (\Throwable $e) {
            Db::rollBack();
            $this->logger->error(sprintf('%s [%s] %s', '自动拉群更新失败', date('Y-m-d H:i:s'), $e->getMessage()));
            $this->logger->error($e->getTraceAsString());
            throw new CommonException(ErrorCode::SERVER_ERROR, '自动拉群更新失败');
        }

        // 生成-配置客户联系「联系我」方式-二维码
        $skipVerify = $params['is_verified'] == IsVerified::VERIFICATION ? false : true;
        
        $this->updateQrCode((int) $workRoomAutoPull['corpId'], (int) $workRoomAutoPullId, array_column($employeeList, 'wxUserId'), $skipVerify, $workRoomAutoPull['wxConfigId']);

        return $data = [];
    }

    /**
     * @param array $params 请求参数
     * @return array 响应数组
     */
    private function handleParams(array $params): array
    {
        // 使用成员(通讯录用户)
        $params['employees'] = json_encode(array_filter(explode(',', $params['employees'])));
        // 客户标签
        $params['tags'] = json_encode(array_filter(explode(',', $params['tags'])));
        // 更新时间
        $params['updated_at'] = date('Y-m-d H:i:s');

        unset($params['workRoomAutoPullId']);

        return $params;
    }

    /**
     * @param array $employeeIds 企业员工通讯录集合
     * @return array 响应数组
     */
    private function getEmployeeList(array $employeeIds): array
    {
        $data = $this->workEmployeeService->getWorkEmployeesById($employeeIds, ['id', 'wx_user_id']);

        if (count($data) != count($employeeIds)) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '使用者信息错误');
        }
        return $data;
    }

    private function updateQrCode(int $corpId, int $workRoomAutoPullId, array $wxUserId, bool $skipVerify, string $wxConfigId)
    {
        $config = [
            'skip_verify' => $skipVerify,
            'state' => 'workRoomAutoPullId-' . (string)$workRoomAutoPullId,
            'user' => $wxUserId,
        ];

        $weWorkContactApp = $this->weWorkFactory->getContactApp($corpId);
        $qrCodeRes = $weWorkContactApp->contact_way->update($wxConfigId, $config);
        if ($qrCodeRes['errcode'] !== 0) {
            throw new CommonException(ErrorCode::INVALID_PARAMS, sprintf('请求微信服务器更新二维码失败，错误信息：%s', $qrCodeRes['errmsg']));
        }
    }
}
