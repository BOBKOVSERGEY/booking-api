<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PropertyPhotoController extends Controller
{
    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function store(Property $property, Request $request)
    {
        $request->validate([
            'photo' => ['image', 'max:5000']
        ]);
        if ($property->owner_id != auth()->id()) {
            abort(403);
        }

        $photo = $property
            ->addMediaFromRequest('photo')
            ->toMediaCollection('photos');

        return [
            'filename' => $photo->getUrl(),
            'thumbnail' => $photo->getUrl('thumbnail')
        ];
    }
}
