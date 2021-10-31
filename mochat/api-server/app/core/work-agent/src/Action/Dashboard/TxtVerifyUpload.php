<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkAgent\Action\Dashboard;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use League\Flysystem\Filesystem;
use MoChat\Framework\Action\AbstractAction;
use MoChat\Framework\Constants\ErrorCode;
use MoChat\Framework\Exception\CommonException;

/**
 * @Controller
 */
class TxtVerifyUpload extends AbstractAction
{
    /**
     * @deprecated
     * @RequestMapping(path="/dashboard/agent/txtVerifyUpload", methods="POST")
     * @return array ...
     */
    public function handle(Filesystem $filesystem): array
    {
        $file = $this->request->file('file');
        if ($file->getMimeType() !== 'text/plain') {
            throw new CommonException(ErrorCode::INVALID_PARAMS, '文件类型错误');
        }

        try {
            $filesystem->writeStream('wx_txt_verify/' . $file->getClientFilename(), $file->getStream());
        } catch (\Exception $e) {
            throw new CommonException(ErrorCode::SERVER_ERROR, '上传失败:' . $e->getMessage());
        }

        return [];
    }
}
