<?php
/**
 * ObjectModel de ejemplo sobre la tabla propia del módulo.
 * Usar como base para cualquier entidad con CRUD en el back office.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class SapyensDevSkeletonItem extends ObjectModel
{
    public $id_shop;
    public $nombre;
    public $date_add;

    public static $definition = [
        'table' => 'sapyensdevskeleton',
        'primary' => 'id_sapyensdevskeleton',
        'multilang' => false,
        'fields' => [
            'id_shop' => [
                'type' => ObjectModel::TYPE_INT,
                'validate' => 'isUnsignedId',
            ],
            'nombre' => [
                'type' => ObjectModel::TYPE_STRING,
                'validate' => 'isGenericName',
                'required' => true,
                'size' => 255,
            ],
            'date_add' => [
                'type' => ObjectModel::TYPE_DATE,
                'validate' => 'isDate',
            ],
        ],
    ];

    /**
     * Sella la fecha de alta automáticamente al crear un elemento nuevo,
     * el llamador no tiene que asignarla a mano.
     */
    public function add($auto_date = true, $null_values = false)
    {
        if (empty($this->date_add)) {
            $this->date_add = date('Y-m-d H:i:s');
        }

        return parent::add($auto_date, $null_values);
    }
}
