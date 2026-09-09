# Jara Design System

## 1. Design Direction

Jara menggunakan arah visual **calm productivity**: fokus, rapi, modern, dan tidak melelahkan ketika dipakai untuk mengelola banyak task.

Inspirasi utama berasal dari Linear dan Notion, tetapi Jara tetap memiliki karakter sendiri melalui kombinasi warna indigo, teal, dan warm neutral.

### Prinsip Visual

- Utamakan kejelasan task dibanding dekorasi.
- Gunakan whitespace untuk memisahkan konteks kerja.
- Tampilkan informasi penting dalam satu pandangan.
- Gunakan warna sebagai penanda status, bukan sebagai satu-satunya pembeda.
- Jaga interaksi tetap cepat melalui quick add dan inline update.
- Pertahankan tampilan konsisten antara halaman user dan admin.

## 2. Brand

### Nama

Nama aplikasi ditampilkan sebagai **Jara**.

Subjudul produk:

```text
An advanced to-do list for focused teamwork.
```

### Logo

Gunakan wordmark `Jara` dengan ikon sederhana berbentuk check atau tanda fokus. Logo harus tetap terbaca pada sidebar yang diperluas maupun collapsed.

Logo tidak menggunakan efek 3D, gradient berat, atau ilustrasi kompleks.

## 3. Color System

Warna diimplementasikan melalui token CSS dan semantic color, bukan warna hard-coded yang tersebar di komponen.

### Core Colors

| Token | Use | Light | Dark |
| --- | --- | --- | --- |
| `background` | Canvas utama | Warm white | Deep graphite |
| `foreground` | Teks utama | Graphite | Soft white |
| `primary` | Aksi utama dan link aktif | Indigo | Light indigo |
| `secondary` | Kontrol sekunder | Cool gray | Charcoal |
| `accent` | Highlight ringan | Pale indigo | Muted indigo |
| `muted` | Background elemen pasif | Soft gray | Dark gray |
| `border` | Pemisah dan outline | Neutral gray | Dark neutral |
| `ring` | Focus state | Indigo | Light indigo |
| `destructive` | Hapus dan aksi berbahaya | Rose | Soft rose |

### Semantic Colors

| Context | Color direction | Usage |
| --- | --- | --- |
| Todo | Slate | Task belum dimulai |
| In progress | Indigo | Task sedang dikerjakan |
| Done | Teal atau emerald | Task selesai |
| Low priority | Slate | Prioritas rendah |
| Medium priority | Blue | Prioritas normal |
| High priority | Amber | Prioritas tinggi |
| Urgent priority | Rose | Task mendesak |
| Overdue | Rose | Tenggat telah lewat |
| Success | Teal | Operasi berhasil |
| Warning | Amber | Perlu perhatian |

Status dan prioritas harus selalu memiliki label atau ikon pendamping agar tidak hanya dibedakan berdasarkan warna.

## 4. Typography

Font utama tetap menggunakan `Instrument Sans` yang sudah tersedia di aplikasi.

| Role | Weight | Usage |
| --- | --- | --- |
| Display | 600 | Judul dashboard atau hero |
| Heading | 600 | Judul halaman dan section |
| Body | 400 | Deskripsi dan isi task |
| Label | 500 | Form label, badge, metadata |
| Caption | 400 | Timestamp, helper text, secondary info |

Aturan typography:

- Gunakan sentence case untuk judul.
- Hindari penggunaan uppercase berlebihan.
- Judul halaman harus singkat dan langsung menjelaskan konteks.
- Metadata menggunakan ukuran lebih kecil dan warna muted.
- Gunakan line-height lega untuk deskripsi task.

## 5. Layout

### Desktop

- Gunakan sidebar tetap di sisi kiri.
- Sidebar dapat di-collapse menjadi ikon.
- Area utama memiliki lebar maksimum agar konten tidak terlalu melebar.
- Header halaman menampilkan breadcrumb, judul, dan aksi utama.
- Konten utama menggunakan grid dan gap yang konsisten.

### Mobile

- Sidebar berubah menjadi drawer.
- Header tetap ringkas dan memiliki akses cepat ke navigasi.
- Card dan task list menggunakan lebar penuh.
- Aksi utama tetap mudah dijangkau dengan satu tangan.
- Filter dan sort dapat dibuka melalui bottom sheet atau dropdown.
- Jangan menampilkan tabel lebar tanpa mode responsive.

### Spacing

Gunakan spacing token Tailwind yang konsisten:

- `gap-2` untuk hubungan elemen yang sangat dekat.
- `gap-4` untuk kelompok kontrol dan metadata.
- `gap-6` untuk section kecil.
- `gap-8` atau lebih untuk pemisah section utama.
- Hindari margin acak jika `gap` dapat digunakan pada parent.

### Shape and Elevation

- Gunakan radius sedang untuk card, input, dan dialog.
- Gunakan border tipis sebagai pemisah utama.
- Shadow hanya digunakan untuk dialog, dropdown, dan elemen yang mengambang.
- Hindari shadow besar pada card biasa.
- Hindari card bertingkat terlalu dalam.

## 6. Application Shell

Struktur utama aplikasi:

```text
Sidebar
  Logo
  Main navigation
  Project shortcuts
  Settings
  User menu

Main content
  Page header
  Context actions
  Content sections
```

Navigasi utama:

- Overview
- My tasks
- Projects
- Calendar atau deadlines jika sudah tersedia
- Admin jika user memiliki role admin

Navigasi admin tidak ditampilkan kepada user biasa.

## 7. Dashboard

Dashboard adalah command center, bukan halaman laporan yang padat.

Urutan konten:

