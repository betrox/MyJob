<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SetSiteConfig
{
    /**
     * 处理传入请求
     */
    public function handle(Request $request, Closure $next)
    {
        // 获取站点配置
        $siteConfig = $this->getSiteConfig($request->getHost());
        
        // 注册为全局服务
        app()->instance('site.config', $siteConfig);
        
        // 共享到所有视图
        view()->share('site', $siteConfig);
        
        return $next($request);
    }

    /**
     * 根据域名获取站点配置
     */
    protected function getSiteConfig(string $host): array
    {
        $configFile = config('services.site_config_file', 'config/sites.json');
        $configPath = base_path($configFile);
        
        if (!file_exists($configPath)) {
            // 返回默认配置
            return [
                'site_name' => 'MyJob Portal',
                'site_description' => '专业的招聘与求职平台',
            ];
        }
        
        $config = json_decode(file_get_contents($configPath), true);
        
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($config)) {
            return $this->getDefaultConfig();
        }
        
        // 检查域名匹配
        if (isset($config['domains']) && is_array($config['domains'])) {
            foreach ($config['domains'] as $domainConfig) {
                if ($this->matchesDomain($host, $domainConfig['pattern'] ?? '')) {
                    return array_merge($config['default'] ?? [], $domainConfig);
                }
            }
        }
        
        // 返回默认配置
        return $config['default'] ?? $this->getDefaultConfig();
    }

    /**
     * 检查域名是否匹配模式
     */
    protected function matchesDomain(string $host, string $pattern): bool
    {
        if (empty($pattern)) {
            return false;
        }
        
        // 精确匹配
        if ($pattern === $host) {
            return true;
        }
        
        // 通配符匹配
        if (strpos($pattern, '*') !== false) {
            $pattern = str_replace('*', '[^.]+', $pattern);
            $pattern = '/^' . str_replace('.', '\.', $pattern) . '$/';
            
            return preg_match($pattern, $host) === 1;
        }
        
        return false;
    }

    /**
     * 获取默认配置
     */
    protected function getDefaultConfig(): array
    {
        return [
            'site_name' => 'MyJob Portal',
            'site_description' => '专业的招聘与求职平台',
        ];
    }
}