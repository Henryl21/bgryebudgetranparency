protected $routeMiddleware = [
    // ...
    'block.user.login' => \App\Http\Middleware\RedirectIfAuthenticatedUser::class,
];

