# [**MyJob Portal**](https://myjob.one) - Laravel 求职招聘网站

一个基于 Laravel 框架开发的现代化求职招聘平台，为企业提供人才招聘服务，为求职者提供丰富的职位机会。

## 功能特性

### 核心功能
- **职位搜索** - 支持关键词、地点、薪资范围等多维度搜索
- **职位详情** - 完整的职位信息展示，包括公司介绍、职位要求、福利待遇
- **公司展示** - 企业信息展示和职位发布管理
- **用户系统** - 求职者和企业用户注册登录
- **简历管理** - 在线简历创建和管理
- **申请流程** - 职位申请和状态跟踪

### 技术特性
- **响应式设计** - 支持PC、平板、手机等不同设备
- **SEO优化** - 完整的SEO元数据和JSON-LD结构化数据
- **性能优化** - 缓存机制和图片懒加载
- **安全性** - CSRF保护、XSS防护、SQL注入防护
- **API集成** - 支持外部API数据集成

## 系统要求

- PHP 7.4 或更高版本
- Composer 2.0 或更高版本
- MySQL 5.7 或更高版本 / PostgreSQL / SQLite
- Node.js 14+ 和 NPM (用于前端资源)
- Web服务器 (Apache/Nginx)

## 安装指南

### 1. 克隆项目
```bash
git clone <repository-url>
cd myjob-portal
```

### 2. 安装依赖
```bash
composer install
npm install
```

### 3. 环境配置
```bash
# 复制环境配置文件
cp .env.example .env

# 生成应用密钥
php artisan key:generate
```

### 4. 配置环境变量
编辑 `.env` 文件，配置数据库连接和其他设置：

```env
# 数据库配置
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myjob_portal
DB_USERNAME=root
DB_PASSWORD=your_password

# 应用配置
APP_NAME="MyJob Portal"
APP_URL=http://localhost:8000

# API配置
API_BASE_URL=/******MyJob API******/
API_KEY=your-api-key
```

### 5. 数据库设置
```bash
# 创建数据库
mysql -u root -p -e "CREATE DATABASE myjob_portal;"

# 运行数据库迁移
php artisan migrate

# 可选：填充测试数据
php artisan db:seed
```

### 6. 前端资源构建
```bash
# 开发环境
npm run dev

# 生产环境
npm run build
```

### 7. 存储链接
```bash
php artisan storage:link
```

### 8. 启动开发服务器
```bash
php artisan serve
```
### 9. Nginx Rewrite
```bash
# 高优先级 rewrite 规则
location = /robots.txt {
    rewrite ^ /robots.php last;
}
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

访问 http://localhost:8000 查看网站。

## 项目结构

```
myjob-portal/
├── app/                 # 应用核心代码
│   ├── Console/         # Artisan 命令
│   ├── Exceptions/      # 异常处理
│   ├── Helpers/         # 辅助函数
│   ├── Http/            # HTTP 相关
│   │   ├── Controllers/ # 控制器
│   │   ├── Middleware/  # 中间件
│   │   └── Requests/    # 表单请求
│   ├── Models/          # 数据模型
│   └── Providers/       # 服务提供者
├── bootstrap/           # 启动文件
├── config/              # 配置文件
├── database/            # 数据库相关
│   ├── factories/       # 模型工厂
│   ├── migrations/      # 数据库迁移
│   └── seeders/         # 数据填充
├── public/              # 公开目录
│   ├── assets/          # 静态资源
│   │   ├── css/         # 样式文件
│   │   ├── js/          # 脚本文件
│   │   └── images/      # 图片资源
│   └── index.php        # 入口文件
├── resources/           # 资源文件
│   ├── js/              # JavaScript 文件
│   ├── lang/            # 语言文件
│   └── views/           # 视图文件
│       ├── home/        # 首页视图
│       ├── jobs/        # 职位相关视图
│       └── pages/       # 静态页面视图
├── routes/              # 路由定义
├── storage/             # 存储目录
├── tests/               # 测试文件
└── vendor/              # Composer 依赖
```

## 配置说明

### 网站配置
配置文件位于 `config/site.php`，包含以下配置项：

- **基本信息** - 网站名称、描述、关键词等
- **联系信息** - 邮箱、电话、地址等
- **社交媒体** - 微博、微信、LinkedIn等链接
- **SEO配置** - 默认标题、描述、OG图片等
- **业务配置** - 职位相关设置、文件上传限制等

### 环境变量
主要环境变量说明：

```env
# 网站配置
SITE_NAME="MyJob Portal"
SITE_DESCRIPTION="专业的求职招聘平台"
SITE_URL=http://localhost:8000

