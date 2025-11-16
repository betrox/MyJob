<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * 生成 sitemap.xml
     */
    public function index(): Response
    {
        $cacheKey = 'sitemap_xml';
        $cacheTtl = 86400; // 24小时
        
        $xmlContent = Cache::remember($cacheKey, $cacheTtl, function () {
            return $this->generateSitemap();
        });
        
        return response($xmlContent, 200, [
            'Content-Type' => 'application/xml; charset=utf-8',
        ]);
    }

    /**
     * 生成 sitemap 内容
     */
    protected function generateSitemap(): string
    {
        $urls = $this->getSitemapUrls();
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        foreach ($urls as $url) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . PHP_EOL;
            
            if (isset($url['lastmod'])) {
                $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
            }
            
            if (isset($url['changefreq'])) {
                $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            }
            
            if (isset($url['priority'])) {
                $xml .= '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            }
            
            $xml .= '  </url>' . PHP_EOL;
        }
        
        $xml .= '</urlset>' . PHP_EOL;
        
        return $xml;
    }

    /**
     * 获取所有需要包含在 sitemap 中的 URL
     */
    protected function getSitemapUrls(): array
    {
        $urls = [
            // 首页
            [
                'loc' => url('/'),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            // 静态页面
            [
                'loc' => url('/about'),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => url('/contact'),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            // 职位列表页
            [
                'loc' => url('/jobs'),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ],
        ];
        
        // 添加职位详情页
        $jobUrls = $this->getJobUrls();
        $urls = array_merge($urls, $jobUrls);
        
        return $urls;
    }

    /**
     * 获取职位详情页 URL
     */
    protected function getJobUrls(): array
    {
        $apiService = new ApiService();
        
        // 获取所有职位（限制数量，避免 sitemap 过大）
        $jobsData = $apiService->getJobs(['limit' => 1000]);
        
        // 修复：检查 API 返回的数据结构
        if (empty($jobsData) || (isset($jobsData['success']) && !$jobsData['success']) || empty($jobsData['data'])) {
            return [];
        }
        
        $jobs = $jobsData['data'] ?? $jobsData;
        $urls = [];
        
        foreach ($jobs as $job) {
            $urls[] = [
                'loc' => url('/jobs/' . ($job['slug'] ?? $this->generateJobSlug($job))),
                'lastmod' => $job['updated_at'] ?? date('c'),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }
        
        return $urls;
    }

    /**
     * 生成职位 slug
     */
    protected function generateJobSlug(array $job): string
    {
        $title = preg_replace('/[^\p{L}\p{N}\s]/u', '', $job['name'] ?? $job['title'] ?? '');
        $title = preg_replace('/\s+/', '-', $title);
        $title = strtolower($title);
        
        return $title . '-' . ($job['id'] ?? '');
    }
}

/**
 * Artisan 命令：手动生成 sitemap
 */
class SitemapGenerateCommand
{
    /**
     * 生成 sitemap 并保存到文件
     */
    public function handle(): int
    {
        $controller = new SitemapController();
        $xmlContent = $controller->generateSitemap();
        
        $filePath = public_path('sitemap.xml');
        
        if (file_put_contents($filePath, $xmlContent) !== false) {
            echo "Sitemap generated successfully: {$filePath}" . PHP_EOL;
            return 0;
        }
        
        echo "Failed to generate sitemap" . PHP_EOL;
        return 1;
    }
}