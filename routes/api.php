use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\AdminController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

});


Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    Route::get('/users', [AdminController::class, 'users']);

    Route::get('/events', [AdminController::class, 'events']);

    Route::get('/bookings', [AdminController::class, 'bookings']);

});