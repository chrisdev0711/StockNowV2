<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use Auth;

use App\Models\Site;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = null;
        if(Auth::user()->hasRole('owner'))
        {
            $users = User::where('owner_id', '=', Auth::user()->id)->search($search)
            ->latest()
            ->paginate(20);    
        } else  {
            $users = User::search($search)
                ->latest()
                ->paginate(20);
        }

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);

        $locations = Site::where('status', true)->get();

        $roles = Role::get();

        return view('app.users.create', compact('roles', 'locations'));
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();
        $locations = $request->location_ids;   
        $location_ids = '';     
        foreach($locations as $idx => $location)
        {
            if($location != 0)
            {
                if($location_ids == '')
                {
                    $location_ids = $location;            
                    $validated['active_site'] = $location;
                } else                
                    $location_ids .= (";" . $location);            
            }
        }
        $validated['location_ids'] = $location_ids;
        $validated['password'] = Hash::make($validated['password']);
        $validated['owner_id'] = Auth::user()->id;

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $this->authorize('view', $user);

        return view('app.users.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $roles = Role::get();
        $locations = Site::where('status', true)->get();

        return view('app.users.edit', compact('user', 'roles', 'locations'));
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $this->authorize('update', $user);
        $validated = $request->validated();
        
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);            
        }
        $validated['owner_id'] = Auth::user()->id;

        $locations = $request->location_ids;   
        $location_ids = '';     
        foreach($locations as $idx => $location)
        {
            if($location != 0)
            {
                if($location_ids == '')
                {
                    $location_ids = $location;            
                    $validated['active_site'] = $location;
                } else                
                    $location_ids .= (";" . $location);            
            }
        }
        $validated['location_ids'] = $location_ids;
        
        $user->update($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
