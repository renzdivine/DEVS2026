# DESIGN.md

Design system for the DEVS public website. Read this before touching any view, stylesheet, or animation.

Sources this system follows: `anti_aislop.md` (project rule file), [Impeccable](https://github.com/pbakaus/impeccable) (design guidance for AI agents), [Unslop](https://github.com/theclaymethod/unslop) (writing rules), [Awesome DESIGN.md](https://github.com/VoltAgent/awesome-design-md) (document format).

---

## 1. Visual Theme & Atmosphere

Warm editorial studio, not a SaaS template. The site should read like a small print studio's portfolio: generous whitespace, hairline rules instead of heavy card borders, a cream paper canvas, terracotta used sparingly as the only accent. Typography carries hierarchy; boxes and icons do not.

## 2. Color Palette & Roles

| Token | Light | Dark | Role |
|---|---|---|---|
| `--bg-primary` | `#F7F3EB` | `#131211` | Page canvas (paper) |
| `--bg-secondary` | `#EFE9DE` | `#1A1918` | Bands, footer |
| `--bg-card` | `#FFFFFF` | `#1D1C1A` | Cards, inputs |
| `--text-primary` | `#151413` | `#F5F1E8` | Headings, body |
| `--text-secondary` | `#4A463F` | `#B8B2A6` | Paragraphs |
| `--text-muted` | `#7A756D` | `#8A8479` | Captions, meta |
| `--terracotta` | `#C86142` | `#D86F50` | The single accent: links, active states, eyebrows |
| `--border` | `#DFD9CE` | `#2A2724` | Hairline rules |

Rules:
- One accent color only. No gradients, no neon, no blue/purple pairs.
- Never gray text on a colored background. Never pure black or pure white; all neutrals are warm-tinted.
- Dark mode is not an inversion: it is a warm charcoal surface set with the same terracotta accent, retuned for contrast.

## 3. Typography Rules

| Level | Font | Weight | Size | Notes |
|---|---|---|---|---|
| Hero display | Bebas Neue | 400 | clamp(4rem, 14vw, 13rem) | Uppercase, tight leading |
| Page headline | Playfair Display | 600-700 | clamp(2.4rem, 5vw, 3.4rem) | Serif, sentence case preferred |
| Section headline | Playfair Display | 700 | clamp(1.7rem, 3vw, 2.2rem) | |
| Card title | Plus Jakarta Sans | 600 | 1.15rem | |
| Body | Plus Jakarta Sans | 400-500 | 16px, line-height 1.65 | Max width ~65ch |
| Meta / eyebrow | Space Grotesk | 600 | 11-12px | Uppercase, 0.12em tracking |

Rules:
- Four fonts maximum, used at these roles only. Do not introduce new display faces.
- Hierarchy comes from size, weight, and whitespace. Never from uppercase everywhere, huge text everywhere, or letter-spacing games.
- Body copy stays between 45 and 75 characters per line.

## 4. Component Stylings

- **Buttons**: rectangular (`--radius-sm: 2px`), flat fill, no shadows, no gradients. Primary = ink fill; secondary = hairline border. One primary button per view region at most.
- **Cards**: used only when a border groups genuinely separate content. Vary sizes and structure; never three identical cards in a row. Prefer numbered lists, split layouts, timelines, and editorial grids.
- **Inputs**: cream-tinted surfaces, 1px hairline border, focus ring in terracotta.
- **Badges**: text-first. A label is enough; do not add colored dots, pills, or live-indicator circles.
- **Status**: expressed in words ("Available for new projects"), never with green/blue/red decorative dots.

## 5. Layout Principles

- Spacing scale: 4 / 8 / 12 / 16 / 24 / 32 / 48 / 64 / 96, expressed with `clamp()` for fluid rhythm.
- Section padding: `clamp(4rem, 9vw, 6.5rem)` vertical. Container max 1240px.
- Asymmetry over symmetry: alternate split layouts, numbered rows, wide/narrow grids.
- Whitespace is a design element. An empty area is better than a decorative filler.

## 6. Depth & Elevation

Shadows are quiet and rare: `--shadow-sm` for hover lift only, `--shadow-md` for the one floating element a page may own. No glow, no neon, no layered glass. The navbar may use a light backdrop blur; nothing else does.

## 7. Do's and Don'ts (Unslop / Impeccable guardrails)

Do not:
- Em dashes. Use commas, periods, colons, or parentheses. Zero tolerance in UI copy.
- Three identical cards in a row. Vary size, structure, or replace with a list.
- Invented numbers: no fake stats, counters, percentages, client counts, years, ratings. If a number is not real, the section does not show a number.
- Invented people, testimonials, clients, logos, addresses, emails, phone numbers, or social links.
- Green/blue/red decorative status dots beside names, headings, or badges.
- Generic SaaS hero: no "HELLO I'M [NAME]" pattern, no floating glass chips, no gradient blobs, no random 3D objects.
- Rounded glassmorphism cards, blurred panels, or glowing borders.
- An icon beside every heading. Icons only when they aid comprehension.
- Generic marketing copy ("crafting digital experiences", "empowering businesses", "where creativity meets technology").
- Endless ambient animation (infinite floats, pulses, rotations on content).
- Bounce or elastic easing.

Do:
- Write specific, concrete copy grounded in what the team actually does.
- Match the number of UI elements to the real content. Two projects means two projects.
- Use terminal/code-styled art and typographic stamps as the site's personality elements.
- Keep navigation limited to pages that exist.

## 8. Responsive Behavior

- Breakpoints: 1024px, 920px, 768px, 480px.
- Mobile: stack split layouts in reading order, keep tap targets >= 44px, no horizontal overflow, hide decorative rails, keep the hero type scaled via clamp() not media-query jumps.

## 9. Motion System

Two engines, strict division of labor. Both must be loaded before `main.js`.

**GSAP + ScrollTrigger** (CDN, loaded in `head.php`): scroll choreography only.
- Page-enter curtain, hero entrance timeline, scroll reveals via `[data-reveal]`, staggered batches, scroll-scrubbed parallax on the hero title.
- Once-only triggers for entrance work. `scrub` only for parallax.
- Every GSAP block checks `reduced` (prefers-reduced-motion) and `hasGSAP` first.

**Motion (Framer Motion for vanilla JS)** (CDN, loaded in `head.php`): interaction and physics only.
- Spring-based micro-interactions: buttons press, cards lift, nav underline, FAQ accordion height, wizard step transitions, form focus rings.
- Springs (`type: "spring"`) are the default; durations are reserved for opacity.
- Same reduced-motion gate. Motion is never ambient: it responds to a user action or an entrance, it does not loop.

**Rules for both:**
- Animate `transform` and `opacity` only, so animations stay on the compositor.
- `prefers-reduced-motion: reduce` disables every animation path and shows final state immediately.
- No layout thrash: never animate width/height/top/left except height-collapsed accordions.

## 10. Agent Prompt Guide

When generating new UI for this project: warm paper background, ink text, terracotta accent, Playfair headings over Plus Jakarta body, Space Grotesk uppercase eyebrows, hairline borders, numbered editorial layouts instead of card grids, code-window art instead of stock imagery, no em dashes, no invented numbers, motion only where a human would expect a response.
