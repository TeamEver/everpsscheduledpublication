<?php


    use Ever\ScheduledPublication\Install\EverInstaller;

    require_once __DIR__ . '/vendor/autoload.php';

class everpsscheduledpublication extends Module
{

    public function __construct($name = null, Context $context = null)
    {
        $this->name = 'everpsscheduledpublication';
        $this->tab = 'ever';
        $this->version = '1.0.2';
        $this->author = 'ever';
        $this->need_instance = 1;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Module de gestion de publications d\'objet à une date, heure donné', [], self::getTranslationDomain());
        $this->description = $this->trans('Module de gestion de publications d\'objet à une date, heure donné', [], self::getTranslationDomain());
    }

    public function getTabs()
    {
        return [
            [
                'name' => ['Publications produits'],
                'class_name' => 'ObjectSchedulerPublicationController',
                'route_name' => 'admin_scheduled_publication_list',
                'visible' => true,
                'parent_class_name' => 'DEFAULT',
                'icon' => '',
            ],
        ];
    }

    public function getHooks()
    {
        if (property_exists(self::class, 'hooks') && is_array($this->hooks)) {
            return $this->hooks;
        }

        return [];
    }

    public function install()
    {
        $everInstaller = new EverInstaller($this);

        return parent::install() && $everInstaller->install();
    }

    public function uninstall()
    {
        $everInstaller = new EverInstaller($this);

        return parent::uninstall() && $everInstaller->uninstall();
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function getContent()
    {

        $router = $this->get('router');
        return '<h1>Module everpsscheduledpublication</h1>';
    }

    public static $kernel = null;
    /**
     * Get Symfony Kernel to use in front office.
     *
     * @return \AppKernel
     */
    public static function getKernel()
    {
        // if the singleton doesn't exist
        if (!self::$kernel) {
            require_once _PS_ROOT_DIR_.'/app/AppKernel.php';
            $env = _PS_MODE_DEV_ ? 'dev' : 'prod';
            $debug = _PS_MODE_DEV_ ? true : false;
            self::$kernel = new \AppKernel($env, $debug);
            self::$kernel->boot();
        }

        return self::$kernel;
    }

    /**
     * Get a specific Symfony service.
     *
     * @param string $service
     *
     * @return object
     */
    public static function getService($service)
    {
        return self::getKernel()->getContainer()->get($service);
    }

    public static function getTranslationDomain()
    {
        return 'Modules.Everscheduledpublication.module';
    }
}
