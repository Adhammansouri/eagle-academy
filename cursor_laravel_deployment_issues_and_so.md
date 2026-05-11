# Laravel deployment issues and solutions
_Exported on 5/11/2026 at 17:03:04 GMT+3 from Cursor (3.3.30)_

---

**User**


You said: تحليل
تحليل
تشخيص
The build was successful (54 modules transformed, assets created), but the deployment failed because the system is looking for output in the dist directory while Vite (with Laravel plugin) outputs to public/build. The configuration specifies dist as the output directory, which doesn't match where the compiled assets are actually being generated.
الحل
Change Output Directory to: public/build The Vite build completed successfully and generated all assets in public/build/ (manifest.json, CSS, and JS files are visible in the logs). The deployment system needs to be configured to use this directory instead of the default dist directory.
[أحل واكسب إلى غاية $145$](https://hpanel.hostinger.com/referrals)
اسأل

[الصفحة الرئيسية](https://hpanel.hostinger.com/)
مواقع إلكترونية
دومينات
Horizons
[رسائل البريد الإلكتروني](https://hpanel.hostinger.com/emails)
[Reach](https://hpanel.hostinger.com/email-marketing)
[التجارة الإلكترونية](https://hpanel.hostinger.com/ecommerce)
[VPS](https://hpanel.hostinger.com/vps)
[OpenClaw](https://hpanel.hostinger.com/applications)
وكلاء
الفواتير
المزيد من الخدمات
[API](https://hpanel.hostinger.com/api)
[مشاركة الحساب](https://hpanel.hostinger.com/profile/account-access/account-sharing?amplitudeLocation=side_menu)
اسم الموقع
eagleacademy.site

[لوحة التحكم](https://hpanel.hostinger.com/websites/eagleacademy.site)
عمليات النشر
متغيرات بيئة
سجلات وقت التشغيل
خطة الاستضافة
الأداء
التحليلات
الحماية
دومينات
الملفات
قواعد البيانات
متقدم
[عمليات النشر](https://hpanel.hostinger.com/websites/eagleacademy.site/deployments) تفاصيل النشر النشر من ملفات المصدر [eagleacademy.site](https://eagleacademy.site/) الإعدادات وإعادة النشرجميع عمليات النشر لقد فشلت عملية بناء النشر يرجى حل المشكلات وإعادة النشر. عرض التحليل ولاية: فشل البناء تم نشره: 2026-05-11 14:20 • 10s ملف: eagle-academy-main.zip دليل الجذر: eagle-academy-main نطاق: Vite إعدادات البناء والإخراج: تقصير إصدار العقدة: 22.x إنشاء سجلات الخطوط: 20 1 added 82 packages, and audited 83 packages in 4s 2
3
21 packages are looking for funding
4
run npm fund for details
5

6
found 0 vulnerabilities
7

8
> build
9
> vite build
10

11
vite v7.3.3 building client environment for production...
12
transforming...
13
✓ 54 modules transformed.
14
rendering chunks...
15
computing gzip size...
16
public/build/manifest.json 0.33 kB │ gzip: 0.16 kB
17
public/build/assets/app-BzjbczmN.css 32.40 kB │ gzip: 8.15 kB
18
public/build/assets/app-CcNNqum8.js 42.06 kB │ gzip: 16.53 kB
19
✓ built in 426ms
20
ERROR: No output directory found after build

Show more
2:52 PM
Claude responded: المشكلة واضحة جداً

شخّص عدم تطابق مسار الإخراج وحدّد الحل
شخّص عدم تطابق مسار الإخراج وحدّد الحل
المشكلة واضحة جداً
Hostinger بيدور على output في مجلد dist افتراضياً، لكن Vite مع Laravel plugin بيبني في public/build.

الحل: غيّر إعدادات البناء في Hostinger
في نفس الصفحة اللي أنت فيها، اضغط "إعدادات وإعادة النشر" وغيّر:

الإعداد	القيمة الحالية	القيمة الصحيحة
Output Directory	dist	public/build
لو مش لاقي الخيار ده
ممكن تضيف ملف .hostinger.yml أو تعديل في vite.config.js تخلي الـ output يطلع في dist:

js
// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'dist', // ← غيّره لو Hostinger مش بيسمح بتغيير الـ output dir
    },
});
لكن الأفضل هو تغيير إعداد Hostinger لـ public/build لأن Laravel بيعتمد على المسار ده في الـ @vite() directive.

اضغط "إعدادات وإعادة النشر" وابعتلي screenshot لو عايز أساعدك في الإعدادات.

You said: أحل واكسب إلى غاية $145$
[أحل واكسب إلى غاية $145$](https://hpanel.hostinger.com/referrals)
اسأل

[الصفحة الرئيسية](https://hpanel.hostinger.com/)
مواقع إلكترونية
دومينات
Horizons
[رسائل البريد الإلكتروني](https://hpanel.hostinger.com/emails)
[Reach](https://hpanel.hostinger.com/email-marketing)
[التجارة الإلكترونية](https://hpanel.hostinger.com/ecommerce)
[VPS](https://hpanel.hostinger.com/vps)
[OpenClaw](https://hpanel.hostinger.com/applications)
وكلاء
الفواتير
المزيد من الخدمات
[API](https://hpanel.hostinger.com/api)
[مشاركة الحساب](https://hpanel.hostinger.com/profile/account-access/account-sharing?amplitudeLocation=side_menu)
اسم الموقع
eagleacademy.site

[لوحة التحكم](https://hpanel.hostinger.com/websites/eagleacademy.site)
عمليات النشر
متغيرات بيئة
سجلات وقت التشغيل
خطة الاستضافة
الأداء
التحليلات
الحماية
دومينات
الملفات
قواعد البيانات
متقدم
عودة الإعدادات وإعادة النشر سيتم تطبيق الإعدادات على عمليات النشر القادمة ملفات المصدر قم بتحميل ملفات تطبيقك اسحب وأفلت أو حمّل الملفات المدعومة: .zip، .tar.gz، .tgz تحميل eagle-academy-main.zip 3.09 MB تكوين البناء إعداد مسبق للإطار Vite إصدار Node 22.x الدليل الجذر eagle-academy-main إعدادات البناء والإخراج أمر البناء* npm run build أمر بناء مشروعك للإنتاج. مدير الحُزَم* npm أداة لإدارة تبعيات المشروع. دليل الإخراج* المجلد الذي توجد فيه ملفاتك المُنشأة. متغيرات البيئة لا شيئ إضافة لقد فشلت عملية البناء السابقة. مزيد من التفاصيل حفظ وإعادة نشر
Show more
2:53 PM
Claude responded: الحل بسيط جداً

حدّد الحقل المطلوب تغييره للمجلد الصحيح
حدّد الحقل المطلوب تغييره للمجلد الصحيح
الحل بسيط جداً
في حقل "دليل الإخراج" اللي فاضي، اكتب:

public/build
بعدين اضغط "حفظ وإعادة نشر" — وخلاص المشكلة اتحلت.

You said: أحل واكسب إلى غاية $145$
[أحل واكسب إلى غاية $145$](https://hpanel.hostinger.com/referrals)
اسأل

[الصفحة الرئيسية](https://hpanel.hostinger.com/)
مواقع إلكترونية
دومينات
Horizons
[رسائل البريد الإلكتروني](https://hpanel.hostinger.com/emails)
[Reach](https://hpanel.hostinger.com/email-marketing)
[التجارة الإلكترونية](https://hpanel.hostinger.com/ecommerce)
[VPS](https://hpanel.hostinger.com/vps)
[OpenClaw](https://hpanel.hostinger.com/applications)
وكلاء
الفواتير
المزيد من الخدمات
[API](https://hpanel.hostinger.com/api)
[مشاركة الحساب](https://hpanel.hostinger.com/profile/account-access/account-sharing?amplitudeLocation=side_menu)
اسم الموقع
eagleacademy.site

[لوحة التحكم](https://hpanel.hostinger.com/websites/eagleacademy.site)
عمليات النشر
متغيرات بيئة
سجلات وقت التشغيل
خطة الاستضافة
الأداء
التحليلات
الحماية
دومينات
الملفات
قواعد البيانات
متقدم
[عمليات النشر](https://hpanel.hostinger.com/websites/eagleacademy.site/deployments) تفاصيل النشر النشر من ملفات المصدر حاضِر [eagleacademy.site](https://eagleacademy.site/) الإعدادات وإعادة النشرجميع عمليات النشر ولاية: مكتمل تم نشره: 2026-05-11 14:54 • 16s ملف: eagle-academy-main.zip دليل الجذر: eagle-academy-main نطاق: Vite إعدادات البناء والإخراج: مخصص إصدار العقدة: 22.x إنشاء سجلات الخطوط: 19 1 added 82 packages, and audited 83 packages in 4s 2
3
21 packages are looking for funding
4
run npm fund for details
5

6
found 0 vulnerabilities
7

8
> build
9
> vite build
10

11
vite v7.3.3 building client environment for production...
12
transforming...
13
✓ 54 modules transformed.
14
rendering chunks...
15
computing gzip size...
16
public/build/manifest.json 0.33 kB │ gzip: 0.16 kB
17
public/build/assets/app-BzjbczmN.css 32.40 kB │ gzip: 8.15 kB
18
public/build/assets/app-CcNNqum8.js 42.06 kB │ gzip: 16.53 kB
19
✓ built in 353ms
اكتمل نشر eagleacademy.site

Show more
2:54 PM
Claude responded: مكتمل ✅

Thought process
Thought process
مكتمل ✅

الموقع اتنشر بنجاح على eagleacademy.site — روح جربه!

You said: 403
403
Forbidden
Access to this resource on the server is denied!

2:55 PM
Claude responded: مشكلة 403 - السبب

Diagnosed Laravel hosting misconfiguration issue
Diagnosed Laravel hosting misconfiguration issue
مشكلة 403 - السبب
Hostinger بيخدم الملفات من الـ root directory بدل مجلد public في Laravel. الـ web server محتاج يشوف public/index.php مش index.php في الـ root.

الحل
روح إعدادات وإعادة النشر وغيّر:

الإعداد	القيمة
دليل الجذر	eagle-academy-main/public
دليل الإخراج	public/build
أو لو مش شغال، جرب:

الإعداد	القيمة
دليل الجذر	eagle-academy-main
دليل الإخراج	public
لو Hostinger مش بيدعم تغيير الـ web root
محتاج تضيف ملف .htaccess في الـ root يعمل redirect لـ public:

apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
حطه في الـ zip جنب مجلد eagle-academy-main مباشرةً، وأعد النشر.

بعتلي إيه هو structure الـ zip بالظبط؟ يعني جوا الـ zip في إيه؟

You said: This page isn’t working
This page isn’t working
eagleacademy.site is currently unable to handle this request.
HTTP ERROR 500

3:02 PM
Claude responded: 500 - Laravel شغال بس في error

Diagnosed server error and pinpointed likely configuration issues
Diagnosed server error and pinpointed likely configuration issues
500 - Laravel شغال بس في error
التقدم كويس! 403 اتحلت، دلوقتي المشكلة في Laravel نفسه. الأسباب الشائعة:

1. مفيش APP_KEY (الأغلب هو ده)
روح متغيرات البيئة في Hostinger وضيف:

APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
عشان تجيب الـ key، شغّل في أي مكان عندك PHP:

bash
php artisan key:generate --show
2. باقي المتغيرات الضرورية
ضيف دول كمان في متغيرات البيئة:

APP_ENV=production
APP_DEBUG=false
APP_URL=https://eagleacademy.site

DB_CONNECTION=mysql
DB_HOST=
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
بيانات الـ database هتلاقيها في قواعد البيانات في Hostinger.

3. مفيش vendor folder
لو الـ zip مش فيه مجلد vendor، Hostinger لازم يشغل composer install — تأكد إن الـ zip يحتوي على vendor أو إن Hostinger عنده build command للـ PHP.

ابدأ بالـ APP_KEY ده هو السبب رقم 1 في 90% من الحالات، وبعدين بعتلي النتيجة.





Claude is AI and can make mistakes. Please double-check responses.


---

**Cursor**

مراجعة إعداد المشروع لتشخيص خطأ 500 بعد النشر على Hostinger وتقديم حلول محددة.



إليك تشخيص أوضح للسياق اللي عندك، وماذا يعني **500** بعد ما اختفى **403**.

## ماذا حصل حتى الآن

1. **مجلد الإخراج** — ضبط `public/build` صحيح؛ سجلات البناء تؤكد أن الأصول في المكان الذي يتوقعه Laravel مع `@vite`.
2. **403 ثم 500** — غالبًا **Document root** أصبح يصل إلى `public/index.php` (أو يوجد توجيه سليم)، فيبدأ Laravel العمل، فيتحول الخطأ من “ممنوع” إلى **خطأ داخل التطبيق** (500).

## لماذا 500 في مشروعك تحديدًا

من `.env.example` المشروع مضبوط افتراضيًا على:

- **`DB_CONNECTION=sqlite`** مع ملف في `database/database.sqlite`
- **`SESSION_DRIVER=database`**
- **`CACHE_STORE=database`**
- **`QUEUE_CONNECTION=database`**

أي نشر بدون قاعدة جاهزة وجداول من **`migrate`** يكسر التطبيق بسهولة (جلسات، كاش، طوابير، إلخ).  
إضافة إلى ذلك، غياب **`APP_KEY`** أو عدم تشغيل **`composer install`** أو عدم وجود **`vendor`** يعطي 500 أيضًا.

## ما الذي تفعله عمليًا (بالترتيب)

### 1) متغيرات البيئة في Hostinger

في **متغيرات بيئة** أضف على الأقل:

- **`APP_KEY`** — يجب أن يكون قيمة كاملة مثل `base64:...` (من `php artisan key:generate --show` محليًا).
- **`APP_ENV=production`**
- **`APP_DEBUG=true`** مؤقتًا فقط لمعرفة الخطأ الحقيقي، ثم **`APP_DEBUG=false`** بعد الإصلاح.
- **`APP_URL=https://eagleacademy.site`**

### 2) قاعدة البيانات (مهم جدًا على الاستضافة المشتركة)

لا تعتمد على SQLite من الـ zip إلا إذا أنت متأكد أن الملف موجود ومسموح الكتابة عليه.

الأفضل لـ Hostinger:

- **`DB_CONNECTION=mysql`**
- **`DB_HOST`، `DB_DATABASE`، `DB_USERNAME`، `DB_PASSWORD`** من لوحة **قواعد البيانات**

### 3) تشغيل Composer والـ migrations

تأكد أن على السيرفر يوجد **`vendor`** (إما من الرفع أو بتشغيل `composer install --no-dev --optimize-autoloader` عبر SSH/Terminal في Hostinger إن وُجد).

ثم مرة واحدة:

```bash
php artisan migrate --force
```

بدون **`migrate`**، إعدادك الحالي لـ session/cache/queue على قاعدة البيانات سيفشل غالبًا.

### 4) الصلاحيات

تأكد أن المجلدات **`storage`** و **`bootstrap/cache`** قابلة للكتابة من الويب (صلاحيات مناسبة على الاستضافة).

### 5) أسرع طريقة لمعرفة السبب الدقيق

من **مدير الملفات** افتح:

`storage/logs/laravel.log`

أو فعّل **`APP_DEBUG=true`** مؤقتًا وحدّث الصفحة — ستظهر رسالة الخطأ مباشرة (لا تتركها مفعّلة في الإنتاج).

---

**الخلاصة:** النشر من المصدر مع `npm run build` وحده **لا يكفي** لتشغيل Laravel؛ تحتاج **`APP_KEY`**، وقاعدة بيانات متسقة مع الإعدادات، و**`vendor`**، و**`php artisan migrate --force`**. الخطأ الأشيع بعد إصلاح 403 هو إما **`APP_KEY`** أو قاعدة البيانات/الجلسات بدون جداول.

لو نسخت سطر أو سطرين من **آخر أخطاء** في `storage/logs/laravel.log` (بدون كلمات سر)، يمكن ربطها بنقطة الإعداد بالضبط.

---

**User**

اعملي الملفات دي

---

**Cursor**

البحث عن صيغة ملفات نشر Hostinger المناسبة لمشروع Laravel، ثم إنشاء الملفات المطلوبة.



إنشاء ملفين كانتا مقترحتين في المحادثة: `.htaccess` في جذر المشروع لتوجيه الطلبات إلى `public/`، وملف مرجعي لمتغيرات البيئة على Hostinger (لأن `.hostinger.yml` غير موثّق رسميًا كملف في المستودع).



تم إنشاء الملفات التالية:

## 1. `.htaccess` (في جذر المشروع)

يوجّه كل الطلبات إلى **`public/`** حتى لو كان **Document root** على مجلد المشروع وليس `public`، مع شرط يمنع مسارًا من نوع `public/public`.

## 2. `.hostinger.env.example`

قالب لمتغيرات البيئة تنسبها في لوحة Hostinger (إنتاج، MySQL، جلسات/كاش على قاعدة البيانات مثل مشروعك). املأ **`APP_KEY`** (من `php artisan key:generate --show`) وبيانات **`DB_*`** ثم نفّذ **`php artisan migrate --force`** على السيرفر بعد أول رفع.

---

**ملاحظة:** لم أُنشئ **`vite.config.js`** بـ `outDir: 'dist'` لأن Laravel يعتمد على **`public/build`** مع `@vite`، والإعداد الصحيح في لوحة النشر هو **`public/build`** كمجلد إخراج.

لو تحب اسمًا مختلفًا للملف الثاني (مثل `.env.hostinger.example`) أو إضافة سكربت **`composer install` + migrate** للتشغيل عبر SSH، اكتب ذلك وسأعدّله.

---

**User**

أحل واكسب إلى غاية $145$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات

متقدم
عمليات النشر
تفاصيل النشر
النشر من ملفات المصدر

حاضِر
eagleacademy.site

الإعدادات وإعادة النشر

جميع عمليات النشر
ولاية:

مكتمل

تم نشره:

2026-05-11 15:21

•

34s

ملف:

eagle-academy-main.zip

دليل الجذر:

eagle-academy-main

نطاق:

Vite

إعدادات البناء والإخراج:

مخصص

إصدار العقدة:

22.x

إنشاء سجلات
الخطوط: 19

سجلات البحث



1

added 82 packages, and audited 83 packages in 4s

2


3

21 packages are looking for funding

4

run `npm fund` for details

5


6

found 0 vulnerabilities

7


8

> build

9

> vite build

10


11

vite v7.3.3 building client environment for production...

12

transforming...

13

✓ 54 modules transformed.

14

rendering chunks...

15

computing gzip size...

16

public/build/manifest.json 0.33 kB │ gzip: 0.16 kB

17

public/build/assets/app-BzjbczmN.css 32.40 kB │ gzip: 8.15 kB

18

public/build/assets/app-CcNNqum8.js 42.06 kB │ gzip: 16.53 kB

19

✓ built in 388ms



---

**Cursor**

اللي ظاهر في اللوج **سليم**: `npm run build` خلص، وملفات الأصول اتولّدت في **`public/build`** زي ما Laravel المفروض يستقبلها.

بما إن حالة النشر **مكتمل**، الخطوة المنطقية دلوقتي:

1. **افتح الموقع في المتصفح** (`https://eagleacademy.site`) وتأكد إن الصفحة تظهر مش **500** أو صفحة فاضية.
2. لو في مشكلة، راجع **متغيرات البيئة** في Hostinger (خصوصًا **`APP_KEY`** و **`DB_*`** لو بتستخدم MySQL) وتأكد إن على السيرفر في **`vendor`** وإن **`php artisan migrate --force`** اتنفّذ لو محتاج قاعدة بيانات.

الجزء اللي فوق عن **«أحل واكسب إلى غاية $145$»** ده إعلان/إحالة من واجهة Hostinger، ومش له علاقة بنجاح أو فشل البناء نفسه.

لو حابب تقول إيه اللي بيظهر لك على الموقع دلوقتي (شغال، 500، صفحة بيضاء، إلخ)، نكمّل من هناك بدقة.

---

**User**

أحل واكسب إلى غاية $145$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات

متقدم
مواقع إلكترونية
eagleacademy.site
متغيرات بيئة
متغيرات بيئة

استيراد env.

أضف متغير بيئة
البحث

إخفاء جميع القيم
مفتاح
قيمة
إجراءات
APP_NAME

Eagle Academy


APP_ENV

production


APP_DEBUG

false


APP_URL

https://eagleacademy.site


LOG_CHANNEL

stack


LOG_LEVEL

error


DB_CONNECTION

mysql


DB_HOST

127.0.0.1


DB_PORT

3306


BROADCAST_CONNECTION

log


حجم الصفحة:
10
1
إلى
10
من
22

صفحة
1
من
3



---

**Cursor**

اللي ظاهر في الصفحة الأولى من **متغيرات البيئة** منطقي كبداية، لكن لازم تتأكد من الباقي لأن عندك **22 متغير على 3 صفحات** والمهم قد يكون في الصفحات 2 و 3.

## اللي لازم يكون موجود (تحقق منه)

1. **`APP_KEY`**  
   لازم يكون بصيغة `base64:...`. لو مش موجود أو فاضي Laravel غالبًا يدي **500**.  
   محليًا: `php artisan key:generate --show` ثم انسخ القيمة كما هي إلى Hostinger.

2. **قاعدة البيانات (MySQL)**  
   مع `DB_CONNECTION=mysql` لازم يكون عندك أيضًا:
   - **`DB_DATABASE`**
   - **`DB_USERNAME`**
   - **`DB_PASSWORD`**  

   القيم الصحيحة تطلعها من **قواعد البيانات** في hPanel (اسم القاعدة والمستخدم وكلمة المرور)، وليس بالتخمين.

3. **`DB_HOST`**  
   `127.0.0.1` أحيانًا يعمل وأحيانًا لا على الاستضافة المشتركة. لو التطبيق ما يتصل بالـ DB، جرّب **`localhost`** أو الـ hostname اللي يظهر في صفحة قاعدة البيانات في Hostinger.

4. **إعداد المشروع نفسه**  
   من ملف `.hostinger.env.example` عندك في المستودع، التطبيق يتوقع غالبًا أيضًا:
   - **`SESSION_DRIVER`** و **`CACHE_STORE`** و **`QUEUE_CONNECTION`** (لو معمولة على `database` زي المشروع الافتراضي، لازم **`migrate`** يكون متنفّذ على السيرفر).

## خطوة عملية سريعة

ارفع صفحات **2 و 3** من متغيرات البيئة (أو اعمل لقطة تشمل **`APP_KEY`** و **`DB_*`** الكاملة)، أو أكد بنفسك إن الخمسة دول موجودين ومظبوطين: **`APP_KEY`، `DB_DATABASE`، `DB_USERNAME`، `DB_PASSWORD`، و`DB_HOST` الصحيح من لوحة القاعدة**.

لو تحب، الصق هنا **أسماء المفاتيح فقط** (من غير كلمات السر) من الصفحات الثانية والثالثة وأقول لك إذا كان أي شيء ناقص بالنسبة لمشروع Laravel هذا.

---

**User**

@c:\Users\ADHAM\.cursor\projects\c-Users-ADHAM-Documents-GitHub-eagle-academy\terminals\4.txt:9-34 

---

**Cursor**

`vendor` غير موجود — Laravel يحتاج تشغيل Composer أولًا. جاري تنفيذ `composer install` في المشروع.



## سبب الخطأ

رسالة **`Failed opening required '.../vendor/autoload.php'`** معناها إن مجلد **`vendor`** مش موجود لأن **`composer install`** ما اتشغّلش بعد على المشروع. بدون `vendor`، **`php artisan`** مش هيشتغل.

## الحل

في مجلد المشروع شغّل مرة واحدة:

```powershell
cd C:\Users\ADHAM\Documents\GitHub\eagle-academy
composer install --no-interaction
```

بعد ما يخلص، الأمر ده هيشتغل:

```powershell
php artisan key:generate --show
```

ده يطبع **`APP_KEY`** بصيغة **`base64:...`** — انسخها وحطّها في **متغيرات البيئة** في Hostinger تحت المفتاح **`APP_KEY`**.

تم التحقق على جهازك بعد وجود **`vendor/autoload.php`** أن **`php artisan key:generate --show`** يعمل ويطبع مفتاحًا صالحًا.

**ملاحظة:** استخدم **نفس** `APP_KEY` بين البيئة المحلية والاستضافة لو بتشارك نفس قاعدة البيانات أو جلسات؛ لو كانت بيئة الإنتاج منفصلة، يكفي مفتاح واحد ثابت في Hostinger (يتولَّد مرة ويُنسَخ هناك).

**تلميح للنشر:** لو الرفع بـ zip بدون مجلد **`vendor`**، لازم على Hostinger يتشغّل **`composer install`** (SSH أو خطوة بناء PHP لو متوفرة)، لأن موقع Laravel بدون **`vendor`** هيظل معطّل حتى لو **`npm run build`** نجح.

---

**User**

<system_notification>
The following task has finished. If you were already aware, ignore this notification and do not restate prior responses.

<task>
kind: shell
status: error
task_id: 159028
title: Install Composer deps in project directory (PowerShell)
detail: exit_code=1
output_path: C:\Users\ADHAM\.cursor\projects\c-Users-ADHAM-Documents-GitHub-eagle-academy\terminals\159028.txt
</task>
</system_notification>
<user_query>Briefly inform the user about the task result and perform any follow-up actions (if needed).</user_query>

---

**Cursor**

المهمة الأولى (`composer install`) فشلت: تعارض أثناء فك حزمة `brick/math` وملف مؤقت مفقود، ثم خطأ `Resource temporarily unavailable` عند كتابة `vendor/composer/installed.php` (غالباً بسبب تشغيل `composer install` مرتين في نفس الوقت). نتحقق من حالة المشروع ونُكمل التثبيت.



## نتيجة المهمة (المعرّف 159028)

**النتيجة:** فشل **`composer install`** الأول (`exit code 1`). السجل يبيّن:

1. فشل فك حزمة **`brick/math`** أثناء الاستخراج (ملف مؤقت في `vendor/composer/tmp-*.zip` مش موجود).
2. بعدها خطأ **`Resource temporarily unavailable`** عند كتابة **`vendor/composer/installed.php`** — غالبًا بسبب **تشغيل أكثر من عملية `composer` معًا** أو تعارض على الملفات.

**المتابعة التي تمت:** شغّلنا **`composer install`** مرة أخرى بعد اكتمال تثبيت سابق؛ تم تثبيت **`brick/math`** واكتمل **`package:discover`**. التحقق: **`php artisan --version`** → **Laravel 12.53.0** (يعمل).

**للتذكير:** لو حصل نفس الخطأ مرة ثانية، شغّل **`composer install`** مرة واحدة فقط، ويمكنك حذف مجلد **`vendor`** وإعادة التثبيت من غير ما تشغّل عمليتين مع بعض.

---

**User**

<system_notification>
The following task has finished. If you were already aware, ignore this notification and do not restate prior responses.

<task>
kind: shell
status: error
task_id: 963357
title: Complete composer install synchronously
detail: exit_code=1
output_path: C:\Users\ADHAM\.cursor\projects\c-Users-ADHAM-Documents-GitHub-eagle-academy\terminals\963357.txt
</task>
</system_notification>
<user_query>Briefly inform the user about the task result and perform any follow-up actions (if needed).</user_query>

---

**Cursor**

## نتيجة المهمة (963357 — «Complete composer install synchronously»)

**ما ظهر في السجل:** التثبيت **اكتمل فعليًا**: الوصول إلى **100%**، ثم **Generating optimized autoload files**، ثم **`php artisan package:discover`** واكتشاف الحزم (كلها **DONE**)، وظهور رسالة **«81 packages you are using are looking for funding»**.

**لماذا `exit code: 1`؟** في PowerShell، `composer` أحيانًا يكتب على **stderr** في بداية التشغيل، فيُعامل كـ **NativeCommandError** ويُرجع **1** رغم نجاح العملية. هذا يفسّر التناقض بين **نجاح السجل** و**كود الخروج**.

**متابعة:** تم التحقق — **`composer.json` صالح** و**`php artisan about`** يعرض **Laravel 12.53.0** و**PHP 8.2.27**. لا يلزم إعادة تثبيت إلا إذا لاحظت سلوكًا غريبًا في `vendor/`.

---

**User**

base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI=
admin
أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات
إدارة
phpMyAdmin
MySQL عن بعد

متقدم
مواقع إلكترونية
eagleacademy.site
قواعد البيانات
إدارة
إدارة
إنشاء قاعدة بيانات MySQL و مستخدم قاعدة بيانات جديدين
إسم قاعدة البيانات MySQL
u358087675_
اسم قاعدة البيانات
إسم المستخدم MySQL
u358087675_
admin
كلمة المرور
eOU$+j5Y

الحد الأدنى 8 من الحروف
يجب أن تحتوي على الأقل على حرف صغير واحد
يجب أن تحتوي على الأقل على حرف كبير واحد
يجب أن تحتوي رقما واحد على الأقل

إنشاء
قائمة قواعد بيانات MySQL الحالية والمستخدمين
قاعدة بيانات MySQL
مستخدم MySQL
تاريخ الإنشاء
الموقع الإلكتروني
u358087675_admin
1 MB
u358087675_admin	
2026-05-11
eagleacademy.site

دخول phpMyAdmin


@.hostinger.env.example 

---

**Cursor**

تحذير أمني: لقد نشرت **كلمة مرور قاعدة البيانات** و**APP_KEY** في المحادثة. يجب **تغيير كلمة مرور المستخدم في Hostinger فورًا** واعتبار البيانات معرّضة. لا ننسخ الأسرار إلى المستودع. تحديث `.hostinger.env.example` بقيم عيّنة آمنة وتعليمات Hostinger فقط.



استبدال المعرفات الحقيقية بعناصر نائبة في المثال حتى لا نربط المستودع بحسابهم.



## تحذير أمني (مهم)

لقد ظهرت في رسالتك **كلمة مرور قاعدة البيانات** و**مفتاح التطبيق `APP_KEY`**. اعتبرها **مسربة**. الأفضل أن:

1. **تغيّر كلمة مرور مستخدم MySQL** من لوحة Hostinger (قواعد البيانات → المستخدم → تغيير كلمة المرور).
2. تحدّث **`DB_PASSWORD`** في **متغيرات البيئة** بالقيمة الجديدة.
3. لو كنت قلقًا على الجلسات بعد تسريب المفتاح، يمكنك توليد **`APP_KEY`** جديد محليًا (`php artisan key:generate --show`) وتحديثه في Hostinger — سيُخرج المستخدمين الحاليين من الجلسات فقط.

لا تعِد نشر الأسرار في الدردشة أو في Git.

---

## ماذا تضع في Hostinger (متغيرات البيئة)

نسخ القيم من `.hostinger.env.example` المحدَّث، مع استبدال الأمثلة بأرقامك من لوحة **قواعد البيانات**:

| المفتاح | القيمة |
|--------|--------|
| **APP_KEY** | القيمة الكاملة التي تبدأ بـ `base64:` (من `php artisan key:generate --show`) |
| **DB_DATABASE** | اسم القاعدة كما في القائمة (مثل `u358087675_admin` إذا كان هذا هو الاسم الكامل) |
| **DB_USERNAME** | نفس صيغة المستخدم في القائمة |
| **DB_PASSWORD** | كلمة المرور **الجديدة** بعد التدوير |

جرّب **`DB_HOST`** بـ `127.0.0.1`؛ إن فشل الاتصال جرّب **`localhost`**.

بعدها على السيرفر (SSH أو الطرفية في Hostinger إن وُجدت):

`php artisan migrate --force`

---

## التعديل في المستودع

تم تحديث **`.hostinger.env.example`** بتعليقات أوضح لـ Hostinger (صيغة أسماء قواعد البيانات، **`DB_HOST`**، التذكير بعدم كشف الأسرار وتشغيل الـ migrations)، **بدون** حفظ كلمة المرور أو مفتاحك الحقيقي في الملف.

---

**User**

أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات

متقدم
مواقع إلكترونية
eagleacademy.site
متغيرات بيئة
متغيرات بيئة
تغييرات غير محفوظة: 3

استيراد env.

أضف متغير بيئة
البحث

إخفاء جميع القيم
مفتاح
قيمة
إجراءات
APP_KEY

base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI=


APP_NAME

Eagle Academy


APP_ENV

production


APP_DEBUG

false


APP_URL

https://eagleacademy.site


LOG_CHANNEL

stack


LOG_LEVEL

error


DB_CONNECTION

mysql


DB_HOST

127.0.0.1


DB_PORT

3306


DB_DATABASE

u123456789_eagle


DB_USERNAME

u123456789_eagle


BROADCAST_CONNECTION

log


FILESYSTEM_DISK

local


SESSION_DRIVER

database


SESSION_LIFETIME

120


SESSION_ENCRYPT

false


SESSION_PATH

/


SESSION_DOMAIN

null


CACHE_STORE

database


QUEUE_CONNECTION

database


MAIL_MAILER

log


MAIL_FROM_ADDRESS

hello@example.com


MAIL_FROM_NAME

${APP_NAME}


VITE_APP_NAME

${APP_NAME}


حجم الصفحة:
75
1
إلى
25
من
25

صفحة
1
من
1


تخطّي

تطبيق التغييرات


---

**Cursor**

في لوحة المتغيرات عندك مشكلتان أساسيتان:

## 1) **`DB_DATABASE` و `DB_USERNAME`**

القيم **`u123456789_eagle`** من ملف المثال في المشروع — **مو اسم قاعدة بياناتك الحقيقية**. لازم تحط **بالظبط** الاسمين اللي يظهروا في Hostinger → **قواعد البيانات** (زي ما كان عندك سابقًا: `u358087675_admin` للقاعدة والمستخدم، أو أي اسم يعرضه النظام بعد الإنشاء).

## 2) **`DB_PASSWORD`**

في القائمة اللي أرسلتها **مفيش متغير `DB_PASSWORD`**. بدونه Laravel **ما يتصلش بـ MySQL**. أضف متغيرًا اسمه **`DB_PASSWORD`** وقيمته **كلمة مرور مستخدم قاعدة البيانات** (اللي أنشأته في القواعد البيانات).

---

## باقي تنبيهات سريعة

- **`MAIL_FROM_NAME`** و **`VITE_APP_NAME`**: لو لوحة Hostinger **ما تدعم** استبدال `${APP_NAME}`، اكتب النص مباشرة مثل **`Eagle Academy`** بدل `${APP_NAME}`.
- **`SESSION_DOMAIN`**: لو استمرت مشاكل في الكوكيز، جرّب إفراغ القيمة أو حذف المتغير بدل `null` حسب ما تسمح به الواجهة.

بعد التصحيح اضغط **«تطبيق التغييرات»** (أو Save)، ثم تأكد من تشغيل **`php artisan migrate --force`** على السيرفر إن كان متاحًا.

**أمان:** تجنّب نشر **`APP_KEY`** أو كلمات السر في المحادثات؛ لو ظهرت من قبل، بدّل كلمة مرور قاعدة البيانات حسب ما ذكرنا سابقًا.

---

**User**

This page isn’t working
eagleacademy.site is currently unable to handle this request.
HTTP ERROR 500

---

**Cursor**

مراجعة إعداد المشروع لتحديد أسباب شائعة لخطأ 500 بعد النشر:



خطأ **500** يعني Laravel بدأ التشغيل ثم حصل استثناء. في مشروعك الغالب أن السبب واحد أو أكثر مما يلي.

## 1) اقرأ السبب من السيرفر (الأسرع)

في Hostinger: **الملفات** → ادخل لمجلد المشروع → افتح:

`storage/logs/laravel.log`

انزل لآخر الملف وانسخ **آخر 30–50 سطر** (بدون كلمات سر). غالبًا ستجد رسالة مثل **جدول `sessions` غير موجود** أو **فشل الاتصال بقاعدة البيانات** أو **لا يوجد `vendor`**.

---

## 2) الأسباب الشائعة لهذا المشروع تحديدًا

| السبب | ماذا تفعل |
|--------|-----------|
| **`vendor` غير موجود على السيرفر** | الرفع بـ zip غالبًا لا يضم `vendor`. يجب تشغيل **`composer install --no-dev --optimize-autoloader`** في مجلد المشروع (SSH أو أي Terminal يوفره Hostinger). بدونها **`public/index.php`** يفشل عند `require vendor/autoload.php`. |
| **قاعدة البيانات خاطئة أو ناقصة** | تأكد من **`DB_DATABASE`**, **`DB_USERNAME`**, **`DB_PASSWORD`** كما في **قواعد البيانات** (ليس `u123456789_eagle` إلا إذا كان هذا اسمك الفعلي). أضف **`DB_PASSWORD`** إن كان ناقصًا. جرّب **`DB_HOST`** = `localhost` إذا فشل `127.0.0.1`. |
| **الجلسات على قاعدة البيانات بدون جداول** | مع **`SESSION_DRIVER=database`** و **`CACHE_STORE=database`** يجب تشغيل الهجرات مرة واحدة: **`php artisan migrate --force`** على السيرفر بعد ضبط `.env`/متغيرات البيئة. |

---

## 3) للتشخيص المؤقت فقط

في **متغيرات البيئة** ضع **`APP_DEBUG=true`** وحدّث الصفحة مرة واحدة لقراءة رسالة الخطأ، ثم أعد **`APP_DEBUG=false`** فورًا حتى لا تُعرَض التفاصيل للزوار.

---

## 4) تحقق سريع بدون قراءة اللوج

افتح في المتصفح (إن كان مسار Laravel قياسيًا):

`https://eagleacademy.site/up`

- إذا رجع **200** والموقع الأساسي **500**، غالبًا المشكلة في **مسار معيّن** أو **قاعدة البيانات/الجلسات** عند الطلبات التي تستخدم الـ session.
- إذا **500** أيضًا، غالبًا **`vendor`** أو إعداد أساسي في البيئة.

---

**الخطوة الأكثر فائدة الآن:** افتح **`storage/logs/laravel.log`** على الاستضافة وأرسل **آخر جزء من الخطأ** (نص الرسالة فقط)، أو صِف ما يظهر مع **`APP_DEBUG=true`** مؤقتًا، وسأربطها بحل محدد خطوة بخطوة.

---

**User**

personu358087675
folderMy files
create_new_folderNew folder
note_addNew file
deleteTrash bin
Space

0.31%
159.82 MiB / 50 GiB

Inodes

0.42%
2535 / 600000
exit_to_appLogout
File Browser v2.63.2-h2
Help

home
keyboard_arrow_right
public_html

search
Search...





view_modulefile_downloadfile_uploadassessmentinfocheck_circle
Namearrow_downward

Sizearrow_upward

Last modifiedarrow_upward

js

-

15 hours ago

drwxr-xr-x

images

-

15 hours ago

drwxr-xr-x

css

-

15 hours ago

drwxr-xr-x

build

-

12 minutes ago

drwxr-xr-x

.builds

-

12 minutes ago

drwx------

robots.txt

24 B

15 hours ago

-rw-r--r--


logo.jpg

16.47 KiB

15 hours ago

-rw-r--r--

index.php

543 B

15 hours ago

-rw-r--r--


favicon.ico

0 B

15 hours ago

-rw-r--r--


1.jpg

16.47 KiB

15 hours ago

-rw-r--r--

.htaccess

769 B

12 minutes ago

-rw-r--r--

Multiple selection enabled

clear


---

**Cursor**

اللي ظاهر في لقطة الشاشة يوضّح جزءًا مهمًا من المشكلة.

## ماذا يعني ما تراه

المجلد **`public_html`** عندك فيه أشياء تشبه **محتويات مجلد `public` في Laravel فقط**:

- `build/` (أصول Vite)
- `css/`، `js/`، `images/`
- `index.php`، `.htaccess`

هذا **طبيعي كوجهة للموقع**، لكن Laravel لا يعمل من هذا المجلد وحده.

ملف **`public/index.php`** الرسمي يستدعي:

```php
require __DIR__.'/../vendor/autoload.php';
```

يعني مجلد **`vendor`** (ومعه **`app`، `bootstrap`، `config`، `routes`، `storage`، ملف `artisan`، إلخ**) لازم يكون **في المجلد الأعلى مباشرة** الذي يحتوي على مجلد الويب:

إذا كان مسار الموقع مثلًا:

`.../domains/eagleacademy.site/public_html`

فيُفترض وجود:

`.../domains/eagleacademy.site/vendor/`  
`.../domains/eagleacademy.site/storage/`  
… وهكذا، **وليس** داخل `public_html` فقط.

## لماذا يظهر عندك HTTP 500

غالبًا واحد من هذين:

1. **لا يوجد `vendor` ولا مشروع Laravel كامل** فوق `public_html` → `index.php` يفشل عند تحميل Composer.
2. أو المشروع موجود في مسار آخر لكن **`index.php`** أو **مسار المستندات** غير متوافقين مع البنية أعلاه.

نشر Hostinger من المصدر مع إطار **Vite** غالبًا يشغّل **`npm run build`** فقط ويضع **`public/build`** في الموقع، **بدون** `composer install` وبدون رفع مشروع PHP كامل — وهذا لا يكفي لتشغيل Laravel.

## ماذا تفعل عمليًا

1. في مدير الملفات، **اطلع مستوى واحد فوق `public_html`** (المجلد الأب لـ `public_html`).
2. تحقق هل يوجد **`vendor`** و **`artisan`** ومجلد **`app`**.
   - **إن لم يوجدوا:** يجب رفع **المستودع كامل Laravel** (أو على الأقل كل الملفات ما عدا `node_modules` غالبًا)، ثم على السيرفر تشغيل **`composer install --no-dev --optimize-autoloader`** في **جذر المشروع** (الذي يحتوي `artisan`).
3. تأكد أن **`public_html`** إما:
   - يحتوي **نفس محتويات** مجلد `public` للمشروع بعد البناء، مع أن **`index.php`** هو **`public/index.php` الخاص بـ Laravel** (وليس ملفًا صغيرًا عشوائيًا 543 بايت إذا كان مختلفًا)،  
   أو  
   - يضبط Hostinger **Document root** على مجلد **`public`** داخل مشروع Laravel إن كانت الخطة تسمح بذلك.

4. بعد وجود **`vendor`** وملف **`.env`/متغيرات البيئة** الصحيحة: **`php artisan migrate --force`** من الطرفية إن وُجدت.

## خلاصة

ما تراه داخل **`public_html`** يبدو كـ **واجهة الموقع + الأصول** فقط. **500** يتوقع طالما **جذر Laravel الحقيقي** (`vendor` + باقي المشروع) **غير موجود في المسار الصحيح فوق `public_html`**.

ارفع مستوى مجلد واحد في الملفات وأخبرني: **هل ترى `vendor` و `artisan` بجانب `public_html`؟** من ذلك نحدد الخطوة التالية بدقة.

من الصورة يبان الوضع بوضوح.

## ماذا يظهر في الجذر؟

في **مجلد المنزل (home)** عندك يوجد فقط:

- **`public_html`**
- ملف **`DO_NOT_UPLOAD_HERE`** (تذكير من الاستضافة ألا ترفع الموقع في الجذر بدل المجلد الصحيح)

**لا يوجد** بجانب `public_html` مجلد مشروع Laravel فيه **`vendor`** أو **`app`** أو **`artisan`**.  
يعني: **مشروع PHP Laravel الكامل غير موجود في المسار الذي يحتاجه السيرفر** — وهذا يفسّر **HTTP 500** إذا كان `index.php` يحاول تحميل `../vendor/autoload.php` بينما **`vendor`** غير موجود في المستوى الأعلى الصحيح.

كمان يؤكد أن **`u123456789_eagle`** في متغيرات البيئة خطأ؛ حسابك الفعلي من الواجهة هو **`u358087675`**، فأسماء قاعدة البيانات/المستخدم يجب أن تطابق ما في **قواعد البيانات** (مثل **`u358087675_admin`** إن كان هذا الاسم المعروض هناك).

---

## المطلوب تنظيميًا على Hostinger

1. **ارفع مشروع Laravel كاملًا** (يفضّل بعد **`composer install`** محليًا ثم رفع يتضمن **`vendor`**، أو رفع بدون `vendor` وتشغيل **`composer install`** على السيرفر إن وُجد SSH/Terminal).
2. **لا يكفي** مجلد **`build`** وملفات الواجهة داخل `public_html` — ذلك ناتج **Vite** فقط وليس تطبيق Laravel.
3. البنية الشائعة على استضافة مشتركة:
   - مجلد للمشروع يحتوي `app`, `bootstrap`, `config`, `database`, `routes`, **`vendor`**, **`storage`**, `artisan`, …
   - ومحتويات **`public`** (من مشروعك) تكون داخل **`public_html`** (أو يُضبط Document root على `public` إن كان متاحًا).
4. إذا وضعت ملفات **`public`** داخل `public_html` بينما باقي Laravel في مجلد آخر (مثل `eagle-academy` بجانب `public_html`)، لازم **`index.php` داخل `public_html`** يشير لمسارات **`bootstrap/app.php`** و**`vendor`** الصحيحة (غالبًا تعديل المسارات النسبية من `../` إلى **`../اسم_مجلد_المشروع/`**).

---

## خطوتك التالية العملية

- افتح **`public_html`** وافتح ملف **`index.php`**  
  - إذا كان أول سطر فيه **`vendor/autoload`** والمجلد الأب **ما فيه `vendor`** → هذا هو سبب الـ 500 مباشرة.
- أنشئ/ارفع مجلد المشروع الكامل في المسار الذي يتوافق مع ما يكتبه **`index.php`**، أو عدّل **`index.php`** ليطابق مكان **`vendor`** الحقيقي.

لو تحب، انسخ **أول 25 سطرًا من `public_html/index.php`** (من مدير الملفات) والصقها هنا بدون أي كلمات سر، وأقول لك بالضبط أي مسارات تعدّلها حسب أين رفعت مجلد Laravel.

---

**User**

<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());


---

**Cursor**

هذا **`index.php` هو ملف Laravel الرسمي**، والمسارات فيه ثابتة وتفترض هيكلة محددة.

## ماذا يعني الكود؟

بما أن الملف يوجد عادة في **`public_html/index.php`**، فـ **`__DIR__`** = مجلد **`public_html`**.

كل ما يلي يشير إلى **المجلد الأب** (مستوى واحد فوق `public_html`):

| السطر | يبحث عن |
|--------|---------|
| `../vendor/autoload.php` | **`vendor`** بجانب `public_html` |
| `../bootstrap/app.php` | **`bootstrap`** بجانب `public_html` |
| `../storage/framework/...` | **`storage`** بجانب `public_html` |

يعني الهيكلة المطلوبة على الحساب تكون هكذا:

```text
/home/u358087675/          (أو جذر الدومين عندك)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
├── vendor/                 ← هنا لازم يكون composer
├── artisan
├── composer.json
├── public_html/            ← وجهة الموقع
│   ├── index.php           ← الملف اللي لصقته
│   ├── .htaccess
│   ├── build/
│   └── … باقي محتويات public
```

**لا يصح** أن يكون **`vendor`** داخل **`public_html`** فقط، لأن المسار **`../vendor`** يعني «مجلد الأب» وليس داخل `public_html`.

---

## ماذا تفعل عمليًا

1. ارفع **مشروع Laravel كاملًا** بحيث يكون **`vendor`** و**`bootstrap`** و**`storage`** و**`app`** في **نفس مستوى** مجلد **`public_html`** (وليس داخل `public_html`).
2. انقل **محتويات** مجلد **`public`** من المشروع إلى **`public_html`** (منها `index.php`، `.htaccess`، **`build`** إن وُجد بعد `npm run build`).
3. تأكد أن **`storage`** و **`bootstrap/cache`** قابلة للكتابة على السيرفر.
4. بعد الرفع: **`php artisan migrate --force`** (إن وُجد SSH)، ومتغيرات البيئة صحيحة (منها **`DB_*`** الحقيقية لـ **`u358087675...`** وليس أمثلة **`u123456789`**).

---

## خلاصة

الـ **`index.php` صحيح**؛ المشكلة في **مكان الملفات على السيرفر**: طالما **`vendor`** ليس في **المجلد الأب لـ `public_html`** كما فوق، سيظل **`HTTP 500`** لأن **`require .../vendor/autoload.php`** يفشل.

بعد ترتيب المجلدات كما سبق، جرّب الموقع مرة أخرى؛ إذا استمر الخطأ، الخطوة التالية هي قراءة **`storage/logs/laravel.log`**.

---

**User**

هرفع الملف دا
@c:\Users\ADHAM\Documents\GitHub\eagle-academy.zip 

---

**Cursor**

التحقق من وجود الأرشيف ومحتوياته المقترحة قبل الرفع إلى Hostinger.



تم إنشاء الأرشيف بنجاح.

## الملف جاهز

- **المسار:** `C:\Users\ADHAM\Documents\GitHub\eagle-academy.zip`
- **الحجم:** حوالي **30 ميجابايت** (يشمل **`vendor`** وأصول **`public/build`** بعد تشغيل **`npm run build`**)
- **المستثنى من الأرشيف:** **`node_modules`** و **`.git`** فقط (يقلل الحجم؛ **`vite`** يُشغَّل محليًا قبل الضغط)

المشروع محليًا كان يفتقر **`public/build`**؛ تم تنفيذ **`npm install`** ثم **`npm run build`** قبل الضغط.

---

## بعد الرفع على Hostinger

1. ارفع **`eagle-academy.zip`** من مدير الملفات إلى **مجلد المنزل** (نفس مستوى **`public_html`**)، وليس داخل **`public_html`** فقط.
2. **فك الضغط** هناك. ستظهر مجلدات مثل **`app`**, **`bootstrap`**, **`vendor`**, **`storage`**, ومجلد **`public`**.
3. **انسخ محتويات** مجلد **`public`** (منهم **`index.php`**, **`.htaccess`**, **`build`**) إلى **`public_html`**، بحيث يصبح **`vendor`** و**`bootstrap`** و**`storage`** في **المجلد الأعلى** بجانب **`public_html`** كما شرحنا سابقًا للمسارات في **`index.php`**.
4. لو ظهر مجلد واحد يغلف كل شيء بعد الفك (مثل اسم الملف)، ادخل إليه ثم انقل الملفات للمستوى الصحيح.
5. حدّث **متغيرات البيئة** في لوحة Hostinger (خصوصًا **`DB_*`** الحقيقية لحساب **`u358087675`** وليس أمثلة **`u123456789`**)، ثم **`php artisan migrate --force`** إن وُجد SSH.

**ملاحظة:** ملف **`.env`** غالبًا غير مرفوع (مستثنى عمليًا أو غير موجود)؛ الاعتماد على **متغيرات البيئة في Hostinger** كما أنت فاعلٍ صحيح.

لو احتجت، الخطوة التالية تكون التحقق بعد الرفع من وجود **`vendor`** و**`public_html/index.php`** بنفس الهيكلة الموضحة أعلاه.

---

**User**

كده صح؟
أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات

متقدم
عودة
الإعدادات وإعادة النشر
سيتم تطبيق الإعدادات على عمليات النشر القادمة
ملفات المصدر
قم بتحميل ملفات تطبيقك
اسحب وأفلت أو حمّل الملفات المدعومة:

.zip، .tar.gz، .tgz


تحميلNo file chosen
تكوين البناء

إعداد مسبق للإطار
Vite
إصدار Node
22.x
الدليل الجذر

eagle-academy-main

إعدادات البناء والإخراج

أمر البناء
*
npm run build
أمر بناء مشروعك للإنتاج.
مدير الحُزَم
*
npm
أداة لإدارة تبعيات المشروع.
دليل الإخراج
*
public
المجلد الذي توجد فيه ملفاتك المُنشأة.
متغيرات البيئة

مفتاح

قيمة

APP_KEY
base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI=

APP_NAME
Eagle Academy

APP_ENV
production

APP_DEBUG
True

APP_URL
https://eagleacademy.site

LOG_CHANNEL
stack

LOG_LEVEL
error

DB_CONNECTION
mysql

DB_HOST
127.0.0.1

DB_PORT
3306

DB_DATABASE
u123456789_eagle

DB_USERNAME
u123456789_eagle

BROADCAST_CONNECTION
log

FILESYSTEM_DISK
local

SESSION_DRIVER
database

SESSION_LIFETIME
120

SESSION_ENCRYPT
false

SESSION_PATH
/

SESSION_DOMAIN
null

CACHE_STORE
database

QUEUE_CONNECTION
database

MAIL_MAILER
log

MAIL_FROM_ADDRESS
hello@example.com

MAIL_FROM_NAME
${APP_NAME}

VITE_APP_NAME
${APP_NAME}


أضف المزيد

استيراد env.

حفظ وإعادة نشر


---

**Cursor**

في الإعداد اللي أرسلته فيه **عدّة نقاط لازم تتظبط** — مش كله صح كما هو.

## ما هو خطأ أو خطير

### 1) قاعدة البيانات
- **`DB_DATABASE`** و **`DB_USERNAME`** = **`u123456789_eagle`** → ده **مثال من التوثيق**، مش اسم حسابك.
- على Hostinger الحقيقي عندك **`u358087675`**؛ لازم القيم تكون **نفس اللي في لوحة قواعد البيانات** (مثلًا `u358087675_admin` لو ده الاسم الكامل للقاعدة والمستخدم عندك).
- **مفيش `DB_PASSWORD`** في القائمة → بدونها اتصال MySQL **يفشل** وغالبًا **500**.

### 2) الإنتاج والأمان
- **`APP_DEBUG` = True** على الإنتاج **غير مناسب** (قد يكشف أخطاء وتفاصيل للزوار). خليه **`false`** بعد ما يشتغل الموقع.

### 3) دليل الإخراج مع Laravel + Vite
- مع Laravel والـ Vite plugin، ناتج البناء يكون في **`public/build`** (الـ manifest والـ JS/CSS).
- أنت حاطط **`public`** كمجلد إخراج؛ ده يختلف عن اللي نجح معاك قبل كده في السجلات (**`public/build`**).
- لو واجهة Hostinger تقصد «مجلد الأصول بعد البناء»، الأقرب لمشروعك هو **`public/build`** وليس **`public`** كاملًا.

### 4) نوع النشر (مهم)
- الإعداد المسبق **Vite** مناسب لبناء الواجهة؛ مشروعك **Laravel + PHP** يحتاج كمان **`vendor`** ويشغّل من **`public`** في مسار السيرفر الصحيح.
- لو النظام بعد البناء ينشر **مجلد الإخراج فقط** على الموقع، قد **لا يُرفَع** الجزء الخارجي (`vendor`, `app`, …) → يظل **500**.
- الأسلوب الآمن اللي اتفقنا عليه: رفع **`eagle-academy.zip`** من **مدير الملفات**، فك الضغط بجانب **`public_html`**, ونسخ **محتويات `public`** إلى **`public_html`** بحيث **`vendor`** يكون في المجلد الأب كما في **`index.php`**.

## اللي يكون «صح» تقريبًا
- **`npm run build`**، **Node 22**، وجذر **`eagle-academy-main`** طالما اسم المجلد بعد فك الـ zip فعلًا **`eagle-academy-main`** (لو الاسم مختلف، غيّر الحقل ليطابق الواقع).
- **`APP_KEY`**, **`APP_URL`**, وباقي متغيرات Laravel غالبًا مقبولة بعد تصحيح DB وإضافة كلمة مرور القاعدة.

---

**خلاصة:** لسه **مش صح** كاملًا لحد ما تصلح **`DB_DATABASE` / `DB_USERNAME`** إلى قيم **Hostinger الحقيقية**، تضيف **`DB_PASSWORD`**, تخفّض **`APP_DEBUG`**, وتتأكد من **سيناريو الرفع** (يدوي بجانب `public_html` أو إعداد إخراج **لا يقطع مشروع Laravel عن `vendor`**).  

لو حابب، بعد التعديل انسخ قائمة المتغيرات **بدون كلمات السر** واكتب أيضًا: هل الاسم بعد فك الـ zip **`eagle-academy-main`** فعلًا ولا اسم تاني؟

---

**User**

إعدادات البناء والإخراج

أمر البناء
*
npm run build
أمر بناء مشروعك للإنتاج.
مدير الحُزَم
*
npm
أداة لإدارة تبعيات المشروع.
دليل الإخراج
*
public
المجلد الذي توجد فيه ملفاتك المُنشأة.


---

**Cursor**

لا — لمشروع Laravel مع **Vite + Laravel plugin** الإعداد الأدق لـ **«دليل الإخراج»** يكون:

## **`public/build`**

### لماذا؟
- **`npm run build`** يشغّل **Vite**، والنتيجة تكون **`manifest.json`** والملفات في **`public/build/assets/`** (هذا هو مجلد «البناء» الفعلي).
- مجلد **`public`** كاملًا فيه **`index.php`** وملفات ثابتة؛ هو ليس «مجلد إخراج البناء» بالمعنى الذي تستخدمه Hostinger بعد `vite build`.

### متى يكون `public` غالبًا غلط هنا؟
- لو لوحة Hostinger تتحقق بعد البناء من وجود ملفات في المجلد الذي تختاره، اختيار **`public`** قد يبدو يعمل أحيانًا لأن المجلد موجود أصلًا، لكن المعيار الصحيح لمخرجات **Vite** في Laravel هو **`public/build`** — وهو نفس اللي ظهر في سجلاتك الناجحة سابقًا (`public/build/manifest.json`).

**الخلاصة:** اضبط **دليل الإخراج** على **`public/build`** واحتفظ بـ **`npm run build`** و **`npm`** كما هما.

---

**User**

أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات

متقدم
عمليات النشر
تفاصيل النشر
النشر من ملفات المصدر

حاضِر
eagleacademy.site

الإعدادات وإعادة النشر

جميع عمليات النشر
ولاية:

مكتمل

تم نشره:

2026-05-11 16:22

•

41s

ملف:

eagle-academy.zip

دليل الجذر:

eagle-academy

نطاق:

Vite

إعدادات البناء والإخراج:

مخصص

إصدار العقدة:

22.x

إنشاء سجلات
الخطوط: 19

سجلات البحث



1

added 85 packages, and audited 86 packages in 2s

2


3

22 packages are looking for funding

4

run `npm fund` for details

5


6

found 0 vulnerabilities

7


8

> build

9

> vite build

10


11

vite v7.3.3 building client environment for production...

12

transforming...

13

✓ 54 modules transformed.

14

rendering chunks...

15

computing gzip size...

16

public/build/manifest.json 0.33 kB │ gzip: 0.16 kB

17

public/build/assets/app-BO-mN2bL.css 35.72 kB │ gzip: 8.68 kB

18

public/build/assets/app-CcNNqum8.js 42.06 kB │ gzip: 16.53 kB

19

✓ built in 508ms



---

**Cursor**

نعم، **سجل البناء سليم**.

- **`npm run build` → `vite build`** اكتمل بدون أخطاء.
- الملفات ظهرت في **`public/build`** (`manifest.json` + الأصول) وهذا هو المطلوب لمشروع Laravel مع Vite.

**تذكير سريع:** «اكتمال النشر» في هذه الشاشة يعني غالبًا أن **خطوة Node/Vite** نجحت. تشغيل الموقع على **`https://eagleacademy.site`** ما يزال يعتمد على:

1. وجود **`vendor`** وملفات Laravel في المسار الصحيح بجانب **`public_html`** (أو كما رتّبتَها على السيرفر).
2. **متغيرات البيئة** الصحيحة، منها **`DB_PASSWORD`** وأسماء القاعدة/المستخدم الحقيقية (ليست **`u123456789_eagle`** إلا إذا كان هذا اسمك الفعلي في لوحة القواعد).
3. **`php artisan migrate --force`** إن كانت الجلسات/الكاش على قاعدة البيانات.

لو الصفحة ما زالت تعطي خطأ، افتح **`storage/logs/laravel.log`** على الاستضافة أو جرّب الموقع في المتصفح وقل النتيجة (200، 500، إلخ).

---

**User**

403
Forbidden
Access to this resource on the server is denied!

---

**Cursor**

**403 Forbidden** يعني السيرفر وصل للمسار لكن **رفض السماح بالعرض** — غالبًا إعداد المسار/الصلاحيات وليس خطأ PHP مثل 500.

## تحقق بالترتيب

### 1) وجود الملف الصحيح في جذر الموقع
افتح **الملفات** → **`public_html`** (أو جذر الدومين الذي يشير إليه الموقع).

- لازم يوجد **`index.php`** (ملف Laravel من مجلد `public`).
- لو **`public_html`** فيه مجلدات فقط (`build`, `css`…) **بدون `index.php`** → غالبًا **403** أو صفحة فارغة.

**الحل:** انسخ **كل محتويات** مجلد **`public`** من مشروع Laravel إلى **`public_html`** (منها `index.php` و `.htaccess`).

### 2) ملف **`.htaccess`**
يجب أن يكون **`public_html/.htaccess`** موجودًا (النسخة القادمة من **`public/.htaccess`** في Laravel). بدونها أو مع محتوى خاطئ قد تُرفض الطلبات.

### 3) الصلاحيات (Permissions)
نموذجي على الاستضافة المشتركة:

- المجلدات **755**
- الملفات **644**

خصوصًا **`public_html`** و **`index.php`**.

### 4) ما تفتح مجلدًا مباشرة
لو الرابط مثل `.../storage/` أو مجلد بدون `index`، السيرفر قد يمنع عرض المحتوى (**403**). جرّب **`https://eagleacademy.site/`** فقط.

### 5) لو Document root ليس `public_html`
في بعض الإعدادات يكون الجذر على مجلد المشروع وليس `public`. إما تضبط من لوحة Hostinger **جذر الموقع** على المجلد الذي فيه **`index.php`**، أو تترك الهيكلة: **`vendor` و باقي Laravel** في الأب و **`public_html`** = محتوى `public`.

### 6) نشر Hostinger (Vite فقط)
لو النشر وضع ملفات في مجلد **ليس** هو الذي يعرضه الدومين، أو نشر **مجلد الإخراج فقط** بدون **`index.php`**، يظهر **403**.

---

**خطوة عملية:** من مدير الملفات، تأكد أن **`public_html/index.php`** موجود وحجمه منطقي (ليس ملفًا فارغًا)، وأن **`public_html/.htaccess`** موجود. إن كان **`index.php`** ناقصًا، انسخه من مجلد **`public`** في مشروعك وأعد التحميل.

لو تحب، اذكر: هل **`public_html`** فيه **`index.php`** الآن (نعم/لا)؟

---

**User**

personu358087675
folderMy files
create_new_folderNew folder
note_addNew file
deleteTrash bin
Space

0.55%
282.06 MiB / 50 GiB

Inodes

2.06%
12365 / 600000
exit_to_appLogout
File Browser v2.63.2-h2
Help

home
keyboard_arrow_right
...
keyboard_arrow_right
eagleacademy.site
keyboard_arrow_right
public_html
keyboard_arrow_right
.htaccess
close
.htaccess
add
14px
remove
save
home
keyboard_arrow_right
...
keyboard_arrow_right
eagleacademy.site
keyboard_arrow_right
public_html
keyboard_arrow_right
.htaccess
content_copycontent_cutcontent_pastemore_vert
</IfModule>
RewriteRule ^\.builds - [F,L]


1234567891011121314151617181920212223242526
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>
    RewriteEngine On
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
RewriteRule ^\.builds - [F,L]


---

**Cursor**

الملف الحالي تالف: يبدأ بـ `</IfModule>` دون فتح، وهناك قواعد `.builds` مكررة وخارج السياق. جلب النسخة الصحيحة من المشروع:



نعم — الملف عندك **معطوب**: ظهور **`</IfModule>` في البداية** يعني أن جزءًا من أول الملف **اختفى أو انقلب ترتيبه**، وهذا قد يسبب سلوكًا غريبًا مع **403**.

انسخ **`public_html/.htaccess`** بالكامل والصق هذا المحتوى (بديل Laravel القياسي + حظر مجلد `.builds` الخاص بـ Hostinger):

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Hostinger: منع الوصول لمجلد بيانات البناء
    RewriteRule ^\.builds(/|$) - [F,L]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

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

**مهم:**

1. احذف أي **`</IfModule>`** أو **`RewriteRule ^\.builds`** **خارج** هذا الكتلة أو في أول الملف.
2. احفظ الملف ثم جرّب الموقع من جديد.

إذا بقي **403** بعد الإصلاح، راجع أن **`index.php`** موجود في **نفس** مجلد **`public_html`** وأن **`vendor`** موجود في المجلد **الأعلى** كما في مسارات Laravel (`../vendor`).

---

**User**

personu358087675
folderMy files
create_new_folderNew folder
note_addNew file
deleteTrash bin
Space

0.55%
282.06 MiB / 50 GiB

Inodes

2.06%
12365 / 600000
exit_to_appLogout
File Browser v2.63.2-h2
Help

home
keyboard_arrow_right
...
keyboard_arrow_right
eagleacademy.site
keyboard_arrow_right
public_html
keyboard_arrow_right
.htaccess
close
.htaccess
add
14px
remove
save
home
keyboard_arrow_right
...
keyboard_arrow_right
eagleacademy.site
keyboard_arrow_right
public_html
keyboard_arrow_right
.htaccess
content_copycontent_cutcontent_pastemore_vert
</IfModule>
RewriteRule ^\.builds - [F,L]


12345678910111213141516171819202122232425262728
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>
    RewriteEngine On
    # Hostinger: منع الوصول لمجلد بيانات البناء
    RewriteRule ^\.builds(/|$) - [F,L]
    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]
    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]
    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>


---

**Cursor**

المشكلة لسه موجودة: **أول الملف** فيه سطران **غلط** وبيزودوا عن الكتلة الصحيحة:

```text
</IfModule>
RewriteRule ^\.builds - [F,L]


```

ودول **لازم يتمسحوا بالكامل** — مفيش قبلهم `<IfModule ...>`، فـ Apache يفسّر الملف غلط.

---

## الحل

1. **امسح كل محتوى** ملف **`public_html/.htaccess`**.
2. **الصق** المحتوى التالي **فقط** (من السطر الأول للأخير، بدون أي شيء قبله أو بعده):

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Hostinger: منع الوصول لمجلد بيانات البناء
    RewriteRule ^\.builds(/|$) - [F,L]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Handle X-XSRF-Token Header
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

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

3. **احفظ** الملف.

بعد الحفظ، الملف لازم **يبدأ** بـ **`<IfModule mod_rewrite.c>`** و**ينتهي** بـ **`</IfModule>`** — ومفيش **`</IfModule>`** في أول الملف ولا **`RewriteRule`** قبل فتح الـ `IfModule`.

جرّب الموقع تاني؛ لو لسه في مشكلة، الخطوة اللي بعدها تكون التأكد من **`index.php`** ووجود **`vendor`** في المسار الصحيح فوق **`public_html`**.

---

**User**

personu358087675
folderMy files
create_new_folderNew folder
note_addNew file
deleteTrash bin
Space

0.55%
282.12 MiB / 50 GiB

Inodes

2.06%
12369 / 600000
exit_to_appLogout
File Browser v2.63.2-h2
Help

home
keyboard_arrow_right
...
keyboard_arrow_right
.builds
keyboard_arrow_right
config
keyboard_arrow_right
.env
close
.env
add
14px
remove
save
home
keyboard_arrow_right
...
keyboard_arrow_right
.builds
keyboard_arrow_right
config
keyboard_arrow_right
.env
content_copycontent_cutcontent_pastemore_vert
VITE_APP_NAME='${APP_NAME}'
DB_PASSWORD='T:34U+Crhpu'


1234567891011121314151617181920212223242526
APP_KEY='base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI='
APP_NAME='Eagle Academy'
APP_ENV='production'
APP_DEBUG='True'
APP_URL='https://eagleacademy.site'
LOG_CHANNEL='stack'
LOG_LEVEL='error'
DB_CONNECTION='mysql'
DB_HOST='127.0.0.1'
DB_PORT='3306'
DB_DATABASE='u123456789_eagle'
DB_USERNAME='u123456789_eagle'
BROADCAST_CONNECTION='log'
FILESYSTEM_DISK='local'
SESSION_DRIVER='database'
SESSION_LIFETIME='120'
SESSION_ENCRYPT='false'
SESSION_PATH='/'
SESSION_DOMAIN='null'
CACHE_STORE='database'
QUEUE_CONNECTION='database'
MAIL_MAILER='log'
MAIL_FROM_ADDRESS='hello@example.com'
MAIL_FROM_NAME='${APP_NAME}'
VITE_APP_NAME='${APP_NAME}'
DB_PASSWORD='T:34U+Crhpu'


---

**Cursor**

## تحذير أمني فوري

لقد ظهرت في رسالتك **كلمة مرور قاعدة البيانات** ضمن ملف البيئة. اعتبرها **مسربة** وغيّرها من لوحة **قواعد البيانات** في Hostinger، ثم حدّث **`DB_PASSWORD`** في كل مكان تستخدمه فيه (متغيرات البيئة / ملف البيئة). لا تعِد نشر كلمات السر هنا.

---

## مشاكل في المحتوى اللي أرسلته

### 1) قاعدة البيانات
- **`DB_DATABASE`** و **`DB_USERNAME`** ما زالا **`u123456789_eagle`** — هذا **مثال وليس حسابك**.
- على حسابك الفعلي المعرف غالبًا **`u358087675`**. استخدم **بالضبط** الاسمين اللي يظهران في **قواعد البيانات → قائمة القواعد والمستخدمين** (مثل `u358087675_admin` إن كان هذا اسم القاعدة والمستخدم عندك).

### 2) الإنتاج
- **`APP_DEBUG='True'`** على الإنتاج غير مناسب؛ بعد ما يشتغل الموقع خليه **`false`**.

### 3) القيم الحرفية
- **`SESSION_DOMAIN='null'`** قد تُقرأ كنص وليس كقيمة فارغة؛ إن احتجت تعطيل النطاق للكوكيز، أفرغ الحقل أو احذف المتغير حسب ما تسمح به الواجهة.
- **`MAIL_FROM_NAME`** و **`VITE_APP_NAME`** مع **`${APP_NAME}`** قد لا يُستبدل دائمًا في كل السياقات؛ الأبسط أن تكتب **`Eagle Academy`** مباشرة إن لاحظت مشاكل.

### 4) أين يقرأ Laravel البيئة؟
الملف **`.../.builds/config/.env`** غالبًا **خاص بنشر Hostinger** وليس بالضرورة نفس ملف **`eagleacademy.site/public_html/../.env`** الذي يستخدمه Laravel في التشغيل اليومي.

تأكد أن إعداداتك موجودة أيضًا في:
- **لوحة الموقع → متغيرات البيئة**، و/أو  
- ملف **`.env`** في **جذر مشروع Laravel** (بجانب **`vendor`** و **`artisan`**)، وليس فقط داخل **`.builds`**.

---

**الخطوات العملية:** (1) تدوير كلمة مرور قاعدة البيانات، (2) تصحيح **`DB_DATABASE`** و **`DB_USERNAME`** إلى القيم الحقيقية من لوحة Hostinger، (3) تحديث **`DB_PASSWORD`** بعد التدوير، (4) **`APP_DEBUG=false`** بعد التأكد أن كل شيء يعمل.

---

**User**

أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات

متقدم
مواقع إلكترونية
eagleacademy.site
متغيرات بيئة
متغيرات بيئة

استيراد env.

أضف متغير بيئة
البحث

إخفاء جميع القيم
مفتاح
قيمة
إجراءات
APP_KEY

base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI=


APP_NAME

Eagle Academy


APP_ENV

production


APP_DEBUG

True


APP_URL

https://eagleacademy.site


LOG_CHANNEL

stack


LOG_LEVEL

error


DB_CONNECTION

mysql


DB_HOST

127.0.0.1


DB_PORT

3306


DB_DATABASE

u123456789_eagle


DB_USERNAME

u123456789_eagle


BROADCAST_CONNECTION

log


FILESYSTEM_DISK

local


SESSION_DRIVER

database


SESSION_LIFETIME

120


SESSION_ENCRYPT

false


SESSION_PATH

/


SESSION_DOMAIN

null


CACHE_STORE

database


QUEUE_CONNECTION

database


MAIL_MAILER

log


MAIL_FROM_ADDRESS

hello@example.com


MAIL_FROM_NAME

${APP_NAME}


VITE_APP_NAME

${APP_NAME}


DB_PASSWORD

T:34U+Crhpu


حجم الصفحة:
75
1
إلى
26
من
26

صفحة
1
من
1

أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات
إدارة
phpMyAdmin
MySQL عن بعد

متقدم
مواقع إلكترونية
eagleacademy.site
قواعد البيانات
PHPMyAdmin
PHPMyAdmin
يمكنك الآن الوصول مباشرةً إلى لوحة تحكم phpMyAdmin باستخدام هذا الرابط ، مما يوفر عليك وعلى مطوري موقعك عناء التنقل عبر لوحة تحكم hPanel كلما احتجت إلى تعديل قاعدة بياناتك. يرجى العلم أنه لتسجيل الدخول باستخدام رابط قاعدة البيانات، سيحتاج المستخدمون إلى استخدام اسم قاعدة البيانات وكلمة المرور الخاصة بهم. تعرّف على المزيد

قائمة قواعد البيانات الحالية
قاعدة بيانات MySQL
مستخدم MySQL
إجراء
u358087675_admin	
u358087675_admin	

دخول phpMyAdmin
أحل واكسب إلى غاية $205$

اسأل





الصفحة الرئيسية

مواقع إلكترونية

دومينات

Horizons

رسائل البريد الإلكتروني

Reach

التجارة الإلكترونية

VPS

OpenClaw

وكلاء

الفواتير

المزيد من الخدمات

API

مشاركة الحساب
اسم الموقع
eagleacademy.site
البحث
لوحة التحكم

عمليات النشر

متغيرات بيئة

سجلات وقت التشغيل

خطة الاستضافة

الأداء

التحليلات

الحماية

دومينات

الملفات

قواعد البيانات
إدارة
phpMyAdmin
MySQL عن بعد

متقدم
مواقع إلكترونية
eagleacademy.site
قواعد البيانات
إدارة
إدارة
إنشاء قاعدة بيانات MySQL و مستخدم قاعدة بيانات جديدين
إسم قاعدة البيانات MySQL
u358087675_
اسم قاعدة البيانات
إسم المستخدم MySQL
u358087675_
admin
كلمة المرور
eOU$+j5Y

الحد الأدنى 8 من الحروف
يجب أن تحتوي على الأقل على حرف صغير واحد
يجب أن تحتوي على الأقل على حرف كبير واحد
يجب أن تحتوي رقما واحد على الأقل

إنشاء
قائمة قواعد بيانات MySQL الحالية والمستخدمين
قاعدة بيانات MySQL
مستخدم MySQL
تاريخ الإنشاء
الموقع الإلكتروني
u358087675_admin
1 MB
u358087675_admin	
2026-05-11
eagleacademy.site

دخول phpMyAdmin

←
phpMyAdmin
Home Log out phpMyAdmin documentation MariaDB Documentation Navigation panel settings Reload navigation panel
RecentFavorites
Collapse all Unlink from main panel
Expand/CollapseDatabase operationsinformation_schema
Expand/CollapseDatabase operationsu358087675_admin
 Server: 127.0.0.1:3306
 Database: u358087675_admin
Structure Structure(current)
SQL SQL
Search Search
Query Query
Export Export
Import Import
Operations Operations
Routines Routines
Events Events
Triggers Triggers
Designer Designer
Page-related settings Click on the bar to scroll to top of page
SQL Query Console Console
ascendingdescendingOrder:Debug SQLExecution orderTime takenOrder by:Group queries
Some error occurred while getting SQL debug info.
OptionsSet default
Always expand query messages
Show query history at start
Show current browsing query
 Execute queries on Enter and insert new line with Shift+Enter. To make this permanent, view settings.
Switch to dark theme
 No tables found in database.
Create new table Create new table
Table name
Number of columns
4
Create
Open new phpMyAdmin window

---

**Cursor**

في اللي أرسلته فيه **ثلاث نقاط حاسمة**:

---

## 1) متغيرات البيئة لا تطابق قاعدة البيانات الحقيقية

في **قواعد البيانات** عندك القاعدة والمستخدم **`u358087675_admin`**، بينما في **متغيرات البيئة** ما زال **`DB_DATABASE`** و **`DB_USERNAME`** = **`u123456789_eagle`**.

**عدّل فورًا إلى:**

| المتغير | القيمة الصحيحة |
|--------|----------------|
| **DB_DATABASE** | `u358087675_admin` |
| **DB_USERNAME** | `u358087675_admin` |
| **DB_PASSWORD** | كلمة مرور المستخدم **`u358087675_admin`** (كما عرّفتها عند إنشاء المستخدم في Hostinger) |

لو خلّيت **`u123456789_eagle`** والاتصال يذهب لقاعدة غير موجودة أو مستخدم غير مطابق → فشل اتصال وغالبًا **500**.

---

## 2) قاعدة البيانات **فارغة** — لازم تشغيل الهجرات

في **phpMyAdmin** يظهر **No tables found**. مشروعك يستخدم **`SESSION_DRIVER=database`** و **`CACHE_STORE=database`**، فيحتاج جداول (`sessions`, `cache`, `jobs`, … وجداول التطبيق).

على السيرفر (SSH أو Terminal في Hostinger إن وُجد)، من **جذر Laravel** (حيث يوجد **`artisan`**):

```bash
php artisan migrate --force
```

بعدها ارجع لـ phpMyAdmin وستجد الجداول.

---

## 3) إعدادات أخرى

- **`APP_DEBUG`**: بعد ما يثبت الموقع، خليه **`false`** في الإنتاج.
- **`APP_KEY`** الذي يظهر في لوحة المتغيرات: تجنّب نشره في محادثات عامة؛ لو ظهر في أماكن غير موثوقة، يفضّل توليد مفتاح جديد وتحديثه في اللوحة.

---

## أمان

لقد ظهرت في المحادثة **كلمات مرور**. الأفضل **تغيير كلمة مرور مستخدم MySQL** من لوحة Hostinger وتحديث **`DB_PASSWORD`** في المتغيرات، وعدم إرسال الأسرار في الدردشة مرة أخرى.

---

**الخلاصة:** صحّح **`DB_DATABASE`** و **`DB_USERNAME`** إلى **`u358087675_admin`**، تأكد أن **`DB_PASSWORD`** هي كلمة مرور **هذا المستخدم**، ثم نفّذ **`php artisan migrate --force`**. بدون الجداول سيظل التطبيق يفشل رغم صحة باقي الإعدادات.

---

**User**

غيرها للصح عشان اعملها كوبي 
personu358087675
folderMy files
create_new_folderNew folder
note_addNew file
deleteTrash bin
Space

0.55%
282.12 MiB / 50 GiB

Inodes

2.06%
12369 / 600000
exit_to_appLogout
File Browser v2.63.2-h2
Help

home
keyboard_arrow_right
...
keyboard_arrow_right
.builds
keyboard_arrow_right
config
keyboard_arrow_right
.env
close
.env
add
14px
remove
save
home
keyboard_arrow_right
...
keyboard_arrow_right
.builds
keyboard_arrow_right
config
keyboard_arrow_right
.env
content_copycontent_cutcontent_pastemore_vert
VITE_APP_NAME='${APP_NAME}'
DB_PASSWORD='T:34U+Crhpu'


1234567891011121314151617181920212223242526
APP_KEY='base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI='
APP_NAME='Eagle Academy'
APP_ENV='production'
APP_DEBUG='True'
APP_URL='https://eagleacademy.site'
LOG_CHANNEL='stack'
LOG_LEVEL='error'
DB_CONNECTION='mysql'
DB_HOST='127.0.0.1'
DB_PORT='3306'
DB_DATABASE='u123456789_eagle'
DB_USERNAME='u123456789_eagle'
BROADCAST_CONNECTION='log'
FILESYSTEM_DISK='local'
SESSION_DRIVER='database'
SESSION_LIFETIME='120'
SESSION_ENCRYPT='false'
SESSION_PATH='/'
SESSION_DOMAIN='null'
CACHE_STORE='database'
QUEUE_CONNECTION='database'
MAIL_MAILER='log'
MAIL_FROM_ADDRESS='hello@example.com'
MAIL_FROM_NAME='${APP_NAME}'
VITE_APP_NAME='${APP_NAME}'
DB_PASSWORD='T:34U+Crhpu'


---

**Cursor**

تصحيح الملف للنسخ: استخدم **`u358087675_admin`** لقاعدة البيانات والمستخدم حسب لوحة Hostinger. لا نضع كلمة مرور حقيقية هنا — استبدل **`ضع_كلمة_مرور_قاعدة_البيانات_هنا`** بكلمة المرور من لوحة التحكم (قواعد البيانات).



فيما يلي نسخة **مصحّحة** للنسخ إلى ملف `.env` أو إلى **متغيرات البيئة**. احذف الأسطر المكررة في الملف الحالي (أول سطرين قبل `APP_KEY`)، واحذف **`DB_PASSWORD` المكررة** في الأسفل.

**مهم:** استبدل `ضع_كلمة_مرور_mysql_هنا` بكلمة مرور المستخدم **`u358087675_admin`** كما هي في لوحة **قواعد البيانات** (لا أضع كلمة مرورك الحقيقية هنا).

```env
APP_KEY=base64:czyVgNFm9rDFz5bIgYpudhUxjjaWT6SbJVGrQWJt8kI=
APP_NAME=Eagle Academy
APP_ENV=production
APP_DEBUG=false
APP_URL=https://eagleacademy.site

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=u358087675_admin
DB_USERNAME=u358087675_admin
DB_PASSWORD=ضع_كلمة_مرور_mysql_هنا

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME=Eagle Academy

VITE_APP_NAME=Eagle Academy
```

**ما الذي تغيّر عن ملفك؟**

| قبل | بعد |
|-----|-----|
| `DB_DATABASE=u123456789_eagle` | `u358087675_admin` |
| `DB_USERNAME=u123456789_eagle` | `u358087675_admin` |
| `APP_DEBUG=True` | `false` |
| `SESSION_DOMAIN='null'` | حُذف (لا حاجة للنص `null`) |
| `MAIL_FROM_NAME` / `VITE_APP_NAME` مع `${APP_NAME}` | `Eagle Academy` نصًا لتجنب مشاكل الاستبدال |
| سطران زائدان أول الملف + `DB_PASSWORD` مرتين | كتلة واحدة نظيفة |

تم أيضًا تحديث **`/.hostinger.env.example`** في المشروع ليطابق أسماء القاعدة والمستخدم **`u358087675_admin`** كمرجع.

بعد اللصق على السيرفر شغّل من جذر Laravel: **`php artisan migrate --force`** لأن القاعدة كانت بلا جداول.

