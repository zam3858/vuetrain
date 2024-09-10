### Laravel and Vue.js

#### 1. Introduction to Laravel and Vue.js
- **Overview of Laravel's Architecture and Vue.js**
  - Laravel is a PHP framework based on MVC (Model-View-Controller), designed for building modern web applications with clean syntax and a structured approach to routing, authentication, database migrations, and testing.
  - Vue.js is a progressive JavaScript framework used for building interactive UIs. It is often used as a frontend layer for Laravel applications, providing reactive and dynamic interfaces while Laravel handles backend logic.
  
- **Benefits of Using Vue.js with Laravel**
  - **Seamless Frontend Integration**: Vue.js integrates easily with Laravel's Blade templates, allowing developers to progressively enhance applications without reworking the entire stack.
  - **Reactive Interfaces**: Vue enables reactive UI components, providing real-time, responsive feedback to user interactions without a full-page reload.
  - **Component-Based Architecture**: Vue’s component system matches Laravel’s MVC architecture, enabling easy breakdown and management of large applications.
  - **Single-Page Application (SPA) Support**: By combining Laravel for the backend and Vue.js for the frontend, developers can easily build SPAs that deliver rich user experiences.

#### 2. Setting Up the Environment
- **Installing Laravel (Version 11)**
  - Begin by installing the latest stable version of Laravel via Composer: 

  ```bash 
  	composer create-project --prefer-dist laravel/laravel project-name
  ```

  - Set up necessary configurations such as `.env` variables and database settings.

- **NVM**
  - Installing NPM via NVM is recommended to support multiple NPM version on development server
  - Follow instruction from here [NVM windows](https://github.com/coreybutler/nvm-windows) 
  
- **Setting Up Vue.js (Including Upgrade from Vue 2 to Vue 3)**
  - Install Vue via npm: `npm install vue@latest vue-router@latest @vitejs/plugin-vue`
  - For applications upgrading from Vue 2 to Vue 3, ensure compatibility by updating dependencies and replacing Vue 2-specific syntax with the new Composition API.

- **Handling NPM Dependencies and Resolving Issues**
  - After installing Vue.js, handle project dependencies using npm: `npm install` or `npm run dev` for development builds.
  - Address common npm issues such as permission errors or package conflicts by clearing npm cache (`npm cache clean --force`) or upgrading outdated packages.

#### 3. Integrating Vue.js with Laravel
- **Setting Up Laravel Vite for Asset Compilation**
  - Laravel Mix simplifies asset compilation, bundling Vue files, JavaScript, and styles. Add Vue support by configuring `vite.config.js`: 
    
    ```javascript
     plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                }
            }
        })
    ],
    ```
  - Run the asset compiler using `npm run dev` for development or `npm run production` for a minified production build.

  **Preparing Laravel Backend to Handle Vue Pages**

  - Create controller to handle request for Vue Pages

  ```bash
  	php artisan make:controller ApplicationController
  ```

  - Open the controller and add in the code

  ```php
  public function __invoke()
  {
  	return view('view.layouts.app');
  }

  ```

  - The content of the page should be so

```php
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id='app'></div>
    </body>
</html>

```

 - Create Route rule to map request to ApplicationController

```php
	// in web.php
	Route::get('{view}', ApplicationController::class)->where('view', '(.*)';
```


- **Basic Vue Component Creation and Inclusion in Laravel Views**
  - Create a Vue component under `resources/js/components`,

  ```javascript
	<script setup>
	import { RouterLink, RouterView } from 'vue-router'
	</script>

	<template>
	  <header>
	    
	  </header>
	  <div class="wrapper">
	    <nav>
	        <RouterLink to="/vue">Home</RouterLink>
	        <RouterLink to="/dashboard">Dashboard</RouterLink>
	        <RouterLink to="/users">User</RouterLink>
	    </nav>
	    <RouterView />
	  </div>

	  
	</template>

  ```
  - Register the component in `resources/js/app.js` and import it into a Blade template, allowing Vue to manage that section of the UI.
  ```


- **Handling Laravel Routing with Vue.js Components**
  - Use Vue Router for frontend routing when creating SPAs. For traditional multi-page applications, include Vue components in Blade views.
  - Define routes in `web.php` for backend routing while allowing Vue Router to handle in-page navigation dynamically.

---

### Afternoon Session: Database Connection and Frontend-Backend Communication

#### 4. Connecting Laravel to MySQL
- **Configuring Laravel for MySQL**
  - Update the `.env` file with the correct database credentials:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=root
    DB_PASSWORD=
    ```
  - Ensure that MySQL is installed and running. You can connect to the database using tools like `php artisan tinker` or MySQL workbench to verify the connection.

- **Running Migrations and Seeders**
  - Use Laravel migrations to create database schema:
    ```bash
    php artisan make:migration create_table_name
    php artisan migrate
    ```
  - Create seeders to populate your database with test data:
    ```bash
    php artisan make:seeder TableSeeder
    php artisan db:seed
    ```

#### 5. Vue.js and Laravel Backend Communication
- **Axios Setup for API Calls**
  - Axios should be preinstalled with Laravel but if it is not, install Axios for handling HTTP requests: `npm install axios`.
  - Axios call for typical CRUD operation is below


```javascript
  //Create new data
  createItem(data) {
  axios.post('/api/items', data)
    .then(response => {
      console.log('Item created:', response.data);
    })
    .catch(error => {
      console.error('Error creating item:', error);
    });
  }

  //get List
  fetchItems() {
  axios.get('/api/items')
    .then(response => {
      console.log('Items fetched:', response.data);
    })
    .catch(error => {
      console.error('Error fetching items:', error);
    });
  }

  // get one item by id
  fetchItem(id) {
  axios.get(`/api/items/${id}`)
    .then(response => {
      console.log('Item fetched:', response.data);
    })
    .catch(error => {
      console.error('Error fetching item:', error);
    });
  }

  // update record
  updateItem(id, updatedData) {
  axios.put(`/api/items/${id}`, updatedData)
    .then(response => {
      console.log('Item updated:', response.data);
    })
    .catch(error => {
      console.error('Error updating item:', error);
    });
  }

  // delete record
  deleteItem(id) {
  axios.delete(`/api/items/${id}`)
    .then(response => {
      console.log('Item deleted:', response.data);
    })
    .catch(error => {
      console.error('Error deleting item:', error);
    });
  }


  ```



- **Creating API Endpoints in Laravel**
  - Define API routes in `routes/api.php` to handle client requests.
    ```php
    Route::get('/data', [DataController::class, 'fetchData']);
    ```
  - Ensure that these endpoints return JSON responses for easy consumption by the Vue.js frontend.

- **CRUD Operations Using Vue.js Components with Laravel Backend**
  - Build Vue components to interact with the Laravel backend via Axios for Create, Read, Update, and Delete operations.
  - Use `v-model` in Vue components to bind form data and submit it to Laravel API routes. Handle the response and update the UI dynamically without reloading the page.

---