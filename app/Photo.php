<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Photo extends Model
{
    /**
     * 主キー
     * @var string
     */
    protected $keyType = 'string';

    /**
     * モデルの主キーを自動増分させるか
     * @var boolean
     */
    public $incrementing = false;

    /** JSONに含める属性 */
    protected $appends = [
        'url', 'likes_count', 'liked_by_user',
    ];

    /** JSONに含める属性 */
    protected $visible = [
        'id', 'owner', 'url', 'comments', 'likes_count', 'liked_by_user'
    ];

    /** JSONに含めない属性 */
    // protected $hidden = [
    //     'user_id', 'filename', self::CREATED_AT, self::UPDATED_AT,
    // ];

    /** １ページ値のアイテム数 */
    protected $perPage = 9;

    const ID_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if(!Arr::get($this->attributes, 'id')) {
            $this->setId();
        }
    }

    /**
     * ランダムなID値をid属性に代入する
     */
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }

    /**
     * ランダムなID値を生成する
     * @return string
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'), range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }

    /**
     * リレーションシップ - usersテーブル
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    /**
     * リレーションシップ - commentsテーブル
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }

    /**
     * リレーションシップ - likesテーブル
     */
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    /**
     * アクセサ - url
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::cloud()->url($this->attributes['filename']);
    }

    /**
     * アクセサ - likes_count
     * @return int
     */
    public function getLikesCountAttribute()
    {
        return $this->likes->count();
    }

    /**
     * アクセサ - likes_by_count
     * @return boolean
     */
    public function getLikedByUserAttribute()
    {
        if(Auth::guest()) {
            return false;
        }

        return $this->likes->contains(function($user) {
            return $user->id === Auth::user()->id;
        });
    }
}
