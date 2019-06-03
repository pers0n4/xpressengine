<?php
/**
 * PluginMake.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Symfony\Component\Debug\Exception\FatalThrowableError;
use Xpressengine\Plugin\PluginHandler;

/**
 * Class PluginMake
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMake extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:plugin 
        {name : The name of the plugin}
        {vendor : The vendor name. like your name}
        {--namespace= : The namespace of the plugin. use double backslash(\\\\) as delimiter. default "<Vendor>\\\\XePlugin\\\\\<Name>"}
        {--title= : The title of plugin}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @param PluginHandler $handler PluginHandler
     * @return void
     * @throws \Exception
     */
    public function handle(PluginHandler $handler)
    {
        $name = $this->argument('name');
        $namespace = $this->getNamespace($name, $this->argument('vendor'));

        $title = $this->getTitleInput($name);

        $this->operator->lock();

        try {
            $this->copyStubDirectory($path = app('path.privates').DIRECTORY_SEPARATOR.$name);
            $this->makeUsable($path, $name, $namespace, $title);
            $this->info('Generate the plugin');

            $this->operator->setPrivateMode();
            $this->operator->install($packageName = 'xpressengine-plugin/'.$name, '*');
            $this->operator->write();

            $this->info('Run composer update command');
            $this->line('> composer update');

            $result = $this->composerUpdate([$packageName]);

            if (0 !== $result) {
                throw new \Exception('Fail to run composer update');
            }

            // plugin activate
            $this->activatePlugin($handler, $name);

        } catch (\Exception $e) {
            $this->files->deleteDirectory($path);
            throw $e;
        } catch (\Throwable $e) {
            $this->files->deleteDirectory($path);
            throw new FatalThrowableError($e);
        } finally {
            if ($this->operator->isLocked()) {
                $this->operator->unlock();
            }
        }

        $this->info("Plugin is created and activated successfully.");
        $this->info("See ./plugins/$name directory.");
        $this->info("Input and modify your plugin information in ./plugins/$name/composer.json file.");
    }

    /**
     * Get namespace.
     *
     * @param string $name   plugin name
     * @param string $vendor vendor name
     * @return string
     * @throws \Exception
     */
    protected function getNamespace($name, $vendor)
    {
        if (!$namespace = $this->option('namespace')) {
            $namespace = studly_case($vendor) . '\\XePlugin\\' . studly_case($name);
        }

        // check namespace
        if(!str_contains($namespace, '\\')) {
            throw new \Exception('The namespace must have at least 1 delimiter(\\), use double backslash(\\\\) as delimiter');
        }

        return $namespace;
    }

    /**
     * Get title.
     *
     * @param string $name given name.
     * @return string
     */
    protected function getTitleInput($name)
    {
        return $this->option('title') ?: studly_case($name) . ' plugin';
    }

    /**
     * Get stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__ . '/stubs/plugin';
    }

    /**
     * Make file for plugin by stub.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @param string $title     plugin title
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeUsable($path, $name, $namespace, $title)
    {
        // plugin.php 파일 생성
        $this->makePluginClass($path, $name, $namespace);

        // composer.json 파일 생성
        $this->makeComposerJson($path, $name, $namespace, $title);

        // Controller.php
        $this->makeControllerClass($path, $name, $namespace, $title);

        $this->files->move($path . '/views/index.blade.stub', $path . '/views/index.blade.php');
    }

    /**
     * Make plugin class.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makePluginClass($path, $name, $namespace)
    {
        $search = ['DummyNamespace', 'DummyPluginName'];
        $replace = [$namespace, $name];

        $this->buildFile($path.'/plugin.stub', $search, $replace, $path.'/plugin.php');
    }

    /**
     * Make composer file.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @param string $title     plugin title
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeComposerJson($path, $name, $namespace, $title)
    {
        $namespace = str_replace('\\', '\\\\', $namespace);
        
        $search = ['DummyNamespace', 'DummyPluginName', 'DummyPluginTitle', 'DummyCoreVer'];
        $replace = [$namespace, $name, $title, '~'.__XE_VERSION__];

        $this->buildFile($path.'/composer.json.stub', $search, $replace, $path.'/composer.json');
    }

    /**
     * Make controller class.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @param string $title     plugin title
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeControllerClass($path, $name, $namespace, $title)
    {
        $search = ['DummyNamespace', 'DummyPluginName', 'DummyPluginTitle'];
        $replace = [$namespace, $name, $title];

        $this->buildFile($path.'/src/Controller.stub', $search, $replace, $path.'/src/Controller.php');
    }

    /**
     * Activate plugin.
     *
     * @param PluginHandler $handler PluginHandler
     * @param string        $name    plugin name
     * @return void
     */
    protected function activatePlugin(PluginHandler $handler, $name)
    {
        $handler->getAllPlugins(true);

        if (!$handler->isActivated($name)) {
            $handler->activatePlugin($name);
        }
    }
}