# API配置
API_BASE_URL=/******MyJob API******/
API_KEY=your-secret-api-key
API_CACHE_TTL=86400

# 邮件配置
MAIL_FROM_ADDRESS=noreply@myjobportal.com
MAIL_FROM_NAME="MyJob Portal"
```

## 开发指南

### 添加新页面
1. 在 `routes/web.php` 中添加路由
2. 在 `app/Http/Controllers/` 中创建控制器
3. 在 `resources/views/` 中创建视图文件
4. 在 `config/site.php` 中添加相关配置

### SEO 优化
使用 `App\Helpers\SeoHelper` 类生成SEO数据：

```php
use App\Helpers\SeoHelper;

// 生成元数据
$seo = SeoHelper::generateMetaData([
    'title' => SeoHelper::generateTitle('页面标题'),
    'description' => '页面描述',
    'canonical' => route('page.route')
]);

// 生成结构化数据
$structuredData = [
    'website' => SeoHelper::generateWebsiteSchema(),
    'organization' => SeoHelper::generateOrganizationSchema()
];
```

### API 集成
使用 `App\Services\ApiService` 类进行API调用：

```php
use App\Services\ApiService;

$apiService = app(ApiService::class);
$jobs = $apiService->getJobs($filters);
```

## 部署指南

### 生产环境部署

1. **服务器准备**
   - 配置Web服务器（Nginx/Apache）
   - 安装PHP和必要扩展
   - 配置MySQL数据库

2. **代码部署**
   ```bash
   # 拉取最新代码
   git pull origin main
   
   # 安装依赖
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   
   # 更新环境配置
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **权限设置**
   ```bash
   chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```

### Docker 部署（可选）

项目支持Docker部署，相关配置文件：
- `docker-compose.yml` - Docker Compose配置
- `Dockerfile` - 应用容器配置

## 故障排除

### 常见问题

1. **权限错误**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

2. **环境配置错误**
   - 检查 `.env` 文件配置
   - 确保数据库连接正常
   - 验证API密钥配置

3. **前端资源问题**
   ```bash
   npm install && npm run build
   php artisan cache:clear
   ```

### 日志查看
```bash
# 查看应用日志
tail -f storage/logs/laravel.log

# 查看Nginx日志
tail -f /var/log/nginx/error.log
```

## 贡献指南

1. Fork 项目
2. 创建功能分支 (`git checkout -b feature/AmazingFeature`)
3. 提交更改 (`git commit -m 'Add some AmazingFeature'`)
4. 推送到分支 (`git push origin feature/AmazingFeature`)
5. 创建 Pull Request

## 许可证

本项目采用 MIT 许可证 - 查看 [LICENSE](LICENSE) 文件了解详情。

## 联系方式

- 项目主页: [MyJob Portal](https://myjob.one)
- 问题反馈: [GitHub Issues](https://github.com/myjob/issues)
- 邮箱联系: contact@myjob.one

## 更新日志

### v1.0.0 (2025-11-01)
- 初始版本发布
- 基础求职招聘功能
- SEO优化和结构化数据
- 响应式设计支持

---

[**MyJob.One**](https://myjob.one) - 让求职招聘更简单！