1. Greeting dan konteks tanggal.
2. Ringkasan task: total, in progress, done, dan overdue.
3. Task yang perlu difokuskan hari ini.
4. Project aktif beserta progress.
5. Deadline terdekat.
6. Activity terbaru.

Card ringkasan harus singkat dan dapat diklik menuju daftar yang sudah terfilter.

Empty state harus memberikan aksi yang jelas, misalnya `Create your first project` atau `Add a task`.

## 8. Project Experience

Halaman project memiliki:

- Nama dan deskripsi project.
- Progress otomatis.
- Owner dan avatar member.
- Deadline atau informasi waktu jika tersedia.
- Tombol tambah task.
- Tombol kelola member untuk owner.
- Toggle tampilan List dan Kanban.
- Filter status, priority, assignee, dan due date.

### List View

List view digunakan sebagai tampilan default karena paling efisien untuk pekerjaan sehari-hari.

Setiap task menampilkan:

- Checkbox atau status control.
- Judul task.
- Priority badge.
- Assignee avatar.
- Due date.
- Indikator komentar.
- Menu aksi kontekstual.

### Kanban View

Kanban memiliki tiga kolom utama:

- Todo
- In progress
- Done

Drag-and-drop harus memiliki feedback visual yang jelas dan tetap menyediakan alternatif melalui menu status untuk keyboard dan mobile.

## 9. Task Design

### Quick Add

Quick add digunakan untuk membuat task dengan cepat. Minimal field:

- Judul task.
- Project.

Detail seperti description, priority, due date, dan assignee dapat ditambahkan setelah task dibuat.

### Task Detail

Task detail menggunakan dialog atau halaman detail tergantung kompleksitas isi. Bagian utama:

- Judul dan status.
- Deskripsi.
- Priority.
- Due date.
- Assignees.
- Comments.
- Activity history.

Task yang selesai tetap dapat dibuka dan dikembalikan ke status sebelumnya.

### Inline Actions

- Status dapat diubah langsung dari list.
- Priority dapat diubah melalui dropdown.
- Due date dapat diubah tanpa membuka halaman baru.
- Aksi destructive harus berada di menu kontekstual dan membutuhkan konfirmasi.

## 10. Forms and Feedback

- Gunakan label yang selalu terlihat.
- Placeholder hanya sebagai contoh, bukan pengganti label.
- Tampilkan validation error di dekat field terkait.
- Tombol submit memiliki loading state.
- Setelah berhasil, tampilkan toast singkat.
- Setelah gagal, pertahankan input user dan tampilkan pesan yang jelas.
- Dialog destructive menjelaskan konsekuensi sebelum konfirmasi.

## 11. Admin Design

Halaman admin menggunakan layout tabel yang padat tetapi tetap mudah dipindai.

Kolom minimum:

- Nama user.
- Email.
- Role.
- Status verifikasi.
- Tanggal dibuat.
- Aksi.

Admin dapat membuat user melalui dialog atau halaman form. Penghapusan user harus meminta konfirmasi dan menampilkan konsekuensi bila user masih memiliki project.

## 12. Loading, Empty, and Error States

### Loading

- Gunakan skeleton dengan bentuk yang menyerupai konten sebenarnya.
- Hindari spinner penuh halaman untuk request biasa.
- Tombol yang sedang diproses harus disabled dan memiliki indikator loading.

### Empty

- Jelaskan kondisi saat ini.
- Tampilkan satu primary action.
- Gunakan ilustrasi atau ikon sederhana jika membantu, bukan dekorasi berlebihan.

### Error

- Gunakan pesan yang dapat ditindaklanjuti.
- Jangan menampilkan stack trace kepada user.
- Untuk akses ditolak, jelaskan bahwa user tidak memiliki izin.
- Untuk error jaringan, sediakan aksi retry.

## 13. Dark Mode

- Default mengikuti preferensi sistem.
- Sediakan toggle manual di appearance settings.
- Jangan menggunakan warna hitam murni untuk seluruh canvas.
- Pastikan border dan muted text tetap terbaca.
- Status semantic harus tetap memiliki kontras yang cukup pada dark mode.

## 14. Responsive and Accessibility

- Semua fungsi utama tersedia pada keyboard.
- Focus ring harus terlihat jelas.
- Dialog memiliki focus management yang benar.
- Icon-only button wajib memiliki tooltip atau accessible label.
- Jangan menggunakan warna sebagai satu-satunya indikator.
- Target sentuh mobile memiliki ukuran yang nyaman.
- Tabel admin memiliki alternatif layout pada layar kecil.
- Hormati `prefers-reduced-motion` untuk animasi.

## 15. Component Rules

Gunakan komponen UI yang sudah tersedia sebelum membuat komponen baru.

Komponen reusable yang disarankan:

- `ProjectCard`
- `ProjectProgress`
- `TaskRow`
- `TaskCard`
- `TaskStatusBadge`
- `TaskPriorityBadge`
- `AssigneeAvatarGroup`
- `EmptyState`
- `ConfirmActionDialog`
- `ActivityTimeline`

Komponen harus menerima data melalui props dan tidak mengambil data database secara langsung.

## 16. Technical Conventions

- Gunakan Tailwind CSS v4 melalui token CSS-first.
- Gunakan semantic color token agar light dan dark mode konsisten.
- Gunakan komponen Radix/shadcn yang sudah tersedia untuk dialog, dropdown, select, checkbox, dan tooltip.
- Gunakan Inertia `Link` untuk navigasi internal.
- Gunakan Wayfinder untuk route Laravel.
- Gunakan `Form` atau `useForm` untuk form Inertia.
- Hindari hardcoded URL.
- Gunakan responsive variant Tailwind secara mobile-first.
