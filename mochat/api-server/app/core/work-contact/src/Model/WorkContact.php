<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\WorkContact\Model;

use Hyperf\Database\Model\Concerns\CamelCase;
use Hyperf\Database\Model\SoftDeletes;
use MoChat\Framework\Model\AbstractModel;

/**
 * @property int $id
 * @property int $corpId
 * @property string $wxExternalUserid
 * @property string $name
 * @property string $nickName
 * @property string $avatar
 * @property int $followUpStatus
 * @property int $type
 * @property int $gender
 * @property string $unionid
 * @property string $position
 * @property string $corpName
 * @property string $corpFullName
 * @property string $externalProfile
 * @property string $businessNo
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 * @property string $deletedAt
 */
class WorkContact extends AbstractModel
{
    use CamelCase;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_contact';

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
    protected $casts = ['id' => 'integer', 'corp_id' => 'integer', 'follow_up_status' => 'integer', 'type' => 'integer', 'gender' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public static function newModel($attributes = [])
    {
        return new static($attributes);
    }
}
