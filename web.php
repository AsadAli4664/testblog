<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Portal\CampaignController;
use App\Http\Controllers\Portal\QuestController;
use App\Http\Controllers\Portal\SchoolController;
use App\Http\Controllers\Portal\StudentController;
use App\Http\Controllers\Portal\TeacherController;
use App\Http\Controllers\Portal\UserController;
use App\Http\Controllers\Portal\DashboardController;
use App\Http\Controllers\Portal\CourseController;
use App\Http\Controllers\Portal\ObjectiveController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Portal\InvitationController;
use App\Http\Controllers\Portal\CourseCategoryController;
use App\Http\Controllers\Portal\CustomNotificationController;
use App\Http\Controllers\Portal\PageContentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Portal\MembershipPlanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard.index');
} )->name('homepage');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    //Applying role middle ware to apply spatie functionality, 
    Route::middleware('role:admin')->group(function () {
        // Routes for admin start here
        Route::group(['prefix' => '/user'], function () {
            Route::get('/role/{role}', [UserController::class, 'index'])->name('admin.user.index');
            Route::get('/add', [UserController::class, 'add'])->name('admin.user.add');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::get('/list/{role}', [UserController::class, 'list'])->name('admin.user.list');
            Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.user.delete');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
        });

        Route::group(['prefix' => '/page-content'], function () {
            Route::get('/', [PageContentController::class, 'index'])->name('admin.page-content.index');
            Route::get('/edit/{id}', [PageContentController::class, 'edit'])->name('admin.page-content.edit');
            Route::post('/update', [PageContentController::class, 'update'])->name('admin.page-content.update');
        });

        Route::group(['prefix' => '/custom-notifications'], function () {
            Route::get('/', [CustomNotificationController::class, 'index'])->name('admin.custom-notification.index');
            Route::get('/edit/{id}', [CustomNotificationController::class, 'edit'])->name('admin.custom-notification.edit');
            Route::post('/update', [CustomNotificationController::class, 'update'])->name('admin.custom-notification.update');
        });

        Route::group(['prefix' => '/course/categories'], function () {
            Route::get('/', [CourseCategoryController::class, 'index'])->name('admin.course.category.index');
            Route::get('/add', [CourseCategoryController::class, 'add'])->name('admin.course.category.add');
            Route::get('/edit/{id}', [CourseCategoryController::class, 'edit'])->name('admin.course.category.edit');
            Route::get('/list', [CourseCategoryController::class, 'list'])->name('admin.course.category.list');
            Route::post('/store', [CourseCategoryController::class, 'store'])->name('admin.course.category.store');
            Route::get('/delete/{id}', [CourseCategoryController::class, 'delete'])->name('admin.course.category.delete');
            Route::post('/update/{id}', [CourseCategoryController::class, 'update'])->name('admin.course.category.update');
        });
    });
    // Routes for admin end here
    // Routes for teacher start here
    Route::middleware('role:teacher')->group(function () {
        Route::group(['prefix' => '/teacher'], function () {
            //Routes for teacher course start here
            Route::group(['prefix' => '/course'], function () {
                Route::get('/', [CourseController::class, 'index'])->name('teacher.course.index');
                Route::get('/add', [CourseController::class, 'add'])->name('teacher.course.add');
                Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('teacher.course.edit');
                Route::get('/list', [CourseController::class, 'list'])->name('teacher.course.list');
                Route::post('/store', [CourseController::class, 'store'])->name('teacher.course.store');
                Route::get('/delete/{id}', [CourseController::class, 'delete'])->name('teacher.course.delete');
                Route::post('/update/{id}', [CourseController::class, 'update'])->name('teacher.course.update');
                Route::post('/send-invitation', [CourseController::class, 'invite'])->name('teacher.course.invite');
            });
            //Routes for teacher course end here
            //Routes for teacher Objectives start here 
            Route::group(['prefix' => '/objective'], function () {
                Route::get('/{courseid}', [ObjectiveController::class, 'index'])->name('teacher.objective.index');
                Route::get('/add', [ObjectiveController::class, 'add'])->name('teacher.objective.add');
                Route::get('/edit/{id}', [ObjectiveController::class, 'edit'])->name('teacher.objective.edit');
                Route::get('/list', [ObjectiveController::class, 'list'])->name('teacher.objective.list');
                Route::post('/store', [ObjectiveController::class, 'store'])->name('teacher.objective.store');
                Route::get('/delete/{id}', [ObjectiveController::class, 'delete'])->name('teacher.objective.delete');
                Route::post('/update/{id}', [ObjectiveController::class, 'update'])->name('teacher.objective.update');
                Route::post('/send-invitation', [ObjectiveController::class, 'invite'])->name('teacher.objective.invite');
            });
            //Routes for teacher objectives end here
            //Routes for teacher campaign start here
            Route::group(['prefix' => '/course/{courseid}/campaign'], function () {
                Route::get('/', [CampaignController::class, 'index'])->name('course.campaign.index');
                Route::get('/add', [CampaignController::class, 'add'])->name('course.campaign.add');
                Route::get('/edit/{id}', [CampaignController::class, 'edit'])->name('course.campaign.edit');
                Route::get('/list', [CampaignController::class, 'list'])->name('course.campaign.list');
                Route::post('/store', [CampaignController::class, 'store'])->name('course.campaign.store');
                Route::get('/delete/{id}', [CampaignController::class, 'delete'])->name('course.campaign.delete');
                Route::post('/update/{id}', [CampaignController::class, 'update'])->name('course.campaign.update');
            });
            //Routes for teacher campaign start here
            //Routes for teacher quest start here
            Route::group(['prefix' => '/campaign/{campaignid}/quest'], function () {
                Route::get('/', [QuestController::class, 'index'])->name('campaign.quest.index');
                Route::get('/add', [QuestController::class, 'add'])->name('campaign.quest.add');
                Route::get('/edit/{id}', [QuestController::class, 'edit'])->name('campaign.quest.edit');
                Route::get('/list', [QuestController::class, 'list'])->name('campaign.quest.list');
                Route::post('/store', [QuestController::class, 'store'])->name('campaign.quest.store');
                Route::get('/delete/{questid}', [QuestController::class, 'delete'])->name('campaign.quest.delete');
                Route::post('/update/{id}', [QuestController::class, 'update'])->name('campaign.quest.update');
            });
            //Routes for teacher quest end here
        });
        //Teacher Prefix Ends Here
    });
    // Routes for teacher middleware end here

    // Routes for student start here
    Route::middleware('role:student')->group(function () {
        Route::group(['prefix' => '/student'], function () {
            
            //Routes for student course start here
            Route::group(['prefix' => '/course'], function () {
                Route::get('/', [StudentController::class, 'course'])->name('student.course.index');
            });
            //Routes for student course end here


            //Routes for student quest start here
            Route::group(['prefix' => '/campaign/{campaignid}/quest'], function () {
                Route::get('/', [StudentController::class, 'showQuests'])->name('student.campaign.quest.index');
            });
            //Routes for student quest end here

                //Routes for student campaign start here
            Route::group(['prefix' => '/course/{courseid}/campaign'], function () {
                Route::get('/', [CampaignController::class, 'index'])->name('student.course.campaign.index');
                Route::get('/add', [CampaignController::class, 'add'])->name('student.course.campaign.add');
                Route::get('/edit/{id}', [CampaignController::class, 'edit'])->name('student.course.campaign.edit');
                Route::get('/list', [CampaignController::class, 'list'])->name('student.course.campaign.list');
                Route::post('/store', [CampaignController::class, 'store'])->name('student.course.campaign.store');
                Route::get('/delete/{id}', [CampaignController::class, 'delete'])->name('student.course.campaign.delete');
                Route::post('/update/{id}', [CampaignController::class, 'update'])->name('student.course.campaign.update');
            });
            //Routes for student campaign start here
            

        });
        //student Prefix Ends Here
    });
    // Routes for student middleware end here


    Route::get('under-development', [StudentController::class, 'under'])->name('under');
});
// Auth Miidleware ends Here
// routes without auth start here 
Auth::routes();
Route::get('user-type', [RegisterController::class, 'userType'])->name('user.type');  //shows page to select user type
Route::get('teacher-signup', [RegisterController::class, 'teacherSignUp'])->name('teacher.signup');  // shows page to signup as teacher
Route::get('student-signup', [RegisterController::class, 'studentSignUp'])->name('student.signup'); //shows page to signup as student
Route::get('choose-plan', [RegisterController::class, 'subscriptionPlan'])->name('teacher.subscription.plan'); //shows page to select subscription plans
Route::get('payment-details/plan/{id}', [RegisterController::class, 'paymentDetails'])->name('teacher.payment.details'); // shows page to enter payment/card details
Route::get('checkout', [RegisterController::class, 'checkout'])->name('teacher.checkout');  //shows page after checkput with payment status
Route::get('recovery', [RegisterController::class, 'recovery'])->name('recovery'); //shows page that password reset email has been sent

//Membership routes 
Route::get('membership-plans',[MembershipPlanController::class, 'index'])->name('membership');
Route::get('checkout', [MembershipPlanController::class, 'checkout'])->name('checkout');

Route::post('student-store', [StudentController::class, 'signup'])->name('student.store');
Route::post('teacher-store', [TeacherController::class, 'signup'])->name('teacher.store');
Route::get('verify', [TeacherController::class, 'verify'])->name('emil.verify');
Route::get('/invitation/accept/', [InvitationController::class, 'accept'])->name('invitation.accept');
Route::get('/invitation/decline', [InvitationController::class, 'decline'])->name('invitation.decline');

// Login Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes...
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
