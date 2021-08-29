<?php

namespace App\Services;

class Utility
{
    const VHOST_ROOT_DIR = '/etc/apache2/conf.d/vhosts';
    const MANAGE_VHOST_CONFIG_FILE = 'z99.vhostmanager.conf';
    const VHOST_DOC_ROOT = '/var/www/user-apps';
    const VHOST_CONFIG_TEMPLATE = '<VirtualHost *:80>
            DocumentRoot %doc_root%
            ServerName %vhost_domain%
            <Directory "%doc_root%">
                Options FollowSymlinks Includes
                AllowOverride All
                Require all granted
            </Directory>

            <IfModule mod_rewrite.c>
                RewriteEngine On
            </IfModule>
        </VirtualHost>';

    public static function reloadAapach()
    {
        exec("sudo httpd -k graceful");
    }

    public static function getVhostDocRoot($vhostDomain)
    {
        return self::VHOST_DOC_ROOT."/{$vhostDomain}";
    }

    public static function getVhostConfig($vhostDomain)
    {
        $vhostDocRoot = self::getVhostDocRoot($vhostDomain);
        return str_replace(["%doc_root%", "%vhost_domain%"], [$vhostDocRoot, $vhostDomain], self::VHOST_CONFIG_TEMPLATE);
    }

    public static function prepareCreateVhost($vhostDomain)
    {
        $vhostDocRoot = self::getVhostDocRoot($vhostDomain);
        if (!file_exists($vhostDocRoot)) {
            shell_exec("sudo mkdir -p {$vhostDocRoot}");
            shell_exec("chmod 777 {$vhostDocRoot}");
        }
    }

    public static function createSampleIndex($domainName)
    {
        $documentRoot = self::getVhostDocRoot($domainName);
        $indexPath = $documentRoot.'/index.html';
        if (!file_exists($indexPath)) {
            file_put_contents($indexPath, '<html><head><meta charset="UTF-8"></head><body><h1>'.$domainName.'の表示確認用サンプルです。<br>このファイルは削除しても問題ありません</h1></body></html>');
            chmod($indexPath, 0777);
        }
    }

    public static function createVhost($vhostDomain)
    {
        self::prepareCreateVhost($vhostDomain);
        $vhostConfig = self::getVhostConfig($vhostDomain);
        $hostNo = count(self::loadVhosts()) + 1;
        file_put_contents(self::VHOST_ROOT_DIR."/v{$hostNo}_{$vhostDomain}.conf", $vhostConfig);
        self::createSampleIndex($vhostDomain);
        self::reloadAapach();
    }

    public static function loadVhosts()
    {
        $hosts = [];
        foreach (glob(self::VHOST_ROOT_DIR.'/v*') as $filename) {
            if (preg_match('/'.preg_quote(self::MANAGE_VHOST_CONFIG_FILE).'$/', $filename)) {
                continue;
            }
            preg_match('/DocumentRoot.+$/m', file_get_contents($filename), $docRootMatch);
            if (count($docRootMatch) == 0) {
                continue;
            }

            preg_match('/ServerName.+$/m', file_get_contents($filename), $serverNameMatch);
            if (count($docRootMatch) == 0) {
                continue;
            }

            $hosts[] = [
                    'sort' => preg_replace('/^v|_.+/', '', $filename),
                    'document_root' => preg_replace('/DocumentRoot| /', '', $docRootMatch[0]),
                    'domain_name' => preg_replace('/ServerName| /', '', $serverNameMatch[0]),
                    'vhost_file' => $filename
                ];
        }
        array_multisort(array_column($hosts, 'sort'), SORT_DESC, $hosts);
        return $hosts;
    }

    public static function deleteVhost($domainName)
    {
        $target = self::getHostInfo($domainName);
        if (count($target) == 0) {
            return;
        }
        if (file_exists($target['vhost_file'])) {
            shell_exec('sudo rm -f '.$target['vhost_file']);
        }
        if (file_exists($target['document_root'])) {
            shell_exec('sudo rm -rf '.$target['document_root']);
        }
        self::reloadAapach();
    }

    public static function getHostInfo($domainName)
    {
        $targetHost = [];
        foreach (self::loadVhosts() as $h) {
            if ($h['domain_name'] == $domainName) {
                $targetHost = $h;
            }
        }
        return $targetHost;
    }
}
