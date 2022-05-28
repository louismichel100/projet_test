<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Service;
use App\Http\Resources\Service as ServiceResource;
   
class ServiceController extends BaseController
{

    public function index()
    {
        $b = Service::all();
        return $this->sendResponse(BlogResource::collection($b), 'Service fetched.');
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'amont' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $b = Service::create($input);
        return $this->sendResponse(new BlogResource($b), 'Service created.');
    }

   
    public function show($id)
    {
        $b = Service::find($id);
        if (is_null($b)) {
            return $this->sendError('Service does not exist.');
        }
        return $this->sendResponse(new BlogResource($b), 'Post fetched.');
    }
    

    public function update(Request $request, Blog $b)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $b->title = $input['title'];
        $b->description = $input['description'];
        $b->amont = $input['amont'];
        $b->save();
        
        return $this->sendResponse(new BlogResource($b), 'Service updated.');
    }
   
    public function destroy(Blog $b)
    {
        $b->delete();
        return $this->sendResponse([], 'Service deleted.');
    }
}
