<?php

use App\Http\Controllers\ProfileController;
use App\Models\Clas;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/home');
    } else {
        return view('auth.login');
    }
});

/*
----------- roles of user in the system-----------
* --superadministrator
* --admin
* --teacher
* --class teacher
* --hod
* --hos
* --founder
* --president
* --parent
* --student
* --nurse
* --accountant
------------------------------------------------
*/

Route::get('/test', [App\Http\Controllers\PDFController::class, 'report']);
Route::get('/testing', function () {
    $tables = \App\Models\Timetable::where('clas_id', 6)->distinct()->get(['subject_id']);
    return view('emails.reports');
})->name('report');


/* -------- authenticated user only route ------- */
Route::middleware(['auth'])->group(function () {
    Route::get('/back', function () {
        return url()->previous() ? redirect()->route('home') : redirect()->back();
    }
    )->name('back');
    Route::get('/documents', \App\Http\Livewire\Documents::class)->name('documents');
    Route::get('/home', function () {
        return view('home');
    }
    )->name('home');
    Route::get('/profile/{id}', App\Http\Livewire\Profiles::class)->name('profile');
    // Route::get('/chats',  \App\Http\Livewire\Chats::class)->name('chats');
    Route::get('/messages/{sender:email}', \App\Http\Livewire\Messages::class)->name('messages');
    Route::get('/broadsheet', \App\Http\Livewire\BroadSheet::class)->name('broadsheet');
    Route::get('/scoresheet/{clas?}/{subject?}', [\App\Http\Controllers\PDFController::class, 'scoresheet'])->name('scoresheet');
    Route::get('/reportcard/{term?}/{student?}', [\App\Http\Controllers\PDFController::class, 'reportcard'])->name('reportcard');
    Route::get('/checkresult', \App\Http\Livewire\CheckResult::class)->name('checkresult');
    Route::get('/sendresult', \App\Http\Livewire\SendResult::class)->name('sendresult')->middleware('role:superadministrator|admin|hos|exam officer');

});

/* -------- without any authenication ----------- */
Route::group(['middleware' => ['web']], function () {
    Route::get('/welcome/{email?}', [\App\Http\Controllers\AuthController::class, 'welcome'])->name('welcome');
    Route::post('/update-password', [\App\Http\Controllers\AuthController::class, 'store'])->name('welcome.update');

});

/* ----------------admin only route ------------*/
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:superadministrator|admin']], function () {
    Route::get('/roles', \App\Http\Livewire\Guard::class)->name('gate');
});

/* ----------admin and hos only route ------------*/
Route::group(['prefix' => 'school', 'middleware' => ['auth', 'role:superadministrator|admin|hos|hod']], function () {
    Route::get('/users', \App\Http\Livewire\Users::class)->name('users');
    Route::get('/users/staff', \App\Http\Livewire\Staffs::class)->name('staff');
    Route::get('/students', \App\Http\Livewire\Students::class)->name('students');
    Route::get('/parent/{parent:first_name}/student/{student:id}/profile', \App\Http\Livewire\Profiles\StudentProfile::class)->name('students.profile'); //student profile
    Route::get('/student/{student:last_name}/profile/biodata', \App\Http\Livewire\BioData::class)->name('students.biodata'); //student profile
    Route::get('/parent/{user:email}/profile', \App\Http\Livewire\Profiles::class)->name('parent.profile');
    Route::get('/staff/{user:email}/profile', \App\Http\Livewire\Profiles::class)->name('staff.profile');
    Route::get('/visitors', \App\Http\Livewire\Visitors::class)->name('visitors');
    Route::get('/users/parents', \App\Http\Livewire\Parents::class)->name('parents');
    Route::get('/sms', \App\Http\Livewire\Sms::class)->name('sms');
});

/*  -------------accountant and route -----------*/
Route::group(['prefix' => 'finances', 'middleware' => ['auth', 'role:superadministrator|accountant']], function () {
    Route::get('', \App\Http\Livewire\Finances::class)->name('finances');
    Route::get('/fees', \App\Http\Livewire\Fees::class)->name('fees');
    Route::get('/payments', \App\Http\Livewire\Payments::class)->name('payments');
});

/*  -------------teachers and class techers and route -----------*/
Route::group(['prefix' => 'school', 'middleware' => ['auth', 'role:superadministrator|admin|teacher|class teacher']], function () {

    Route::get('/leave', \App\Http\Livewire\Leave::class)->name('leave');
    Route::get('/scores', \App\Http\Livewire\Scores::class)->name('scores');
    Route::get('/{school}/student', \App\Http\Livewire\ClassStudents::class)->name('class.students');
    Route::view('/{school}/myclass', 'components.my-class')->name('teachers.class');
    Route::get('/{student}/card', \App\Http\Livewire\Cards::class)->name('card');
});

/*  -------------head of school and department and route -----------*/
Route::group(['prefix' => 'academics', 'middleware' => ['auth', 'role:superadministrator|admin|hod|hos']], function () {
    Route::get('/classes', \App\Http\Livewire\School::class)->name('classes');
    Route::get('/session', \App\Http\Livewire\Session::class)->name('session');
    Route::get('/department', \App\Http\Livewire\Department::class)->name('department');
    Route::get('/subjects', \App\Http\Livewire\Subject::class)->name('subjects');
    Route::get('/timetables', \App\Http\Livewire\TimeTables::class)->name('timetable');
    Route::get('/{student}/comment', \App\Http\Livewire\HosComment::class)->name('hos.comment');
    Route::get('/leave-action', \App\Http\Livewire\LeaveAction::class)->name('leave.action');
});