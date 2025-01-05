<?php

declare(strict_types=1);

use App\Models\Classes;
use App\Models\Student;
use App\Orchid\Layouts\Classes\ClassesLayout;
use App\Orchid\Screens\Classes\ClassesCreateScreen;
use App\Orchid\Screens\Classes\ClassesScreen;
use App\Orchid\Screens\Classes\ClassesViewScreen;
use App\Orchid\Screens\Classes\ClassHasPaymentsListScreen;
use App\Orchid\Screens\Classes\ClassHasStudentListScreen;
use App\Orchid\Screens\Classes\ClassTestResultScreen;
use App\Orchid\Screens\Classes\ClassUpdatScreenLayout;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\QuestionsAnswers\QuestionsAnswersListScreen;
use App\Orchid\Screens\QuestionsAnswers\QuestionsAnswersUpdateScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Student\GuardiansListScreen;
use App\Orchid\Screens\Student\StudentListScreen;
use App\Orchid\Screens\Student\StudentUpdateScreen;
use App\Orchid\Screens\Student\TodayBirthDayListLayout;
use App\Orchid\Screens\Test\TestEditScreen;
use App\Orchid\Screens\Test\TestListScreen;
use App\Orchid\Screens\Tutes\TutesListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use App\Orchid\Screens\Videos\VideosListScreen;
use App\Orchid\Screens\Videos\VideosUpdateScreen;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Question\Question;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));


Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Platform > System > Classes
Route::screen('classes', ClassesScreen::class)
    ->name('platform.systems.classes')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Classes'), route('platform.systems.classes')));

// Platform > System > Classes
Route::screen('classes-test-result/{class_id}/{test_id}/{student_id?}', ClassTestResultScreen::class)
    ->name('platform.systems.classes.test-result')
    ->breadcrumbs(fn (Trail $trail, $class_id , $test_id) => $trail
        ->parent('platform.systems.classes')
        ->push(__('Test Result'), route('platform.systems.classes.test-result',[ $class_id , $test_id ])));

// Platform > System > Classes > Create
Route::screen('classes/create', ClassesCreateScreen::class)
    ->name('platform.systems.classes.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.classes')
        ->push(__('Create'), route('platform.systems.classes.create')));

// Platform > System > Classes > update
Route::screen('classes/update/{id}', ClassUpdatScreenLayout::class)
    ->name('platform.systems.classes.update')
    ->breadcrumbs(fn (Trail $trail,$id) => $trail
        ->parent('platform.systems.classes')
        ->push(__('Update'), route('platform.systems.classes.update', $id)));


// Platform > System > Classes > View
Route::screen('classes/view/{id}', ClassesViewScreen::class)
    ->name('platform.systems.classes.view')
    ->breadcrumbs(fn (Trail $trail,$id) => $trail
        ->parent('platform.systems.classes')
        ->push($id->name, route('platform.systems.classes.view', $id)));


// Platform > System > Classes > View
Route::screen('classes/view/student/{id}', ClassHasStudentListScreen::class)
->name('platform.systems.classes.view.student')
->breadcrumbs(fn (Trail $trail,$id) => $trail
    ->parent('platform.systems.classes.view',$id)
    ->push('Students', route('platform.systems.classes.view.student', $id)));


// Platform > System > Classes > View
Route::screen('classes/view/payments/{id}', ClassHasPaymentsListScreen::class)
->name('platform.systems.classes.view.paymenrs')
->breadcrumbs(fn (Trail $trail,$id) => $trail
    ->parent('platform.systems.classes.view',$id)
    ->push('Payments', route('platform.systems.classes.view.paymenrs', $id)));


// Platform > System > Test
Route::screen('test', TestListScreen::class)
->name('platform.systems.test')
->breadcrumbs(fn (Trail $trail) => $trail
    ->parent('platform.index')
    ->push(__('Test'), route('platform.systems.test')));


// Platform > System > Test
Route::screen('update/test/{id}', TestEditScreen::class)
->name('platform.systems.test.edit')
->breadcrumbs(fn (Trail $trail,$id) => $trail
    ->parent('platform.systems.test')
    ->push(__('Update'), route('platform.systems.test.edit',$id)));


// Platform > System > Test > questions&answers
Route::screen('test/questions&answers/{id}', QuestionsAnswersListScreen::class)
->name('platform.systems.test.questions&answers')
->breadcrumbs(fn (Trail $trail ,$id) => $trail
    ->parent('platform.systems.test')
    ->push(__('Questions & Answers'), route('platform.systems.test.questions&answers', $id)));


// Platform > System > Test > questions&answers > Update
Route::screen('test/questions&answers/update/{id}', QuestionsAnswersUpdateScreen::class)
->name('platform.systems.test.questions&answers-update')
->breadcrumbs(fn (Trail $trail ,$id) => $trail
    ->parent('platform.systems.test.questions&answers',11)
    ->push(__('Update'), route('platform.systems.test.questions&answers-update', $id)));


// Platform > System > Videos
Route::screen('videos', VideosListScreen::class)
    ->name('platform.systems.videos')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Videos'), route('platform.systems.videos')));


// Platform > System > Videos > Update
Route::screen('videos/update/{id}', VideosUpdateScreen::class)
    ->name('platform.systems.videos.update')
    ->breadcrumbs(fn (Trail $trail ,$id) => $trail
        ->parent('platform.systems.videos')
        ->push(__('Update'), route('platform.systems.videos.update',$id)));


// Platform > System > Tute
Route::screen('tutes', TutesListScreen::class)
    ->name('platform.systems.tutes')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Tutes'), route('platform.systems.tutes')));

// Platform > System > Students
Route::screen('students', StudentListScreen::class)
    ->name('platform.systems.students')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('All Students'), route('platform.systems.students')));

Route::screen('students/today-birthdays', TodayBirthDayListLayout::class)
->name('platform.systems.students.today-birthdays')
->breadcrumbs(fn (Trail $trail) => $trail
    ->parent('platform.systems.students')
    ->push(__('Today Birthdays'), route('platform.systems.students.today-birthdays')));

Route::screen('students/update/{id}', StudentUpdateScreen::class)
->name('platform.systems.students.update')
->breadcrumbs(fn (Trail $trail,$id) => $trail
    ->parent('platform.systems.students')
    ->push(__('Update'), route('platform.systems.students.update',$id)));

// Platform > System > Guardian
Route::screen('guardians', GuardiansListScreen::class)
    ->name('platform.systems.guardians')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('All Guardians'), route('platform.systems.guardians')));



