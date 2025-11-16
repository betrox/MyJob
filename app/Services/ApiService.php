<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiService
{
    /**
     * API 基础 URL
     */
    protected string $baseUrl;

    /**
     * API 密钥
     */
    protected string $apiKey;

    /**
     * 缓存时间（秒）
     */
    protected int $cacheTtl;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url', '/******MyJob API******/');
        $this->apiKey = config('services.api.key', env('API_KEY'));
        $this->cacheTtl = config('services.api.cache_ttl', 86400); // 24小时
    }

    /**
     * 获取职位列表
     */
    public function getJobs(array $params = []): array
    {
        $cacheKey = $this->generateCacheKey('jobs', $params);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($params) {
            return $this->callApi('jobs', $params);
        });
    }

    /**
     * 获取职位详情
     */
    public function getJobDetail($identifier): array
    {
        $cacheKey = $this->generateCacheKey('job_detail', ['identifier' => $identifier]);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($identifier) {
            return $this->callApi("jobs/{$identifier}");
        });
    }

    /**
     * 获取公司列表
     */
    public function getCompanies(array $params = []): array
    {
        $cacheKey = $this->generateCacheKey('companies', $params);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($params) {
            return $this->callApi('companies', $params);
        });
    }

    /**
     * 获取公司详情
     */
    public function getCompanyDetail($companyId): array
    {
        $cacheKey = $this->generateCacheKey('company_detail', ['id' => $companyId]);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($companyId) {
            return $this->callApi("companies/{$companyId}");
        });
    }

    /**
     * 获取职位分类
     */
    public function getCategories(): array
    {
        $cacheKey = $this->generateCacheKey('categories');
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () {
            return $this->callApi('jobs/categories');
        });
    }

    /**
     * 获取相似职位
     */
    public function getSimilarJobs($jobId, array $params = []): array
    {
        $cacheKey = $this->generateCacheKey('similar_jobs', array_merge(['job_id' => $jobId], $params));
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($jobId, $params) {
            return $this->callApi("jobs/{$jobId}/similar", $params);
        });
    }

    /**
     * 获取搜索建议
     */
    public function getJobSuggestions(array $params = []): array
    {
        $cacheKey = $this->generateCacheKey('job_suggestions', $params);
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($params) {
            return $this->callApi('jobs/suggestions', $params);
        });
    }

    /**
     * 获取行业列表
     */
    public function getIndustries(): array
    {
        $cacheKey = $this->generateCacheKey('industries');
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () {
            return $this->callApi('companies/industries');
        });
    }

    /**
     * 获取公司职位列表
     */
    public function getCompanyJobs($companyId, array $params = []): array
    {
        $cacheKey = $this->generateCacheKey('company_jobs', array_merge(['company_id' => $companyId], $params));
        
        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($companyId, $params) {
            return $this->callApi("companies/{$companyId}/jobs", $params);
        });
    }

    /**
     * 调用 API
     */
    protected function callApi(string $endpoint, array $params = []): array
    {
        try {
            $url = rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
            
            // 添加 API 密钥到参数中
            $params['api_key'] = $this->apiKey;
            
            // 添加语言参数到API调用中
            $currentLocale = app()->getLocale();
            if ($currentLocale && $currentLocale !== 'en') {
                $params['lang'] = $currentLocale;
            }
            
            $response = Http::timeout(30)
                ->retry(3, 100)
                ->withOptions([
                    'verify' => false, // 禁用SSL验证以解决PHP 7.4证书问题
                ])
                ->get($url, $params);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success']) {
                    return $data;
                }
                
                Log::warning('API 返回失败', [
                    'endpoint' => $endpoint,
                    'response' => $data
                ]);
                
                return ['success' => false, 'message' => 'API 返回数据格式错误'];
            }
            
            Log::error('API 请求失败', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'response' => $response->body()
            ]);
            
            return ['success' => false, 'message' => 'API 请求失败'];
            
        } catch (\Exception $e) {
            Log::error('API 调用异常', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            
            return ['success' => false, 'message' => 'API 调用异常: ' . $e->getMessage()];
        }
    }

    /**
     * 生成缓存键
     */
    protected function generateCacheKey(string $type, array $params = []): string
    {
        $paramString = !empty($params) ? '_' . md5(json_encode($params)) : '';
        return "external_api_{$type}{$paramString}";
    }

    /**
     * 清除特定类型的缓存
     */
    public function clearCache(string $type = null): bool
    {
        if ($type) {
            // 清除特定类型的缓存
            $pattern = "external_api_{$type}*";
            // 使用简单的缓存键前缀匹配
            $keys = Cache::getStore()->get("*{$pattern}*");
            if ($keys) {
                foreach ($keys as $key) {
                    Cache::forget($key);
                }
            }
            return true;
        }
        
        // 清除所有外部 API 缓存 - 使用更简单的方法
        // 由于文件缓存不支持模式匹配，我们手动清除已知的缓存键
        $cacheKeys = [
            'external_api_jobs',
            'external_api_categories',
            'external_api_companies',
            'external_api_similar_jobs',
            'external_api_job_suggestions',
            'external_api_industries',
            'external_api_company_jobs'
        ];
        
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
        
        return true;
    }

    /**
     * 获取缓存统计信息
     */
    public function getCacheStats(): array
    {
        $keys = Cache::getStore()->getAllKeys();
        $apiKeys = array_filter($keys, function ($key) {
            return strpos($key, 'external_api_') === 0;
        });
        
        return [
            'total_keys' => count($apiKeys),
            'keys' => $apiKeys
        ];
    }
}