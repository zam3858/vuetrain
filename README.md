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
### Roles and Permission With Spatie/laravel-permission

#### 1. **Introduction to Spatie Laravel Permission Package**
   - The Spatie Laravel Permission package allows you to manage user roles and permissions in a Laravel application easily.
   - With this package, you can assign permissions to users and manage role-based access control (RBAC).
   - It works well for building scalable, maintainable systems where access control is necessary.

#### 2. **Installation and Setup**
   - Ensure your Laravel version is 6.x or higher.
   - Install the Spatie Permission package via Composer:
     ```bash
     composer require spatie/laravel-permission
     ```
   - Publish the configuration and migration files:
     ```bash
     php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
     ```
   - Run the migration to create the necessary database tables:
     ```bash
     php artisan migrate
     ```

#### 3. **Configuration**
   - Ensure your `User` model implements the `HasRoles` trait from the Spatie package.
   - Open the `User.php` model and add:
     ```php
     use Spatie\Permission\Traits\HasRoles;

     class User extends Authenticatable
     {
         use HasRoles;
     }
     ```

#### 4. **Creating Roles and Permissions**
   - You can create roles and permissions using Eloquent models or Artisan commands.
   - **Create roles**:
     ```php
     use Spatie\Permission\Models\Role;

     Role::create(['name' => 'admin']);
     Role::create(['name' => 'editor']);
     Role::create(['name' => 'user']);
     ```
   - **Create permissions**:
     ```php
     use Spatie\Permission\Models\Permission;

     Permission::create(['name' => 'edit articles']);
     Permission::create(['name' => 'delete articles']);
     Permission::create(['name' => 'publish articles']);
     ```

#### 5. **Assigning Roles and Permissions**
   - To assign a role to a user:
     ```php
     $user = User::find(1);
     $user->assignRole('admin');
     ```
   - To assign a permission to a role:
     ```php
     $role = Role::findByName('editor');
     $role->givePermissionTo('edit articles');
     ```
   - To assign permission directly to a user:
     ```php
     $user = User::find(1);
     $user->givePermissionTo('publish articles');
     ```

#### 6. **CRUD Implementation with Role-Based Access**
   - To implement role-based access control for CRUD operations on user records, we will create a controller that uses middleware to restrict access based on roles or permissions.

#### 7. **Middleware Setup for Role or Permission Control**
   - In your controller, you can use the `middleware` method to apply role or permission checks.
   - Example:
     ```php
     class UserController extends Controller
     {
         public function __construct()
         {
             $this->middleware('role:admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
             $this->middleware('permission:view users')->only('index');
         }

         public function index()
         {
             $users = User::all();
             return view('users.index', compact('users'));
         }

         public function create()
         {
             return view('users.create');
         }

         public function store(Request $request)
         {
             $user = User::create($request->all());
             return redirect()->route('users.index');
         }

         public function edit(User $user)
         {
             return view('users.edit', compact('user'));
         }

         public function update(Request $request, User $user)
         {
             $user->update($request->all());
             return redirect()->route('users.index');
         }

         public function destroy(User $user)
         {
             $user->delete();
             return redirect()->route('users.index');
         }
     }
     ```

#### 8. **Blade Directives for Role and Permission Checks**
   - You can also use Blade directives to conditionally show or hide elements based on roles or permissions.
   - Example for displaying content to only admins:
     ```blade
     @role('admin')
         <a href="{{ route('users.create') }}">Create New User</a>
     @endrole
     ```
   - Example for permission check:
     ```blade
     @can('delete users')
         <form action="{{ route('users.destroy', $user->id) }}" method="POST">
             @csrf
             @method('DELETE')
             <button type="submit">Delete</button>
         </form>
     @endcan
     ```

#### 9. **Code Example for User CRUD Operations**
   - **Controller**:
     Here’s an example of a simple `UserController` that supports CRUD operations, with access restricted to users with appropriate roles or permissions.
     ```php
     use App\Models\User;

     class UserController extends Controller
     {
         public function index()
         {
             $users = User::all();
             return view('users.index', compact('users'));
         }

         public function create()
         {
             return view('users.create');
         }

         public function store(Request $request)
         {
             $user = User::create($request->all());
             return redirect()->route('users.index');
         }

         public function show(User $user)
         {
             return view('users.show', compact('user'));
         }

         public function edit(User $user)
         {
             return view('users.edit', compact('user'));
         }

         public function update(Request $request, User $user)
         {
             $user->update($request->all());
             return redirect()->route('users.index');
         }

         public function destroy(User $user)
         {
             $user->delete();
             return redirect()->route('users.index');
         }
     }
     ```

