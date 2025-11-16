<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * 获取站点配置
     */
    protected function getSiteConfig()
    {
        return app('site.config');
    }
    
    /**
     * 设置页面 SEO 信息
     */
    protected function setSeoData($title = null, $description = null, $keywords = null)
    {
        $siteConfig = $this->getSiteConfig();
        
        $seoData = [
            'title' => $title ? $title . ' - ' . $siteConfig['site_name'] : $siteConfig['site_name'],
            'description' => $description ?: $siteConfig['site_description'],
            'keywords' => $keywords ?: '招聘,求职,工作机会,职位搜索',
            'canonical' => request()->url(),
        ];
        
        view()->share('seo', $seoData);
        
        return $seoData;
    }
}