
# Wallpaper-Tank-App
A wallpaper management system in server-side and show on android application

 - Server-side have admin and admin can add,edit or delete any wallpaper or category
 - Server-side have public home page to users seen,like and download wallpapers
 - Server-side collect views count,download and like count
 - Server-side have search feature in wallpapers
 - Serve-side have API (5 public & 5 private need Authentication)
 - Android-app have Material UI/UX Design
 - Andoird-app have Light and Dark theme
 - Android-app get data from server with `Retrofit` library
 - Users in Android-app can like wallpapers
 - Android-app collect views count and download count and sent to the Server-side
 - Fullscreen mode to view full size wallpaper
 - If android version of user device `7.0` or above app can set wallpaper in device automaticly
 - Android-app can save wallpaper in gallery
 - Google firebase cloud messaging and Google analytics used
 
# Run published version
Public server-side: https://wallpaper.amirsobhan.ir
Public android version: (https://github.com/a1383n/Wallpaper-Tank-App/releases)
(Android 4.4 and above )

## How to run server-side

 1. Rename `.env.example` file to `.env`inside project root and fill the database information.
 2. Open the console and cd your in project root directory
 3. Run `composer install`
 4. Run  `php artisan key:generate`
 5. Run  `php artisan migrate`
 6. Run  `php artisan db:seed`  to run seeders.
 7. Run  `php artisan serve`

Admin panel location:`http://{APP_URL}/admin`
Demo login information:
Email: `demo@email.com`
Password: `demo`

## How to run android-app

 1. Sync `PRIVATE_KEY` value in server-side with config file in `Firebase/Config.java`
 2. Change `BASE_URL` with `http://{APP_URL}/api` in `Retrofit/RetrofitClient.java` file
 
