Vertex Blog CMS
===============

**Vertex** is a modern, high-performance content management system built for developers who value aesthetics and speed. Featuring a minimalist, high-contrast design inspired by top-tier tech blogs, it comes with a fully responsive layout, a powerful admin dashboard, and system-aware dark mode.

Features
--------

### **Frontend & UI**

*   **Dual Typography System:** _Inter_ for UI clarity and _Merriweather_ for comfortable long-form reading.
    
*   **Smart Dark Mode:** Automatically syncs with system preferences, with a manual override saved to LocalStorage.
    
*   **Dynamic Hero Section:** Automatically highlights the latest post with a split-layout design.
    
*   **Smart Fallbacks:** Posts without images generate professional gradient placeholders automatically.
    
*   **Reading Experience:** - Sticky Reading Progress Bar.
    
    *   "Copy Link" micro-interaction.
        
    *   "Read Next" recommendation engine based on category context.
        

### 🛠 **Backend & Admin**

*   **Dashboard Stats:** At-a-glance view of Total Posts, Published Articles, and Drafts.
    
*   **Content Management:** Create, Edit, and Delete posts with rich text integration (TinyMCE).
    
*   **Organization:** Robust Category and Tagging system (Many-to-Many relationships).
    
*   **Image Optimization:** Handles uploads and symbolic linking via Laravel Storage.
    
*   **Search:** Real-time filtered search for posts and mobile-optimized search bar.
    

Screenshots
-----------

**Light Mode**

**Dark Mode**

Installation Guide
------------------

Follow these steps to set up Vertex locally.

### 1\. Clone the Repository

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   git clone [https://github.com/yourusername/vertex-cms.git](https://github.com/yourusername/vertex-cms.git)  cd vertex-cms   `

### 2\. Install Dependencies

Install PHP and Node packages.

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   composer install  npm install   `

### 3\. Environment Setup

Copy the example environment file and configure your database.

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   cp .env.example .env   `

Open .env and configure your database credentials:

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   DB_CONNECTION=mysql  DB_HOST=127.0.0.1  DB_PORT=3306  DB_DATABASE=vertex_blog  DB_USERNAME=root  DB_PASSWORD=   `

### 4\. Application Setup

Generate the app key and link the storage folder (**Crucial for images to work**).

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan key:generate  php artisan storage:link   `

### 5\. Database Migration

Create the tables and pivot tables.

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan migrate   `

### 6\. Build Assets

Compile Tailwind CSS and JS.

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   npm run build   `

 Running the App
---------------------

To run the application locally, you need to keep two terminal windows open:

**Terminal 1: Laravel Server**

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   php artisan serve   `

**Terminal 2: Vite (Hot Reloading for Styles)**

Plain textANTLR4BashCC#CSSCoffeeScriptCMakeDartDjangoDockerEJSErlangGitGoGraphQLGroovyHTMLJavaJavaScriptJSONJSXKotlinLaTeXLessLuaMakefileMarkdownMATLABMarkupObjective-CPerlPHPPowerShell.propertiesProtocol BuffersPythonRRubySass (Sass)Sass (Scss)SchemeSQLShellSwiftSVGTSXTypeScriptWebAssemblyYAMLXML`   npm run dev   `

Visit http://localhost:8000 to view the site.

Project Structure Highlights
----------------------------

*   **app/Http/Controllers/BlogController.php**: Handles public-facing logic (Index, Show, Category filtering, Recommendations).
    
*   **app/Http/Controllers/PostController.php**: Admin logic for creating/editing posts and handling image uploads.
    
*   **resources/views/layouts/blog-layout.blade.php**: The master layout containing the sticky nav, footer, and dark mode logic.
    
*   **tailwind.config.js**: Custom configuration for fonts (Inter/Merriweather) and dark mode class strategy.
    

Contributing
------------

Contributions are welcome! Please fork the repository and submit a pull request.

License
-------

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
