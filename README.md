# Custom PHP Mini-Framework 🚀

මෙය Laravel Framework එකෙහි මූලික ආකෘතිය (Core Architecture) පදනම් කර ගනිමින් PHP මඟින් නිර්මාණය කරන ලද සරල එහෙත් ඉතාමත් බලගතු MVC වෙබ් ෆ්‍රේම්වර්ක් එකකි. මෙහි Service Container, Dependency Injection, Middleware, Custom CLI (Artisan) සහ CSRF Protection වැනි ප්‍රධාන සංකල්ප අන්තර්ගත වේ.

---

## 📂 ෆෝල්ඩර් ව්‍යුහය (Directory Structure)

```text
├── app/
│   └── Controllers/        # Business Logic සහ Request හැසිරවීම
├── bootstrap.php            # Service Container සහ Core Services බින්දු (Bind) කරන තැන
├── config/
│   └── database.php        # මධ්‍යගත දත්ත ගබඩා වින්‍යාසයන් (Database Configurations)
├── core/
│   ├── App.php             # Bootstrap Logic එක (App::get())
│   ├── Container.php       # Service Container එක (Central Dependency Box)
│   ├── Database.php        # PDO Connection එක පමණක් කළමනාකරණය කරයි
│   ├── Route.php           # Static Route Wrapper (Route::get(), Route::post())
│   ├── Router.php          # Request Match කිරීම සහ Middleware ක්‍රියාත්මක කිරීම
│   ├── helpers.php         # Global Helpers (view(), csrf_token(), csrf_field())
│   └── Middleware/         # HTTP Request පෙරහන් පද්ධතිය (Security Layers)
├── public/
│   └── index.php           # වෙබ් අඩවියට පිවිසෙන ප්‍රධාන ද්වාරය (Front Controller)
├── routes/
│   └── web.php             # වෙබ් අඩවියේ සියලුම ලිපින (Routes) ලියාපදිංචි කරන ස්ථානය
├── views/                  # HTML Templates සහ Layouts
└── artisan                 # අපේම අභිමත CLI Script එක (Database Migrations)

