<?php
/**
 * Vector SVG Icons for Technologies & Tools
 */
function render_tech_icon($name, $size = 48) {
    $normalized = strtolower(trim((string)$name));
    $clean = preg_replace('/[^a-z0-9]/', '', $normalized);

    // 1. JavaScript
    if ($clean === 'javascript' || $clean === 'js') {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="JavaScript">
            <rect width="48" height="48" rx="8" fill="#F7DF1E"/>
            <path d="M14 36c1.2.8 2.6 1.3 4.2 1.3 3.4 0 5.4-1.8 5.4-5.3v-14h-4.4v13.8c0 1.6-.7 2.4-2 2.4-.8 0-1.7-.3-2.3-.7L14 36zm14.7-2.1c1.4.9 3.2 1.5 5.1 1.5 3 0 4.8-1.5 4.8-3.7 0-2-1.3-3.1-4.2-4.2-3.4-1.3-5.6-2.9-5.6-6.1 0-3.4 2.7-5.8 6.9-5.8 2 0 3.7.5 4.8 1.1l-1.2 3.6c-.9-.5-2.2-1-3.6-1-1.9 0-3 1.1-3 2.4 0 1.8 1.3 2.6 4.3 3.8 3.7 1.4 5.6 3.2 5.6 6.5 0 3.7-2.9 6.2-7.5 6.2-2.3 0-4.5-.6-5.8-1.4l1.3-3.9z" fill="#000000"/>
        </svg>';
    }

    // 2. React
    if (strpos($clean, 'react') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="React">
            <ellipse cx="24" cy="24" rx="7" ry="19" stroke="#61DAFB" stroke-width="2.2" transform="rotate(30 24 24)"/>
            <ellipse cx="24" cy="24" rx="7" ry="19" stroke="#61DAFB" stroke-width="2.2" transform="rotate(90 24 24)"/>
            <ellipse cx="24" cy="24" rx="7" ry="19" stroke="#61DAFB" stroke-width="2.2" transform="rotate(150 24 24)"/>
            <circle cx="24" cy="24" r="3.2" fill="#61DAFB"/>
        </svg>';
    }

    // 3. Node.js
    if (strpos($clean, 'node') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Node.js">
            <path d="M24 6l16 9.2v17.6L24 42 8 32.8V15.2L24 6z" stroke="#5FA04E" stroke-width="3" stroke-linejoin="round" fill="none"/>
            <path d="M20 18v12M28 18v12M20 24h8" stroke="#5FA04E" stroke-width="2.5" stroke-linecap="round"/>
        </svg>';
    }

    // 4. Express.js
    if (strpos($clean, 'express') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Express.js">
            <rect width="48" height="48" rx="8" fill="#1C1C1C"/>
            <text x="24" y="31" font-family="system-ui, sans-serif" font-weight="700" font-size="20" fill="#FFFFFF" text-anchor="middle" letter-spacing="-1">ex</text>
        </svg>';
    }

    // 5. Nest.js
    if (strpos($clean, 'nest') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Nest.js">
            <path d="M38 18c-1.5-4-5-8-10-10 1 3 0 6-2 8-2 2-5 3-7 6-3 4-4 9-2 13 2 4 6 7 11 7 5 0 9-3 11-7 2-4 1-7-1-7zm-14 12c-2 0-3-1-3-3s2-4 4-4c2 0 4 1 4 3s-3 4-5 4z" fill="#E0234E"/>
        </svg>';
    }

    // 6. Socket.io
    if (strpos($clean, 'socket') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Socket.io">
            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2.5" fill="none"/>
            <path d="M26 12L16 26h8l-2 10 12-14h-8l2-10z" fill="currentColor"/>
        </svg>';
    }

    // 7. PostgreSQL / Postgres
    if (strpos($clean, 'postgres') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="PostgreSQL">
            <path d="M24 7C14.6 7 7 14.6 7 24c0 4.8 2 9.1 5.2 12.2l1.6-3.8c-2.4-2.3-3.8-5.6-3.8-9.2 0-7.2 5.8-13 13-13s13 5.8 13 13c0 3.6-1.4 6.9-3.8 9.2l1.6 3.8C37 33.1 39 28.8 39 24c0-9.4-7.6-17-15-17z" fill="#336791"/>
            <path d="M24 16c-4.4 0-8 3.6-8 8 0 2.4 1 4.5 2.7 6l2.1-4.2c-.5-.5-.8-1.1-.8-1.8 0-1.7 1.3-3 3-3s3 1.3 3 3c0 .7-.3 1.3-.8 1.8l2.1 4.2C29 28.5 30 26.4 30 24c0-4.4-3.6-8-6-8z" fill="#336791"/>
            <circle cx="20" cy="22" r="1.5" fill="#336791"/>
            <circle cx="28" cy="22" r="1.5" fill="#336791"/>
        </svg>';
    }

    // 8. MongoDB
    if (strpos($clean, 'mongo') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="MongoDB">
            <path d="M24 6c0 0-11 11-11 20 0 7 4.5 13 10.5 15.5l.5.5.5-.5C30.5 39 35 33 35 26c0-9-11-20-11-20z" fill="#47A248"/>
            <path d="M24 6v36c.2 0 .4-.1.5-.5C30.5 39 35 33 35 26c0-9-11-20-11-20z" fill="#499D4A"/>
            <path d="M24 8v33c-6-2.5-9.5-8.5-9.5-15 0-8.5 9.5-18 9.5-18z" fill="#58AA50"/>
            <path d="M23.5 41c-.2-.5-1.5-6.5-1.5-10.5 0-3 1.5-6.5 1.5-6.5s1.5 3.5 1.5 6.5c0 4-1.3 10-1.5 10.5z" fill="#FFFFFF"/>
        </svg>';
    }

    // 9. Sass / SCSS
    if ($clean === 'sass' || $clean === 'scss') {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Sass">
            <path d="M24 8C13 8 8 13.5 8 19c0 6.5 6 9 10 10.5 4 1.5 6 2.5 6 4.5 0 2-2 3.5-5 3.5-3.5 0-6.5-1.8-8-3.5l-2.5 3.5C11 39.5 14.5 42 19 42c8 0 13-4.5 13-10.5 0-6-5.5-8.5-10-10.5-4-1.5-6-2.5-6-4.5 0-2 2-3.5 5-3.5 3 0 5.5 1.5 7 3l2.5-3.5C28.5 10 26.5 8 24 8zm14 16c-3 0-5 2-5 5s2 5 5 5 5-2 5-5-2-5-5-5z" fill="#CF649A"/>
        </svg>';
    }

    // 10. Tailwind CSS
    if (strpos($clean, 'tailwind') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Tailwind CSS">
            <path d="M14.5 24c1.8-5.5 5.5-8.2 11-8.2 8.3 0 9.7 6.4 14.5 8.2-1.8 5.5-5.5 8.2-11 8.2-8.3 0-9.7-6.4-14.5-8.2zM8 33.2c1.8-5.5 5.5-8.2 11-8.2 8.3 0 9.7 6.4 14.5 8.2-1.8 5.5-5.5 8.2-11 8.2-8.3 0-9.7-6.4-14.5-8.2z" fill="#06B6D4"/>
        </svg>';
    }

    // 11. Figma
    if (strpos($clean, 'figma') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Figma">
            <path d="M17 9h7v7h-7a3.5 3.5 0 0 1 0-7z" fill="#F24E1E"/>
            <path d="M24 9h7a3.5 3.5 0 1 1 0 7h-7V9z" fill="#FF7262"/>
            <path d="M17 16h7v7h-7a3.5 3.5 0 1 1 0-7z" fill="#A259FF"/>
            <path d="M24 16h7a3.5 3.5 0 1 1 0 7h-7v-7z" fill="#1ABCFE"/>
            <path d="M17 23h7v3.5A3.5 3.5 0 0 1 17 30a3.5 3.5 0 0 1 0-7z" fill="#0ACF83"/>
        </svg>';
    }

    // 12. Cypress
    if (strpos($clean, 'cypress') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Cypress">
            <circle cx="24" cy="24" r="20" stroke="#00BF88" stroke-width="2.5" fill="none"/>
            <text x="24" y="30" font-family="system-ui, sans-serif" font-weight="700" font-size="16" fill="#00BF88" text-anchor="middle">cy</text>
        </svg>';
    }

    // 13. Storybook
    if (strpos($clean, 'storybook') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Storybook">
            <rect width="44" height="44" x="2" y="2" rx="6" fill="#FF4785"/>
            <path d="M27.5 11l-3 4.5 3 4.5h-5.5V11h5.5z" fill="#FFFFFF" opacity="0.6"/>
            <text x="24" y="34" font-family="system-ui, sans-serif" font-weight="900" font-size="24" fill="#FFFFFF" text-anchor="middle">S</text>
        </svg>';
    }

    // 14. Git
    if (strpos($clean, 'git') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Git">
            <rect width="28" height="28" rx="5" transform="rotate(45 24 24)" fill="#F05032"/>
            <circle cx="24" cy="18" r="3" fill="#FFFFFF"/>
            <circle cx="18" cy="27" r="3" fill="#FFFFFF"/>
            <circle cx="27" cy="27" r="3" fill="#FFFFFF"/>
            <path d="M24 21v6M21 27h3" stroke="#FFFFFF" stroke-width="2.5"/>
        </svg>';
    }

    // 15. Next.js
    if (strpos($clean, 'next') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Next.js">
            <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2" fill="none"/>
            <path d="M19 16v16M29 16l-10 16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
            <path d="M29 16v9" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
        </svg>';
    }

    // 16. TypeScript
    if (strpos($clean, 'typescript') !== false || $clean === 'ts') {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="TypeScript">
            <rect width="48" height="48" rx="8" fill="#3178C6"/>
            <path d="M12 20h12v3.6h-4.2V36h-3.6V23.6H12V20zm14 11.2c1.4.9 3.2 1.5 5 1.5 2.8 0 4.4-1.4 4.4-3.4 0-2-1.2-3-4-4.1-3.2-1.2-5.3-2.7-5.3-5.7 0-3.3 2.6-5.5 6.6-5.5 2 0 3.6.5 4.6 1l-1.1 3.4c-.8-.5-2-1-3.4-1-1.8 0-2.8 1-2.8 2.2 0 1.6 1.2 2.4 4 3.5 3.5 1.4 5.3 3 5.3 6.1 0 3.5-2.8 5.8-7.2 5.8-2.2 0-4.3-.6-5.5-1.4l1.5-3.4z" fill="#FFFFFF"/>
        </svg>';
    }

    // 17. PHP
    if (strpos($clean, 'php') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="PHP">
            <ellipse cx="24" cy="24" rx="22" ry="14" fill="#777BB4"/>
            <text x="24" y="29" font-family="system-ui, sans-serif" font-weight="900" font-size="16" fill="#FFFFFF" text-anchor="middle" letter-spacing="1">php</text>
        </svg>';
    }

    // 18. MySQL
    if (strpos($clean, 'mysql') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="MySQL">
            <path d="M10 32c5-1 9-5 11-10 2-5 1-9-1-12 5 2 8 6 9 11 1 5-1 10-6 13 4 0 9-2 13-6-2 5-6 8-12 9-5 1-10-1-14-5z" fill="#00758F"/>
            <path d="M26 18c2-3 5-4 8-3-1 2-3 4-5 5-1 0-2-.5-3-2z" fill="#F29111"/>
        </svg>';
    }

    // 19. HTML
    if (strpos($clean, 'html') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="HTML5">
            <path d="M10 7l3.2 32.5L24 43l10.8-3.5L38 7H10z" fill="#E34F26"/>
            <path d="M24 10v29.5l8.5-2.7L35 10H24z" fill="#EF652A"/>
            <path d="M24 18h7l-.6 6h-6.4v4.5h5.8l-.5 5.5-5.3 1.5v4.5l9-2.5 1-11 1-8.5H24v4.5z" fill="#FFFFFF"/>
            <path d="M24 18H17l.5 6h6.5v-6zm0 10.5H18l.3 4 5.7 1.5V28.5z" fill="#EBEBEB"/>
        </svg>';
    }

    // 20. CSS
    if ($clean === 'css' || strpos($clean, 'css3') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="CSS3">
            <path d="M10 7l3.2 32.5L24 43l10.8-3.5L38 7H10z" fill="#1572B6"/>
            <path d="M24 10v29.5l8.5-2.7L35 10H24z" fill="#33A9DC"/>
            <path d="M24 18h7l-.6 6h-6.4v4.5h5.8l-.5 5.5-5.3 1.5v4.5l9-2.5 1-11 1-8.5H24v4.5z" fill="#FFFFFF"/>
            <path d="M24 18H17l.5 6h6.5v-6zm0 10.5H18l.3 4 5.7 1.5V28.5z" fill="#EBEBEB"/>
        </svg>';
    }

    // 21. Supabase
    if (strpos($clean, 'supabase') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Supabase">
            <path d="M27 6L9 28h13l-4 14 18-22H23l4-14z" fill="#3ECF8E"/>
        </svg>';
    }

    // 22. Photoshop
    if (strpos($clean, 'photoshop') !== false || $clean === 'ps') {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Photoshop">
            <rect width="48" height="48" rx="8" fill="#001E36"/>
            <path d="M15 15h7c3 0 5 1.8 5 4.5s-2 4.5-5 4.5h-3.5V33H15V15zm3.5 3v6h3.2c1.2 0 2-.7 2-1.8 0-1.2-.8-1.8-2-1.8h-3.2zm11 11.5c.8.6 1.8 1 2.8 1 1.5 0 2.2-.7 2.2-1.7 0-1.1-.8-1.7-2.3-2.3-2-.8-3.3-1.8-3.3-3.7 0-2 1.7-3.5 4.2-3.5 1.3 0 2.4.4 3.1.8l-.8 2.2c-.6-.4-1.4-.7-2.3-.7-1.1 0-1.8.6-1.8 1.4 0 .9.8 1.4 2.4 2 2.2.9 3.3 2 3.3 3.9 0 2.2-1.8 3.7-4.5 3.7-1.5 0-2.8-.5-3.6-1.1l.6-2.2z" fill="#31A8FF"/>
        </svg>';
    }

    // 23. Python
    if (strpos($clean, 'python') !== false) {
        return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Python">
            <path d="M23.5 7c-6.6 0-6.2 2.8-6.2 2.8l.1 2.9h6.3v.9H14.8S10 13 10 20.3c0 7.3 4.2 7 4.2 7h2.5v-3.5s-.1-4.2 4.1-4.2h7.1s3.9.1 3.9-3.8V11s.6-4-6.3-4zm-3.5 2.2a1.3 1.3 0 1 1 0 2.6 1.3 1.3 0 0 1 0-2.6z" fill="#3776AB"/>
            <path d="M24.5 41c6.6 0 6.2-2.8 6.2-2.8l-.1-2.9h-6.3v-.9h8.9s4.8.6 4.8-6.7c0-7.3-4.2-7-4.2-7h-2.5v3.5s.1 4.2-4.1 4.2h-7.1s-3.9-.1-3.9 3.8V37s-.6 4 6.3 4zm3.5-2.2a1.3 1.3 0 1 1 0-2.6 1.3 1.3 0 0 1 0 2.6z" fill="#FFD43B"/>
        </svg>';
    }

    // Default Fallback: Modern Monogram Badge
    $initials = strtoupper(substr($name, 0, min(3, strlen($name))));
    return '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="' . e($name) . '">
        <rect width="46" height="46" x="1" y="1" rx="8" fill="var(--bg-secondary)" stroke="var(--border)" stroke-width="2"/>
        <text x="24" y="29" font-family="var(--font-mono, monospace)" font-weight="700" font-size="14" fill="var(--accent)" text-anchor="middle" letter-spacing="1">' . e($initials) . '</text>
    </svg>';
}
