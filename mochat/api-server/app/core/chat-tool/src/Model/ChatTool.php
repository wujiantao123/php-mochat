<?php

declare(strict_types=1);
/**
 * This file is part of MoChat.
 * @link     https://mo.chat
 * @document https://mochat.wiki
 * @contact  group@mo.chat
 * @license  https://github.com/mochat-cloud/mochat/blob/master/LICENSE
 */
namespace MoChat\App\ChatTool\Model;

use Hyperf\Database\Model\Concerns\CamelCase;
use MoChat\Framework\Model\AbstractModel;

/**
 * @property int $id
 * @property string $pageName
 * @property string $pageFlag
 * @property \Carbon\Carbon $createdAt
 * @property \Carbon\Carbon $updatedAt
 * @property string $deletedAt
 */
class ChatTool extends AbstractModel
{
    use CamelCase;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chat_tool';

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
    protected $casts = ['id' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
