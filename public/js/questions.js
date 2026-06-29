window.questions = [
    {
        question: "What is the component that contains the logic of the app?",
        choices: ["Calendar", "Cat", "Controller", "Coffee"],
        answer: 2
    },
    {
        question: "What should be changed in the code below?",
        choices: ["Delete the file", "$this should be $that", "Remove semicolon (;)", "Buyers::class should be Buyer::class"],
        answer: 3
    },
    {
        question: "It defines the path to the app's home route after authentication.",
        choices: ["public const HOME", "FollowController", "belongsTo()", "protected"],
        answer: 0
    },
    {
        question: "If you want to run multiple seeders at once, where should you register them?",
        choices: ["logout", "cache", "DatabaseSeeder.php", "login"],
        answer: 2
    },
    {
        question: "How do you display related Property records?",
        choices: ["foreach($property_type->properties as $property)", "echo $x", "$this->person", "return $a + $b"],
        answer: 0
    },
    {
        question: "Which is NOT a Laravel command?",
        choices: ["php artisan make:migration", "php artisan make:model", "ppp artison open-laravel-app", "php artisan migrate"],
        answer: 2
    },
    {
        question: "Which command displays all available routes?",
        choices: ["php artisan make:controller", "php artisan make:migration", "php artisan route:list", "php artisan make:model"],
        answer: 2
    },
    {
        question: "If a table has no timestamps, what should be false?",
        choices: ["public $timestamps", ".env", "app.blade.php", "$address"],
        answer: 0
    },
    {
        question: "Equivalent SQL: Property::latest()->get()",
        choices: ["DELETE properties ALL;", "DELETE THAT;", "SELECT * FROM properties ORDER BY created_at DESC;", "UPDATE age FROM users;"],
        answer: 2
    },
    {
        question: "Supply the correct CSS property pair.",
        choices: [".left and .right", ".required and .max", ".width and .height", "LoginController.php"],
        answer: 2
    },
    {
        question: "Many students can have many teachers. What is needed?",
        choices: ["New Controller", "Pivot Table", "Middleware", "Seeder"],
        answer: 1
    },
    {
        question: "How can you display the password of the logged in user?",
        choices: ["echo $age;", "Auth", "{{ Auth::user()->password }}", "{{ $address }}"],
        answer: 2
    },
    {
        question: "Relationship of CityPerson and City?",
        choices: ["Person has many Teachers", "Person has one Phone", "CityPerson belongs to City", "Car belongs to Model"],
        answer: 2
    },
    {
        question: "How many fields are created by timestamps()?",
        choices: ["1000", "2", "5", "10"],
        answer: 1
    },
    {
        question: "Correct syntax to create a Gate?",
        choices: ["Gate::define($ability, $callback)", "@can('admin')", "Route::get($uri,$action)", "DB::table('comments')"],
        answer: 0
    },
    {
        question: "Relationship of Person and CityPerson?",
        choices: ["Person has one Pet", "House has many Person", "Person has many CityPerson", "Prefecture has many City"],
        answer: 2
    },
    {
        question: "@csrf generates what HTML?",
        choices: ["Hidden input field", "Bootstrap", "Large image", "Green button"],
        answer: 0
    },
    {
        question: "Default middleware for authenticated users?",
        choices: ["HomeController", "auth", "CommentController", "services.php"],
        answer: 1
    },
    {
        question: "Command to reset and rerun all migrations?",
        choices: ["php make:model", "php artisan migrate:fresh", "artisan php route:clear", "php artisan artisan"],
        answer: 1
    },
    {
        question: "How do you check if a user is logged in?",
        choices: ["if(CommentController)", "if($this->school_id)", "if($x==31)", "if(auth()->check())"],
        answer: 3
    }
];