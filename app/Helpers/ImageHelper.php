<?php

namespace App\Helpers;

class ImageHelper
{
    /**
     * 将相对图片路径转换为完整URL
     *
     * @param string|null $path 相对路径
     * @param string $baseUrl 基础URL
     * @return string
     */
    public static function getFullImageUrl(?string $path, string $baseUrl = 'https://myjob.one'): string
    {
        // 如果路径为空，返回默认图片
        if (empty($path)) {
            return asset('assets/images/company-logos/company1.svg');
        }
        
        // 如果已经是完整URL，直接返回
        if (strpos($path, 'http') === 0) {
            return $path;
        }
        
        // 移除开头的斜杠（如果有）
        $path = ltrim($path, '/');
        
        // 如果是storage路径，直接拼接
        if (strpos($path, 'storage/') === 0) {
            return rtrim($baseUrl, '/') . '/' . $path;
        }
        
        // 其他情况，假设是storage目录下的文件
        return rtrim($baseUrl, '/') . '/storage/' . $path;
    }
    
    /**
     * 处理职位数据中的图片路径
     *
     * @param array $job 职位数据
     * @return array
     */
    public static function processJobImages(array $job): array
    {
        if (isset($job['company_logo'])) {
            $job['company_logo'] = self::getFullImageUrl($job['company_logo']);
        }
        
        return $job;
    }
    
    /**
     * 批量处理职位数据中的图片路径
     *
     * @param array $jobs 职位数据数组
     * @return array
     */
    public static function processJobsImages(array $jobs): array
    {
        return array_map(function($job) {
            return self::processJobImages($job);
        }, $jobs);
    }
    
    /**
     * 处理公司数据中的图片路径
     *
     * @param array $company 公司数据
     * @return array
     */
    public static function processCompanyImages(array $company): array
    {
        if (isset($company['logo'])) {
            $company['logo'] = self::getFullImageUrl($company['logo']);
        }
        
        if (isset($company['image'])) {
            $company['image'] = self::getFullImageUrl($company['image']);
        }
        
        return $company;
    }
    
    /**
     * 批量处理公司数据中的图片路径
     *
     * @param array $companies 公司数据数组
     * @return array
     */
    public static function processCompaniesImages(array $companies): array
    {
        return array_map(function($company) {
            return self::processCompanyImages($company);
        }, $companies);
    }
}