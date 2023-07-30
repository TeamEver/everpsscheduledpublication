<?php

namespace Ever\ScheduledPublication\Install;

interface InstallerInterface
{
    public function install();

    public function uninstall();

    public function installModuleTab(array $tabInfo);

    public function uninstallModuleTab(string $tabClass): bool;
}
