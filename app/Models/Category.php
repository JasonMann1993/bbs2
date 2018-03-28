<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name', 'description',
    ];

    public function scopeWithOrder($query, $order)
    {
        // 不同排序，使用不同的数据读取逻辑
        switch ($order) {
            case 'recent':
                $query = $this->recent();
                break;

            default:
                $query = $this->RecentReplied();
                break;
        }
        // 预加载防止 N+1 问题
        return $query->with('user', 'category');
    }
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
