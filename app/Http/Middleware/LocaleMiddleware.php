<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 首先尝试从URL路径中获取语言
        $path = $request->path();
        $supportedLocales = ['en', 'zh', 'ko', 'ja', 'ru', 'vi'];
        
        // 检查路径是否以支持的语言代码开头
        $pathSegments = explode('/', $path);
        if (!empty($pathSegments[0]) && in_array($pathSegments[0], $supportedLocales)) {
            $locale = $pathSegments[0];
        } else {
            // 如果URL中没有语言代码，则使用英文作为默认语言
            $locale = 'en';
        }
        
        // 设置应用语言
        App::setLocale($locale);
        
        return $next($request);
    }
}