#### 10. **Routes Setup**
   - Define the routes for the user CRUD operations in `web.php`:
     ```php
     Route::resource('users', UserController::class);
     ```

#### 11. **User Model with Mass Assignment**
   - Ensure that your `User` model has the necessary fields for mass assignment:
     ```php
     class User extends Authenticatable
     {
         use HasRoles;

         protected $fillable = ['name', 'email', 'password'];
     }
     ```

### Introduction to Vue Router

Vue Router is the official router for Vue.js, used to build single-page applications (SPA). It allows you to map components to different URLs and provides the functionality to switch between views seamlessly without reloading the entire page.

#### Key Concepts:
1. **Routes**: Define how your application's URL maps to specific components.
2. **Router View**: A special Vue component used to render matched components.
3. **Navigation**: Methods for programmatically navigating between routes.

### Installing Vue Router

If you are working with a Vue CLI project, you can easily install `vue-router`:

```bash
npm install vue-router
```

After installing, you need to configure the router in your application.

### Basic Configuration

First, you need to define your routes in the `router.js` file (or any other name of your choice).

```js
// src/router.js

import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import About from './components/About.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
```

### Setting Up Router in Your Vue App

To integrate the router, you need to add it to your main Vue instance.

```js
// src/main.js

import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

createApp(App)
  .use(router)
  .mount('#app');
```

### Using `<router-view>` and `<router-link>`

Once the router is set up, you can use the `<router-view>` component in your `App.vue` file to define where your routes will be rendered, and use `<router-link>` to create navigational links between them.

```html
<!-- src/App.vue -->

<template>
  <div>
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/about">About</router-link>
    </nav>
    
    <!-- Render the matched route's component -->
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>
```

### Dynamic Routes

Dynamic routes are useful when the path needs to include parameters, like a user ID.

```js
// src/router.js

import User from './components/User.vue';

const routes = [
  { path: '/user/:id', component: User },
];

// In User.vue, access the dynamic route parameter:
<script>
export default {
  mounted() {
    console.log(this.$route.params.id);
  }
};
</script>
```

In this example, navigating to `/user/123` will render the `User.vue` component, and the ID `123` will be accessible via `this.$route.params.id`.

### Programmatic Navigation

Vue Router also allows you to navigate programmatically using the `this.$router` object.

```js
// Example of programmatic navigation inside a component

<script>
export default {
  methods: {
    goToHome() {
      this.$router.push('/');
    },
  },
};
</script>
```

In this example, the method `goToHome` will navigate the user to the home route (`/`).

### Named Routes

You can give a name to your routes and use that name for navigation.

```js
// src/router.js

const routes = [
  { path: '/', name: 'home', component: Home },
  { path: '/about', name: 'about', component: About },
];

// Using the named route to navigate
<router-link :to="{ name: 'about' }">Go to About</router-link>
```

### Route Guards

Vue Router also allows you to guard routes by checking conditions before navigating. You can use **navigation guards** to control access to certain routes.

```js
// src/router.js

const routes = [
  {
    path: '/protected',
    component: Protected,
    beforeEnter: (to, from, next) => {
      if (isAuthenticated()) {
        next(); // Allow navigation
      } else {
        next('/login'); // Redirect to login
      }
    },
  },
];
```

### Lazy Loading Routes

For large applications, you might want to lazy-load routes to improve performance. This is done by splitting your JavaScript bundle into smaller chunks, only loading the components when needed.

```js
// src/router.js

const routes = [
  {
    path: '/about',
    component: () => import('./components/About.vue'), // Lazy-loaded route
  },
];
```

### Putting It All Together

Here's a complete example that includes a basic router configuration, dynamic routes, and navigation links:

```js
// src/router.js

import { createRouter, createWebHistory } from 'vue-router';
import Home from './components/Home.vue';
import About from './components/About.vue';
import User from './components/User.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
  { path: '/user/:id', component: User }, // Dynamic route
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
```

```html
<!-- src/App.vue -->

<template>
  <div>
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/about">About</router-link>
      <router-link :to="{ name: 'user', params: { id: 123 } }">User 123</router-link>
    </nav>
    
    <!-- The matched component will be rendered here -->
    <router-view></router-view>
  </div>
</template>
```