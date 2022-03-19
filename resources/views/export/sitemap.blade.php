<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($static as $page)
        <url>
            <loc>{{ $page['url'] }}</loc>
            <lastmod>{{ $page['updated_at']->format('Y-m-d') }}</lastmod>
            <changefreq>daily</changefreq>
        </url>
    @endforeach
</urlset>