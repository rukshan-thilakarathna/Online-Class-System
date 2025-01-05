<?php

declare(strict_types=1);

namespace App\Orchid;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        $user = \App\Models\User::find((FacadesAuth::user())->id);
        return [

            Menu::make('Create New Class')
                ->icon('bs.book')
                ->title('Manage Classes')
                ->canSee($user->hasAnyAccess(['platform.systems.classes']))
                ->route('platform.systems.classes.create'),

            Menu::make('Classes List')
                ->icon('bs.book')
                ->canSee($user->hasAnyAccess(['platform.systems.classes']))
                ->route('platform.systems.classes'),

            Menu::make('Tute')
                ->icon('bs.book')
                ->canSee($user->hasAnyAccess(['platform.systems.tutes']))
                ->route('platform.systems.tutes')
                ->title('Manage Class Resources'),

            Menu::make('Videos')
                ->canSee($user->hasAnyAccess(['platform.systems.videos']))
                ->icon('bs.book')
                ->route('platform.systems.videos'),



            Menu::make('Test')
                ->icon('bs.book')
                ->title('Manage Test')
                ->canSee($user->hasAnyAccess(['platform.systems.test']))
                ->route('platform.systems.test'),

            Menu::make(__('Admins'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Students'))
                ->icon('bs.people')
                ->canSee($user->hasAnyAccess(['platform.systems.students']))
                ->route('platform.systems.students'),

            Menu::make(__('Guardians'))  
                ->icon('bs.people')
                ->canSee($user->hasAnyAccess(['platform.systems.guardians']))
                ->route('platform.systems.guardians'),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

           
        ];
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.classes', __('Classes'))
                ->addPermission('platform.systems.tutes', __('Tutes'))
                ->addPermission('platform.systems.videos', __('Videos'))
                ->addPermission('platform.systems.test', __('Tests'))
                ->addPermission('platform.systems.payment', __('Payment'))
                ->addPermission('platform.systems.students', __('Students'))
                ->addPermission('platform.systems.guardians', __('Guardians'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
