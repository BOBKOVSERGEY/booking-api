<?php

namespace App\Http\Controllers\Api\V1\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Models\Property;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('properties-manage');
        return response()->json(['success' => true]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StorePropertyRequest $request): Model|Builder
    {
        $this->authorize('properties-manage');

        return Property::query()
            ->create($request->validated());
    }
}
