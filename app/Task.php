<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $user_id
 * @property integer $created_at
 */
class Task extends Model
{
    protected $fillable = ['title', 'description', 'status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => htmlspecialchars($this->title, ENT_QUOTES, 'UTF-8'),
            'description' => htmlspecialchars($this->description, ENT_QUOTES, 'UTF-8'),
            'status' => $this->status,
            'created_at' => $this->created_at->format('jS M Y, h:i A'),
        ];
    }
}
