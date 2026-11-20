<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_COMPLETED = 'completed';

    /** @var list<string> */
    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_IN_PROGRESS,
        self::STATUS_COMPLETED,
    ];

    /** @var list<string> */
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
    ];

    /**
     * Dono da tarefa.
     *
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marca a tarefa como concluída.
     */
    public function markAsCompleted(): void
    {
        $this->update(['status' => self::STATUS_COMPLETED]);
    }
}
