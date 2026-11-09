const { chromium } = require('playwright-core');
const fs = require('fs');
const path = require('path');

const CHROME_PATH = "C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe";
const BASE_URL = "http://127.0.0.1:8000";
const REPORT_DIR = path.join(__dirname, 'playwright-report');
const SHOTS_DIR = path.join(REPORT_DIR, 'screenshots');

if (!fs.existsSync(SHOTS_DIR)) {
    fs.mkdirSync(SHOTS_DIR, { recursive: true });
}

const VIEWPORTS = [
    { name: 'mobile', width: 390, height: 844 },
    { name: 'tablet', width: 768, height: 1024 },
    { name: 'desktop', width: 1440, height: 900 }
];

const PAGES = [
    { name: 'home', path: '/' },
    { name: 'services', path: '/services' },
    { name: 'how-it-works', path: '/how-it-works' },
    { name: 'about', path: '/about' },
    { name: 'ai-assistant', path: '/ai-assistant' },
    { name: 'fikr', path: '/fikr' },
    { name: 'blog', path: '/blog' }
];

async function runPlaywrightSuite() {
    console.log("Starting Playwright Audit on Chrome:", CHROME_PATH);
    const browser = await chromium.launch({
        executablePath: CHROME_PATH,
        headless: true,
        args: ['--disable-gpu', '--no-sandbox']
    });

    const report = {
        timestamp: new Date().toISOString(),
        summary: { totalTests: 0, passed: 0, failed: 0 },
        results: []
    };

    try {
        for (const vp of VIEWPORTS) {
            console.log(`\n========================================`);
            console.log(`AUDITING VIEWPORT: ${vp.name.toUpperCase()} (${vp.width}x${vp.height})`);
            console.log(`========================================`);

            const context = await browser.newContext({
                viewport: { width: vp.width, height: vp.height },
                userAgent: vp.name === 'mobile'
                    ? 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.0 Mobile/15E148 Safari/604.1'
                    : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
            });

            const page = await context.newPage();

            for (const p of PAGES) {
                const url = `${BASE_URL}${p.path}`;
                report.summary.totalTests++;
                const testResult = {
                    viewport: vp.name,
                    page: p.name,
                    url: url,
                    errors: [],
                    warnings: [],
                    overflow: false,
                    overlappingElements: [],
                    motionErrors: [],
                    screenshot: ''
                };

                const consoleErrors = [];
                page.on('console', msg => {
                    if (msg.type() === 'error') consoleErrors.push(msg.text());
                });
                page.on('pageerror', err => {
                    consoleErrors.push(err.message || String(err));
                });

                try {
                    await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 15000 });
                    await page.waitForTimeout(1200); // Allow initial GSAP entrance timelines

                    // 1. Check Horizontal Overflow (RTL & LTR)
                    const overflowInfo = await page.evaluate(() => {
                        const docWidth = document.documentElement.offsetWidth;
                        const scrollWidth = document.documentElement.scrollWidth;
                        const windowWidth = window.innerWidth;
                        const elementsOverflown = [];

                        if (scrollWidth > windowWidth + 1) {
                            const all = document.body.querySelectorAll('*');
                            all.forEach(el => {
                                const rect = el.getBoundingClientRect();
                                if (rect.right > windowWidth + 2 || rect.left < -2) {
                                    if (rect.width > 0 && rect.height > 0) {
                                        elementsOverflown.push({
                                            tag: el.tagName,
                                            class: el.className,
                                            id: el.id,
                                            rect: { left: rect.left, right: rect.right, width: rect.width }
                                        });
                                    }
                                }
                            });
                        }

                        return {
                            hasOverflow: scrollWidth > windowWidth + 1,
                            docWidth,
                            scrollWidth,
                            windowWidth,
                            elementsOverflown: elementsOverflown.slice(0, 5)
                        };
                    });

                    if (overflowInfo.hasOverflow) {
                        testResult.overflow = true;
                        testResult.errors.push(`Horizontal overflow detected! scrollWidth (${overflowInfo.scrollWidth}) > windowWidth (${overflowInfo.windowWidth})`);
                        testResult.overflowElements = overflowInfo.elementsOverflown;
                    }

                    // 2. Check Overlapping / Collision among critical interactive elements
                    const collisions = await page.evaluate(() => {
                        const overlapList = [];
                        const targets = Array.from(document.querySelectorAll('.sanad-btn, .sanad-hero__headline, .sanad-hero__description, .sanad-services-detail__card, .sanad-roi__card, .sanad-how-process__step'));

                        for (let i = 0; i < targets.length; i++) {
                            for (let j = i + 1; j < targets.length; j++) {
                                const a = targets[i];
                                const b = targets[j];
                                // Only compare elements that share the same parent or are siblings
                                if (a.parentElement === b.parentElement) {
                                    const rA = a.getBoundingClientRect();
                                    const rB = b.getBoundingClientRect();

                                    if (rA.width > 0 && rA.height > 0 && rB.width > 0 && rB.height > 0) {
                                        const overlaps = !(rA.right <= rB.left || rA.left >= rB.right || rA.bottom <= rB.top || rA.top >= rB.bottom);
                                        if (overlaps) {
                                            overlapList.push({
                                                elementA: `${a.tagName}.${a.className}`,
                                                elementB: `${b.tagName}.${b.className}`
                                            });
                                        }
                                    }
                                }
                            }
                        }
                        return overlapList;
                    });

                    if (collisions.length > 0) {
                        testResult.overlappingElements = collisions;
                        testResult.warnings.push(`${collisions.length} overlapping elements detected among siblings.`);
                    }

                    // 3. Smooth Scroll test (Trigger all ScrollTriggers)
                    await page.evaluate(async () => {
                        const totalHeight = document.body.scrollHeight;
                        const step = window.innerHeight;
                        for (let y = 0; y < totalHeight; y += step) {
                            window.scrollTo(0, y);
                            await new Promise(r => setTimeout(r, 80));
                        }
                        window.scrollTo(0, 0);
                    });
                    await page.waitForTimeout(500);

                    // 4. Check Motion & GSAP state
                    const motionState = await page.evaluate(() => {
                        return {
                            available: window.SanadMotion?.available,
                            errors: window.SanadMotion?.errors || []
                        };
                    });

                    if (motionState.errors.length > 0) {
                        testResult.motionErrors = motionState.errors;
                        testResult.errors.push(`GSAP Motion errors: ${JSON.stringify(motionState.errors)}`);
                    }

                    // 5. Console errors
                    if (consoleErrors.length > 0) {
                        testResult.errors.push(...consoleErrors);
                    }

                    // 6. Screenshot
                    const shotName = `${vp.name}_${p.name}.png`;
                    const shotPath = path.join(SHOTS_DIR, shotName);
                    await page.screenshot({ path: shotPath, fullPage: false });
                    testResult.screenshot = shotPath;

                    if (testResult.errors.length === 0) {
                        report.summary.passed++;
                        console.log(`[PASS] [${vp.name}] ${p.name} - 0 errors, overflow: ${testResult.overflow}, motion: OK`);
                    } else {
                        report.summary.failed++;
                        console.log(`[FAIL] [${vp.name}] ${p.name} - ${testResult.errors.length} errors!`);
                        console.log(testResult.errors);
                    }

                } catch (pageErr) {
                    report.summary.failed++;
                    testResult.errors.push(pageErr.message);
                    console.error(`[ERROR] [${vp.name}] ${p.name}:`, pageErr.message);
                }

                report.results.push(testResult);
            }

            await context.close();
        }

        const reportPath = path.join(REPORT_DIR, 'summary.json');
        fs.writeFileSync(reportPath, JSON.stringify(report, null, 2));
        console.log(`\nPlaywright Audit Complete! Passed: ${report.summary.passed}/${report.summary.totalTests}. Report saved to ${reportPath}`);

    } finally {
        await browser.close();
    }
}

runPlaywrightSuite().catch(e => {
    console.error("Suite execution failed:", e);
    process.exit(1);
});
