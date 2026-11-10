const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 8000;
const PUBLIC_DIR = path.join(__dirname, 'public');
const VIEWS_DIR = path.join(__dirname, 'resources', 'views', 'website');

const MIME_TYPES = {
    '.html': 'text/html; charset=utf-8',
    '.css': 'text/css; charset=utf-8',
    '.js': 'text/javascript; charset=utf-8',
    '.json': 'application/json',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.webp': 'image/webp',
    '.svg': 'image/svg+xml',
    '.ico': 'image/x-icon',
    '.woff': 'font/woff',
    '.woff2': 'font/woff2',
    '.ttf': 'font/ttf',
    '.otf': 'font/otf'
};

const server = http.createServer((req, res) => {
    // Parse URL and clean query strings / hash
    let reqUrl = req.url.split('?')[0].split('#')[0];
    try {
        reqUrl = decodeURIComponent(reqUrl);
    } catch (e) {
        // fallback
    }

    if (reqUrl === '/') {
        reqUrl = '/index.html';
    }

    let filePath = path.join(PUBLIC_DIR, reqUrl);

    // If file doesn't exist in public, check with .html, or fallback to views/website
    if (!fs.existsSync(filePath)) {
        if (fs.existsSync(filePath + '.html')) {
            filePath = filePath + '.html';
        } else if (fs.existsSync(path.join(VIEWS_DIR, reqUrl))) {
            filePath = path.join(VIEWS_DIR, reqUrl);
        } else if (fs.existsSync(path.join(VIEWS_DIR, reqUrl + '.html'))) {
            filePath = path.join(VIEWS_DIR, reqUrl + '.html');
        }
    }

    // Security check to prevent directory traversal
    if (!filePath.startsWith(PUBLIC_DIR) && !filePath.startsWith(VIEWS_DIR)) {
        res.writeHead(403, { 'Content-Type': 'text/plain; charset=utf-8' });
        res.end('403 Forbidden');
        return;
    }

    fs.stat(filePath, (err, stats) => {
        if (err || !stats.isFile()) {
            // Fallback to 404.html if available
            const notFoundPath = fs.existsSync(path.join(PUBLIC_DIR, '404.html'))
                ? path.join(PUBLIC_DIR, '404.html')
                : path.join(VIEWS_DIR, '404.html');

            if (fs.existsSync(notFoundPath)) {
                res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
                fs.createReadStream(notFoundPath).pipe(res);
            } else {
                res.writeHead(404, { 'Content-Type': 'text/plain; charset=utf-8' });
                res.end('404 Not Found');
            }
            return;
        }

        const ext = path.extname(filePath).toLowerCase();
        const contentType = MIME_TYPES[ext] || 'application/octet-stream';

        res.writeHead(200, {
            'Content-Type': contentType,
            'Cache-Control': 'no-cache, no-store, must-revalidate',
            'Access-Control-Allow-Origin': '*'
        });

        fs.createReadStream(filePath).pipe(res);
    });
});

server.listen(PORT, '127.0.0.1', () => {
    console.log(`Sanad CX Server running at http://127.0.0.1:${PORT}/`);
});
