# Theme Design Proposal (v1)

Mục tiêu: mở rộng thêm nhiều theme trong `themes/` cho trang Memory, với chất lượng thị giác cao hơn, rõ mood và dễ chọn trong admin.

## 1) Hướng tổng thể

- Thiết kế theo **design system theo token** để nhiều theme vẫn đồng nhất UX.
- Mỗi theme phải có:
  - Hero + metadata block
  - Gallery
  - Story sections (story/timeline/quote/video)
  - CTA/share/footer
- Ưu tiên:
  - Mobile-first
  - Tốc độ tải ảnh
  - Khả năng đọc nội dung dài

---

## 2) Bộ theme đề xuất (giai đoạn 1)

## A. Aurora — Dreamy Gradient Glass

**Mood:** mơ màng, lãng mạn hiện đại, “premium”.

- **Palette**
  - `--bg-1: #0f1020`
  - `--bg-2: #241d3a`
  - `--accent-1: #f472b6`
  - `--accent-2: #60a5fa`
  - `--text-main: #f8fafc`
- **Typography**
  - Heading: Playfair Display / Cormorant
  - Body: Inter
  - Note: Caveat
- **Layout**
  - Hero full-bleed + animated gradient blur blobs
  - Glass cards cho quote/metadata
  - Timeline dạng glowing line
- **Motion**
  - Fade-up + parallax nhẹ 4-8%
  - Hover ảnh: scale 1.03 + soft glow

---

## B. Editorial — Magazine Storytelling

**Mood:** tinh tế, thời trang, ảnh lớn + chữ đẹp.

- **Palette**
  - `--bg: #f8f7f4`
  - `--surface: #ffffff`
  - `--ink: #1f2937`
  - `--accent: #b45309`
- **Typography**
  - Heading: Libre Baskerville
  - Body: Source Sans 3
- **Layout**
  - Grid 12 cột kiểu tạp chí
  - Pull quote lớn chen giữa section
  - Ảnh toàn chiều ngang xen ảnh dọc
- **Motion**
  - Transition tối giản, không quá “noisy”

---

## C. Nostalgia Film — Analog Cinema (nâng cấp Film)

**Mood:** cinematic, cảm xúc sâu, hoài niệm.

- **Palette**
  - `--bg: #0b0b0b`
  - `--surface: #151515`
  - `--text: #e5e7eb`
  - `--accent: #f59e0b`
- **Visual effects**
  - Film grain nhẹ (CSS overlay)
  - Vignette ở hero
  - Frame ảnh theo tỉ lệ 21:9 và 4:3 trộn
- **Layout**
  - Chapters thay cho section label
  - Timeline dạng “scene list”

---

## D. Garden — Botanical Soft

**Mood:** nhẹ nhàng, thiên nhiên, “healing”.

- **Palette**
  - `--bg: #f4f8f2`
  - `--surface: #ffffff`
  - `--leaf: #4d7c0f`
  - `--petal: #db2777`
  - `--soil: #7c5e4a`
- **Layout**
  - Border minh họa lá/hoa ở góc
  - Card bo tròn lớn, shadow rất nhẹ
  - Quote card như “pressed flower note”

---

## E. Mono Minimal — Brutalist Clean

**Mood:** tối giản mạnh, tập trung nội dung.

- **Palette**
  - `--bg: #ffffff`
  - `--text: #111827`
  - `--muted: #6b7280`
  - `--accent: #111827`
- **Layout**
  - Nhiều khoảng trắng
  - Divider dày, typography làm điểm nhấn
  - Gallery masonry đen-trắng + màu khi hover

---

## 3) Mapping với data hiện tại

- `opening_quote` → Hero quote block
- `galleryImages` → Gallery module + lightbox
- `sections[type=story|timeline|quote|video]` → renderer chung theo theme skin
- `getAccentColor()` → fallback accent token nếu theme không custom accent

Đề xuất tách:
- `themes/tokens/*.json` (màu, radius, shadow, spacing)
- `themes/layouts/*.blade.php` (khung)
- `themes/modules/*.blade.php` (hero/gallery/section)

---

## 4) Chuẩn chất lượng UI/UX

- Contrast text đạt WCAG AA.
- Hero luôn có lớp overlay đảm bảo đọc tốt trên ảnh sáng.
- Cỡ chữ body tối thiểu 16px trên mobile.
- Khoảng cách touch target >= 40px.
- Lazy-load ảnh gallery + kích thước ảnh responsive.

---

## 5) Checklist bàn giao design trước khi code

- [ ] Moodboard cho từng theme
- [ ] 1 trang desktop + 1 trang mobile cho mỗi theme
- [ ] Token sheet (color/type/spacing/radius/shadow)
- [ ] State: hover/focus/active cho button/card/link
- [ ] Quy tắc animation duration/easing

---

## 6) Ưu tiên triển khai đề xuất

1. **Aurora** (tạo “wow effect”, hợp người dùng trẻ)
2. **Editorial** (đọc tốt nội dung dài)
3. **Nostalgia Film** (nâng cấp theme film hiện có)
4. **Garden**
5. **Mono Minimal**

---

## 7) Demo prompt dùng cho AI design (nếu cần)

> Design a romantic memory webpage theme named "Aurora" with dreamy gradient background, glassmorphism cards, elegant serif headings, clean sans-serif body text, immersive full-bleed hero image, and modular sections for timeline, quote, gallery, and video. Keep accessibility AA contrast and mobile-first layout.

