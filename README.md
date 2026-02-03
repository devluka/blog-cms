# Vertex Blog CMS

Vertex is a modern, high-performance content management system built for developers who value aesthetics and speed. Featuring a minimalist, high-contrast design inspired by top-tier tech blogs, it comes with a fully responsive layout, a powerful admin dashboard, and minimalistic layout.

## **Features**

### **Frontend & UI**

- **Tailwind CSS:** Utilizes latest tailwind css v4.0 which is framework optimized.

- **Dynamic Hero Section:** Automatically highlights the latest post with a split-layout design.

- **Smart Fallbacks:** Posts without images generate professional gradient placeholders automatically.

- **Reading Experience:** - Sticky Reading Progress Bar.

- **"Copy Link"** Enables users to share blog post links.

- **"Read Next"** recommendation engine based on category context.

- **Search**: Real-time filtered search for posts and mobile-optimized search bar.

## **Backend & Admin**

- **Dashboard Stats:** At-a-glance view of Total Posts, Published Articles, and Drafts.

- **Content Management**: Create, Edit, and Delete posts with rich text integration (TinyMCE).

- **Organization:** Robust Category and Tagging system (Many-to-Many relationships).

- **Image Optimization:** Handles uploads and symbolic linking via Laravel Storage.
                          Smartly changes images to webp for better web perfomance.

- **SEO Features:** Displays SEO scores when creating and editing posts to reduce hassle on
                    publish

### **Admin navigation urls**

| URL | Page |
|---|---|
| /login | Login page |
| /register | Register page |
| /dashboard | Dashboard page |

**Disclaimer:** On production the /register url can be ommitted from **/routes/auth.php** if not needed
to prevent unwanted authorized access to the system.

## **Installation Guide**

Follow these steps to set up Vertex locally.

**1. Clone the Repository**
```bash
git clone https://github.com/devluka/blog-cms.git
cd blog-cms
```

**2. Install Dependencies**

Install PHP and Node packages.
```bash
composer install
npm install
```

**3. Environment Setup**

Copy the example environment file and configure your database.
```bash
cp .env.example .env
```
Have a MySQL server running (XAMPP recommended)
Open .env and configure your database credentials:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blog_db
DB_USERNAME=root
DB_PASSWORD=
```

**4. Application Setup**

Generate the app key and link the storage folder (Crucial for images to work).
```bash
php artisan key:generate
php artisan storage:link
```

**5. Database Migration**

Create the tables and pivot tables.
```bash
php artisan migrate
```

**6. Build Assets**

Compile Tailwind CSS and JS.
```bash
npm run build
```

## **Running the App**

To run the application locally, you need to keep two terminal windows open:

Terminal 1: Laravel Server
```bash
php artisan serve
```

Terminal 2: Vite (Hot Reloading for Styles)
```bash
npm run dev
```

Visit [http://localhost:8000](http://localhost:8000) to view the site.

## **Project Structure Highlights**

+ **app/Http/Controllers/BlogController.php:** Handles public-facing logic (Index, Show, Category filtering, Recommendations).

+ **app/Http/Controllers/PostController.php:** Admin logic for creating/editing posts and handling image uploads.

+ **resources/views/layouts/blog-layout.blade.php:** The master layout containing the sticky nav, footer, and dark mode logic.

+ **resources/views/blogs/index.blade.php:** Displays all latest posts.

+ **resources/views/blogs/show.blade.php:** Displays individuals posts. 

+ **resources/views/posts/create.blade.php:** Create new posts.

+ **resources/views/posts/edit.blade.php:** Edit existing posts. 

+ **tailwind.config.js:** Slight adjustments for styling one.

## **Contributing**

Contributions are welcome! Please fork the repository and submit a pull request.

## **License**

This project is open-sourced software licensed under the MIT license.
