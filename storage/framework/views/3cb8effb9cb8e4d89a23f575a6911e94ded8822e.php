<?php if(!empty($pagination) && is_array($pagination) && count($pagination) > 0): ?>
<div class="pagination-container">
    <div class="pagination-info">
        <?php
            // 修复分页信息显示：正确计算from和to值
            $currentPage = $pagination['current_page'] ?? 1;
            $perPage = $pagination['per_page'] ?? 20;
            $total = $pagination['total'] ?? 0;
            
            // 确保当前页数有效
            if ($currentPage < 1) $currentPage = 1;
            
            // 计算正确的from和to值
            $from = (($currentPage - 1) * $perPage) + 1;
            $to = min($currentPage * $perPage, $total);
            
            // 如果当前页没有数据，显示0
            if ($from > $total) {
                $from = 0;
                $to = 0;
            }
        ?>
        <p><?php echo e(__('messages.showing')); ?> <?php echo e($from); ?> <?php echo e(__('messages.to')); ?> <?php echo e($to); ?> <?php echo e(__('messages.of_total')); ?> <?php echo e($total); ?> <?php echo e(__('messages.results')); ?></p>
    </div>
    
    <nav class="pagination-nav">
        <?php
            // 修复URL生成逻辑：支持基于URL路径的翻页
            $queryParams = request()->except('page');
            $queryString = http_build_query($queryParams);
            $queryString = $queryString ? '?' . $queryString : '';
            
            // 获取基础路径，优先使用pagination中的path，否则使用当前URL
            $basePath = $pagination['path'] ?? url()->current();
            
            // 判断当前是否使用URL路径翻页模式
            $isPathPagination = str_contains($basePath, '/companies/p/') || str_contains($basePath, '/jobs/p/');
            
            // 如果是URL路径翻页模式，移除路径中的页码部分
            if ($isPathPagination) {
                $basePath = preg_replace('/\/p\/\d+$/', '', $basePath);
            }
        ?>
        
        <ul class="pagination">
            
            <?php if(($pagination['current_page'] ?? 1) > 1): ?>
                <li class="page-item">
                    <?php if($isPathPagination): ?>
                        
                        <a class="page-link" href="<?php echo e($basePath); ?>/p/<?php echo e(($pagination['current_page'] ?? 1) - 1); ?><?php echo e($queryString); ?>" aria-label="<?php echo e(__('messages.previous')); ?>">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only"><?php echo e(__('messages.previous')); ?></span>
                        </a>
                    <?php else: ?>
                        
                        <a class="page-link" href="<?php echo e($pagination['prev_page_url'] ?? '#'); ?>" aria-label="<?php echo e(__('messages.previous')); ?>">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only"><?php echo e(__('messages.previous')); ?></span>
                        </a>
                    <?php endif; ?>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&laquo;</span>
                </li>
            <?php endif; ?>

            
            <?php
                $currentPage = $pagination['current_page'] ?? 1;
                $lastPage = $pagination['last_page'] ?? 1;
                
                // 扩展页码显示范围：显示当前页前后6页，总共最多12页
                $startPage = max(1, $currentPage - 6);
                $endPage = min($lastPage, $currentPage + 5);
                
                // 如果总页数少于12页，则显示所有页码
                if ($lastPage <= 12) {
                    $startPage = 1;
                    $endPage = $lastPage;
                }
            ?>
            
            <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?php echo e($i == $currentPage ? 'active' : ''); ?>">
                    <?php if($isPathPagination): ?>
                        
                        <a class="page-link" href="<?php echo e($basePath); ?>/p/<?php echo e($i); ?><?php echo e($queryString); ?>">
                            <?php echo e($i); ?>

                        </a>
                    <?php else: ?>
                        
                        <a class="page-link" href="<?php echo e($basePath); ?><?php echo e($queryString ? $queryString . '&' : '?'); ?>page=<?php echo e($i); ?>">
                            <?php echo e($i); ?>

                        </a>
                    <?php endif; ?>
                </li>
            <?php endfor; ?>

            
            <?php if(($pagination['current_page'] ?? 1) < ($pagination['last_page'] ?? 1)): ?>
                <li class="page-item">
                    <?php if($isPathPagination): ?>
                        
                        <a class="page-link" href="<?php echo e($basePath); ?>/p/<?php echo e(($pagination['current_page'] ?? 1) + 1); ?><?php echo e($queryString); ?>" aria-label="<?php echo e(__('messages.next')); ?>">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only"><?php echo e(__('messages.next')); ?></span>
                        </a>
                    <?php else: ?>
                        
                        <a class="page-link" href="<?php echo e($pagination['next_page_url'] ?? '#'); ?>" aria-label="<?php echo e(__('messages.next')); ?>">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only"><?php echo e(__('messages.next')); ?></span>
                        </a>
                    <?php endif; ?>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link" aria-hidden="true">&raquo;</span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<style>
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 2rem 0;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.pagination-info p {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
}

.pagination-nav {
    display: flex;
    align-items: center;
}

.pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.page-item {
    margin: 0 2px;
}

.page-link {
    display: block;
    padding: 0.5rem 0.75rem;
    border: 1px solid #dee2e6;
    background: white;
    color: #007bff;
    text-decoration: none;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.page-link:hover {
    background: #e9ecef;
    border-color: #adb5bd;
}

.page-item.active .page-link {
    background: #007bff;
    border-color: #007bff;
    color: white;
}

.page-item.disabled .page-link {
    color: #6c757d;
    background: #f8f9fa;
    border-color: #dee2e6;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .pagination-container {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .pagination {
        justify-content: center;
    }
}
</style>
<?php endif; ?><?php /**PATH /www/wwwroot/default_com/resources/views/components/pagination.blade.php ENDPATH**/ ?>