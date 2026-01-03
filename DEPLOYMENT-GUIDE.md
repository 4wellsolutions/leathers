# Laravel Shared Hosting Deployment Guide

## Quick Fix for Current 404 Issue

If you've already uploaded everything to `public_html`, here's the immediate fix:

### Step 1: Copy .htaccess to Root
Copy the `.htaccess` file from the `public` folder to your `public_html` root directory (where your `index.php` is).

### Step 2: Verify .htaccess Content
Make sure your `.htaccess` in `public_html` contains:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Step 3: Test
Visit any page like `https://new.leathers.pk/products` - it should now work!

---

## Recommended Secure Setup (Better for Production)

### Current Structure (Insecure)
```
public_html/
├── app/              ❌ EXPOSED
├── bootstrap/        ❌ EXPOSED
├── config/           ❌ EXPOSED
├── .env              ❌ EXPOSED (DANGEROUS!)
├── vendor/           ❌ EXPOSED
└── index.php
```

### Recommended Structure (Secure)
```
/home/username/
├── public_html/                    ✅ Web accessible only
│   ├── index.php                   (modified)
│   ├── .htaccess
│   ├── build/                      (Vite assets)
│   ├── images/
│   ├── robots.txt
│   └── favicon.ico
│
└── laravel-app/                    ✅ NOT web accessible (SECURE)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    └── .env                        ✅ PROTECTED
```

## Migration Steps (Current → Secure)

### Step 1: Create Laravel Directory Outside public_html

Using FTP/File Manager:
1. Go to `/home/username/` (one level above `public_html`)
2. Create a new folder called `laravel-app`

### Step 2: Move Laravel Files

Move these folders/files FROM `public_html` TO `laravel-app`:
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `storage/`
- `vendor/`
- `artisan`
- `composer.json`
- `composer.lock`
- `package.json`
- `.env`
- `.env.example`

### Step 3: Keep Only Public Files in public_html

Keep these in `public_html`:
- `index.php` (use the modified version from `index-shared-hosting.php`)
- `.htaccess`
- `build/` folder
- `images/` folder
- `js/` folder (if any)
- `robots.txt`
- `favicon.ico`
- `sitemap.xml`

### Step 4: Update index.php

Replace `public_html/index.php` with the content from `index-shared-hosting.php` and adjust the path:

```php
// Change this line to match your structure
$laravelPath = __DIR__.'/../laravel-app';
```

### Step 5: Set Permissions

Via SSH (if available):
```bash
chmod -R 755 ~/laravel-app
chmod -R 775 ~/laravel-app/storage
chmod -R 775 ~/laravel-app/bootstrap/cache
```

Or via FTP/File Manager:
- Set `storage/` folder to 775
- Set `bootstrap/cache/` to 775

### Step 6: Clear Cache (if SSH available)

```bash
cd ~/laravel-app
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

## Troubleshooting

### Issue: Still getting 404 errors
**Solution**: Make sure `.htaccess` is in `public_html` root and mod_rewrite is enabled on your server.

### Issue: "Class not found" errors
**Solution**: Run `composer install` in the `laravel-app` directory or upload the complete `vendor` folder.

### Issue: "Permission denied" errors
**Solution**: Set correct permissions on `storage` and `bootstrap/cache` folders (775).

### Issue: Assets (CSS/JS) not loading
**Solution**: 
1. Make sure `build/` folder is in `public_html`
2. Run `npm run build` locally and upload the `build` folder
3. Update asset paths in layouts to use `{{ asset('build/assets/...') }}`

### Issue: Images not loading
**Solution**: Make sure `images/` folder is in `public_html` and check paths in your code.

## Asset Building for Production

Before deploying, always build your assets:

```bash
# On your local machine
npm run build

# Upload the generated public/build folder to public_html/build
```

## Environment Configuration

Make sure your `.env` file in `laravel-app` has:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://new.leathers.pk

# Update database credentials
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## Final Checklist

- [ ] `.htaccess` is in `public_html` root
- [ ] `index.php` is modified with correct Laravel path
- [ ] Laravel app files are outside `public_html` (recommended)
- [ ] `.env` file is NOT in `public_html`
- [ ] `storage/` and `bootstrap/cache/` have write permissions
- [ ] `build/` folder with compiled assets is in `public_html`
- [ ] Database credentials are correct in `.env`
- [ ] `APP_ENV=production` and `APP_DEBUG=false` in `.env`
- [ ] All pages work (test homepage, products, admin, etc.)
- [ ] Assets (CSS/JS/Images) load correctly

## Need Help?

If you encounter issues:
1. Check server error logs (usually in cPanel or via FTP)
2. Enable debug mode temporarily: `APP_DEBUG=true` in `.env`
3. Check file permissions
4. Verify `.htaccess` is working (test with a simple redirect rule)
