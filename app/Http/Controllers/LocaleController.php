<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * 切换语言
     */
    public function switch($locale)
    {
        // 验证语言是否支持
        $supportedLocales = ['en', 'zh', 'ko', 'ja', 'ru', 'vi'];
        if (!in_array($locale, $supportedLocales)) {
            $locale = 'en';
        }
        
        // 保存语言设置到session
        Session::put('locale', $locale);
        
        // 获取来源页面URL
        $referer = request()->headers->get('referer');
        
        if ($referer) {
            // 解析referer URL
            $refererUrl = parse_url($referer);
            $refererHost = $refererUrl['host'] ?? '';
            $refererPath = $refererUrl['path'] ?? '';
            
            // 验证referer主机是否与当前主机匹配
            if ($refererHost === request()->getHost()) {
                // 处理路径，添加或替换语言前缀
                $pathSegments = explode('/', trim($refererPath, '/'));
                $supportedLocales = ['en', 'zh', 'ko', 'ja', 'ru', 'vi'];
                
                // 如果第一个段是支持的语言，则替换它
                if (!empty($pathSegments[0]) && in_array($pathSegments[0], $supportedLocales)) {
                    $pathSegments[0] = $locale;
                } else {
                    // 否则在开头插入语言代码
                    array_unshift($pathSegments, $locale);
                }
                
                // 重建路径
                $newPath = '/' . implode('/', $pathSegments);
                
                // 重定向到新的URL
                return redirect($newPath);
            }
        }
        
        // 如果无法获取referer或referer不匹配，尝试使用当前请求路径
        $currentPath = request()->path();
        if ($currentPath && $currentPath !== 'locale/' . $locale) {
            $pathSegments = explode('/', trim($currentPath, '/'));
            $supportedLocales = ['en', 'zh', 'ko', 'ja', 'ru', 'vi'];
            
            // 如果第一个段是支持的语言，则替换它
            if (!empty($pathSegments[0]) && in_array($pathSegments[0], $supportedLocales)) {
                $pathSegments[0] = $locale;
            } else {
                // 否则在开头插入语言代码
                array_unshift($pathSegments, $locale);
            }
            
            // 重建路径
            $newPath = '/' . implode('/', $pathSegments);
            
            // 重定向到新的URL
            return redirect($newPath);
        }
        
        // 如果所有方法都失败，重定向到首页
        return redirect('/' . $locale);
    }
}