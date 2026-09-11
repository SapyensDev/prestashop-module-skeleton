<?php
/**
 * Controlador de ejemplo con listado y formulario (CRUD) sobre
 * SapyensDevSkeletonItem, usando los helpers estándar de PrestaShop.
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class AdminSapyensDevSkeletonItemController extends ModuleAdminController
{
    public function __construct()
    {
        $this->table = 'sapyensdevskeleton';
        $this->identifier = 'id_sapyensdevskeleton';
        $this->className = 'SapyensDevSkeletonItem';
        $this->lang = false;

        parent::__construct();

        $this->fields_list = [
            'id_sapyensdevskeleton' => [
                'title' => $this->l('ID'),
                'align' => 'center',
                'width' => 40,
            ],
            'nombre' => [
                'title' => $this->l('Nombre'),
            ],
            'date_add' => [
                'title' => $this->l('Fecha de alta'),
                'type' => 'datetime',
            ],
        ];
    }

    /**
     * Formulario de alta/edición de un elemento.
     */
    public function renderForm()
    {
        $this->fields_form = [
            'legend' => [
                'title' => $this->l('Elemento'),
                'icon' => 'icon-cogs',
            ],
            'input' => [
                [
                    'type' => 'text',
                    'label' => $this->l('Nombre'),
                    'name' => 'nombre',
                    'required' => true,
                ],
            ],
            'submit' => [
                'title' => $this->l('Guardar'),
            ],
        ];

        return parent::renderForm();
    }
}
