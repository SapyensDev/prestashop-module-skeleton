<?php
/**
 * Skeleton de módulo PrestaShop - SapyensDev
 * Compatible con PrestaShop 1.7, 8.x y 9.x
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class SapyensDevSkeleton extends Module
{
    public function __construct()
    {
        $this->name = 'sapyensdevskeleton';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'SapyensDev';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7',
            'max' => _PS_VERSION_,
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('SapyensDev Skeleton');
        $this->description = $this->l('Módulo de ejemplo para arrancar nuevos desarrollos en PrestaShop.');

        $this->confirmUninstall = $this->l('¿Seguro que quieres desinstalar este módulo?');
    }

    /**
     * Se ejecuta al instalar el módulo: registra hooks, crea la tabla propia
     * y da de alta los valores de configuración por defecto.
     */
    public function install()
    {
        if (!parent::install()) {
            $this->_errors[] = $this->l('No se pudo completar la instalación base del módulo.');
            return false;
        }

        if (!$this->registerHook('displayHeader')
            || !$this->registerHook('displayFooter')
            || !$this->registerHook('displayBackOfficeHeader')
        ) {
            $this->_errors[] = $this->l('No se pudieron registrar los hooks del módulo.');
            return false;
        }

        if (!$this->installDb()) {
            $this->_errors[] = $this->l('No se pudo crear la tabla del módulo en la base de datos.');
            return false;
        }

        if (!$this->installTab()) {
            $this->_errors[] = $this->l('No se pudo dar de alta la sección del módulo en el menú de administración.');
            return false;
        }

        if (!Configuration::updateValue('SAPYENSDEVSKELETON_MENSAJE', 'Hola desde SapyensDev')) {
            $this->_errors[] = $this->l('No se pudo guardar la configuración por defecto del módulo.');
            return false;
        }

        return true;
    }

    /**
     * Se ejecuta al desinstalar: elimina la tabla propia y limpia
     * la configuración del módulo.
     */
    public function uninstall()
    {
        if (!parent::uninstall()) {
            $this->_errors[] = $this->l('No se pudo completar la desinstalación base del módulo.');
            return false;
        }

        if (!$this->uninstallDb()) {
            $this->_errors[] = $this->l('No se pudo eliminar la tabla del módulo en la base de datos.');
            return false;
        }

        if (!$this->uninstallTab()) {
            $this->_errors[] = $this->l('No se pudo eliminar la sección del módulo del menú de administración.');
            return false;
        }

        if (!Configuration::deleteByName('SAPYENSDEVSKELETON_MENSAJE')) {
            $this->_errors[] = $this->l('No se pudo limpiar la configuración del módulo.');
            return false;
        }

        return true;
    }

    /**
     * Crea la tabla propia del módulo. Cada módulo que necesite persistir
     * datos propios (no configuración simple) debería tener su propia tabla,
     * nunca reutilizar tablas del core.
     */
    protected function installDb()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sapyensdevskeleton` (
            `id_sapyensdevskeleton` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `id_shop` INT UNSIGNED NOT NULL DEFAULT 1,
            `nombre` VARCHAR(255) NOT NULL,
            `date_add` DATETIME NOT NULL,
            PRIMARY KEY (`id_sapyensdevskeleton`),
            KEY `id_shop` (`id_shop`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8mb4';

        return Db::getInstance()->execute($sql);
    }

    /**
     * Elimina la tabla propia del módulo. Se llama siempre en uninstall()
     * para no dejar basura en la base de datos.
     */
    protected function uninstallDb()
    {
        $sql = 'DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'sapyensdevskeleton`';

        return Db::getInstance()->execute($sql);
    }

    /**
     * Da de alta la pestaña del back office que apunta a
     * AdminSapyensDevSkeletonItemController, dentro del menú de Módulos.
     */
    protected function installTab()
    {
        $tab = new Tab();
        $tab->class_name = 'AdminSapyensDevSkeletonItem';
        $tab->module = $this->name;
        $tab->id_parent = (int) Tab::getIdFromClassName('AdminParentModules');
        $tab->active = 1;

        foreach (Language::getLanguages(false) as $lang) {
            $tab->name[$lang['id_lang']] = 'SapyensDev Skeleton';
        }

        return $tab->add();
    }

    /**
     * Elimina la pestaña dada de alta en installTab().
     */
    protected function uninstallTab()
    {
        $id_tab = (int) Tab::getIdFromClassName('AdminSapyensDevSkeletonItem');

        if (!$id_tab) {
            return true;
        }

        $tab = new Tab($id_tab);

        return $tab->delete();
    }

    /**
     * Hook de ejemplo en el front que inyecta el CSS del módulo en el <head>.
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet(
            'sapyensdevskeleton-style',
            'modules/' . $this->name . '/views/css/front.css',
            ['media' => 'all', 'priority' => 150]
        );

        $this->context->controller->registerJavascript(
            'sapyensdevskeleton-script',
            'modules/' . $this->name . '/views/js/front.js',
            ['position' => 'bottom', 'priority' => 150]
        );
    }

    /**
     * Hook de ejemplo que inyecta CSS propio solo en las páginas del back
     * office, útil para estilar la pantalla de configuración o el listado
     * del AdminController sin afectar al front.
     */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') !== $this->name
            && Tools::getValue('controller') !== 'AdminSapyensDevSkeletonItem'
        ) {
            return;
        }

        $this->context->controller->addCSS(
            $this->_path . 'views/css/admin.css'
        );
    }

    /**
     * Hook de ejemplo en el front que muestra el mensaje configurado en el footer.
     */
    public function hookDisplayFooter()
    {
        $this->context->smarty->assign([
            'sapyensdevskeleton_mensaje' => Configuration::get('SAPYENSDEVSKELETON_MENSAJE'),
        ]);

        return $this->fetch('module:' . $this->name . '/views/templates/hook/footer.tpl');
    }

    /**
     * Página de configuración del módulo en el back office (Módulos > Configurar).
     * Es el patrón estándar de PrestaShop para ajustes simples, sin necesitar
     * un AdminController aparte.
     */
    public function getContent()
    {
        $output = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            $mensaje = (string) Tools::getValue('SAPYENSDEVSKELETON_MENSAJE');

            if (empty($mensaje)) {
                $output .= $this->displayError($this->l('El mensaje no puede estar vacío.'));
            } else {
                Configuration::updateValue('SAPYENSDEVSKELETON_MENSAJE', $mensaje);
                $output .= $this->displayConfirmation($this->l('Configuración actualizada correctamente.'));
            }
        }

        return $output . $this->renderForm();
    }

    /**
     * Construye el formulario de configuración con el helper estándar de PrestaShop.
     */
    protected function renderForm()
    {
        $fields_form = [
            'form' => [
                'legend' => [
                    'title' => $this->l('Configuración'),
                    'icon' => 'icon-cogs',
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Mensaje a mostrar en el footer'),
                        'name' => 'SAPYENSDEVSKELETON_MENSAJE',
                        'size' => 40,
                        'required' => true,
                    ],
                ],
                'submit' => [
                    'title' => $this->l('Guardar'),
                ],
            ],
        ];

        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->submit_action = 'submit' . $this->name;
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->fields_value['SAPYENSDEVSKELETON_MENSAJE'] = Tools::getValue(
            'SAPYENSDEVSKELETON_MENSAJE',
            Configuration::get('SAPYENSDEVSKELETON_MENSAJE')
        );

        return $helper->generateForm([$fields_form]);
    }
}
