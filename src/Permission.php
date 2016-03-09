<?php namespace Neposoft\FieldAcl;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'fieldacl_permissions';

    public $timestamps = false;

    public static $unguarded = true;

    public $casts = [
        'hidden_fields' => 'array'
    ];
}