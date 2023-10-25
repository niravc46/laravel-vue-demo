<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Amenity;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $property;
    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $properties = $this->property;
            $properties = $properties->with([
                'amenities:id,name'
            ]);

            $start = Carbon::parse($request->start_date);
            $end = Carbon::parse($request->end_date);

            // Sort Parameters
            if (isset($request->sortby) && (isset($request->direction))) {
                $sort[$request->sortby] = $request->direction;
            }

            // filter parameter
            isset($request->searchQuery) && !empty($request->searchQuery) ? $q = $request->searchQuery : $q = null;

            if (isset($request->start_date) && isset($request->end_date)) {
                $properties = $properties->whereDate('created_at', '<=', $end)
                    ->whereDate('created_at', '>=', $start);
            }

            // pagination
            $properties = $properties->ofSearch($q)
                ->ofSort(@$sort)
                ->paginate(5);

            $property_data = $properties;
            return $this->success(['property' => $property_data]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function create(StorePropertyRequest $request)
    {
        \DB::beginTransaction();
        try {
            $request->validated($request->all());
            \DB::commit();
            $property = $this->property->create([
                'name' => $request->name,
                'details' => $request->details,
                'type' => $request->type,
                'size' => $request->size,
                'address' => $request->address,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $property->amenities()->attach($request->amenity_id);

            // pdf uploaddd
            if ($request->file('brochure')) {
                $fileName = time() . '_' . $request->brochure->getClientOriginalName();
                $filePath = $request->file('brochure')->storeAs('proprties/brochure/' . $property->id, $fileName, 'public');
                $file_path     = '/storage/' . $filePath;
            }
            $update_properties = $this->property->where('id', $property->id)->update([
                'brochure' => $fileName,
                'brochure_path' => $file_path,
            ]);

            $property_detail = $this->property->where('id', $property->id)->first();
            return $this->success(['property' => $property_detail], 'Property created successfully..', 200);
        } catch (\Exception $e) {
            return $e->getMessage();
            \DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        try {
            $property_detail = $this->property->where('id', $id)->with([
                'amenities:id,name'
            ])->first();
            return $this->success([
                'property_detail' => $property_detail
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdatePropertyRequest $request)
    {
        \DB::beginTransaction();
        try {
            $request->validated($request->all());
            $property = $this->property->find($id);
            \DB::commit();
            $update_property = $property->update([
                'name' => $request->name,
                'details' => $request->details,
                'type' => $request->type,
                'size' => $request->size,
                'address' => $request->address,
                'updated_at' => Carbon::now(),
            ]);
            $property->amenities()->sync($request->amenity_id);

            if (isset($request->brochure) && !empty($request->brochure)) {
                if ($request->hasFile('brochure')) {
                    // Remove existing file from storage
                    if (file_exists(public_path($property->brochure_path))) {
                        unlink(public_path($property->brochure_path));
                    }
                    $fileName = time() . '_' . $request->brochure->getClientOriginalName();
                    $filePath = $request->file('brochure')->storeAs('proprties/brochure/' . $property->id, $fileName, 'public');
                    $file_path     = '/storage/' . $filePath;
                }
                $update_properties = $this->property->where('id', $property->id)->update([
                    'brochure' => $fileName,
                    'brochure_path' => $file_path
                ]);
            }
            $property_detail = $this->property->where('id', $property->id)->with([
                'amenities:id,name'
            ])->first();
            return $this->success(['property' => $property_detail], 'Property updated successfully..', 200);
        } catch (\Exception $e) {
            return $e->getMessage();
            \DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        \DB::beginTransaction();
        try {
            \DB::commit();
            $delete_property = $this->property->find($id);
            $delete_property = $delete_property->delete();
            return $this->success([], 'Property deleted successfully..', 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        try {
            $restore_property = $this->property->withTrashed()->find($id);
            $restore_property = $restore_property->restore();
            return $this->success('Property restored successfully..');
        } catch (\Exception $e) {
            return $e->getMessage();
            \DB::rollback();
        }
    }

    public function getAmenity()
    {
        try {
            $get_amenity = Amenity::select('id', 'name')->get();
            return $this->success(['amenity' => $get_amenity]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
