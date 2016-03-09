<?php

namespace Neposoft\FieldAcl;


trait FieldAcl
{
    protected static $aclUserRole = null;


    public static function setFieldAclRole($role)
    {
        static::$aclUserRole = $role;
    }

    public function getHidden()
    {
        $role = static::$aclUserRole ? static::$aclUserRole : 'public';
        $hidden = static::getHiddenFields(get_class($this), $role);
        if ($hidden) {
            $this->setHidden($hidden);
        }
        return parent::getHidden();
    }

    protected static $cache = [];

    public static function getHiddenFields($class, $role)
    {
        if (isset(static::$cache[$class]['hidden'][$role])) {
            return static::$cache[$class]['hidden'][$role];
        }
        $row = \DB::table(\Config::get('fieldAcl.table'))
            ->where('model', $class)
            ->where('role', $role)
            ->first(['hidden_fields']);
        $hidden = [];

        if ($row && ($fields = json_decode($row->hidden_fields))) {
            $hidden = $fields;
        }
        static::$cache[$class]['hidden'][$role] = $hidden;
        return $hidden;
    }

    protected static function setUpdateableFields(&$model, &$user)
    {
        //TODO
    }
}
