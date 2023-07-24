<?php

namespace App\Http\Controllers\Market;

use App\Http\Controllers\Controller;
use App\Http\Requests\postCategory\PostCategoryRequest;
use App\Http\Requests\postCategory\StorePostCategoryRequest;
use App\Http\Requests\postCategory\UpdatePostCategoryRequest;
use App\Http\Resources\PostCategoryResource;
use App\Models\PostCategory;
use App\Repositories\MySQL\PostCategoryRepository\InterfacePostCategoryRepository;

class PostCategoryController extends Controller
{

    private InterfacePostCategoryRepository $interfacePostCategoryRepository;

    public function __construct(InterfacePostCategoryRepository $interfacePostCategoryRepository)
    {

        $this->interfacePostCategoryRepository = $interfacePostCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(PostCategoryRequest $request)
    {

        $count=@$request->count ?? 10;
        $name=@$request->name;
        $status=@$request->status;
        $postCategories=$this->interfacePostCategoryRepository->query();


        if(@$status != null)
            $postCategories=$postCategories->whereStatus($status);

        if(@$name)
            $postCategories=$postCategories->where('name','like',"%{$name}%");

        return PostCategoryResource::collection($postCategories->paginate($count));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostCategoryRequest $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(PostCategory $postCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory)
    {
        //
    }
}
