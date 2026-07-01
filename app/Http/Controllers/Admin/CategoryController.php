<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    function index(): View
    {
        return view('admin.category.index');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ]);


        if ($data['parent_id'] ?? null) {

            $parent = Category::find($data['parent_id']);

            $depth = 1;

            while ($parent) {

                $depth++;

                $parent = $parent->parent;

                if ($depth >= 3) {
                    break;
                }
            }

            if ($depth >= 3) {
                throw ValidationException::withMessages(['parent_id' => 'Maximum depth reached']);
            }
        }



        $data['position'] = Category::where('parent_id', $data['parent_id'] ?? null)->max('position') + 1;
        $category = Category::create($data);
        return response()->json(['success' => true, 'message' => 'Đã tạo danh mục thành công', 'category' => $category]);
    }

    function update(Request $request, int $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ]);


        if ($data['parent_id'] ?? null) {

            $parent = Category::find($data['parent_id']);

            $depth = 1;

            while ($parent && $parent->parent_id) {

                $depth++;

                $parent = $parent->parent;

                if ($depth >= 3) {
                    break;
                }
            }

            if ($depth >= 3) {
                throw ValidationException::withMessages(['parent_id' => 'Maximum depth reached']);
            }
        }



        $data['is_active'] = $data['is_active'] ?? false;
        $category = $category->update($data);
        return response()->json(['success' => true, 'message' => 'Đã cập nhật danh mục thành công', 'category' => $category]);
    }

    function updateOrder(Request $request)
    {
        $tree = $request->tree;
        try {
            DB::transaction(function () use ($tree) {
                $this->updateTree($tree, null);
            });
            return response()->json(['success' => true, 'message' => 'Đã cập nhật thứ tự danh mục thành công']);
        } catch (\Exception $th) {
            Log::error('Failed to update category order: ', [$th]);
            return response()->json(['success' => false, 'message' =>  $th->getMessage()], 500);
        }
    }

    function show(int $id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    function destroy(int $id)
    {
        $category = Category::findOrFail($id);

        if ($category->children()->count() > 0) {
            return response()->json(['error' => true, 'message' => 'Không thể xóa danh mục có danh mục con'], 400);
        }
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Đã xóa danh mục thành công']);
    }

    function updateTree($nodes, $parentId)
    {
        foreach ($nodes as $position => $node) {
            $category = Category::find($node['id']);
            $category->update([
                'parent_id' => $parentId,
                'position' => $position
            ]);
            if (isset($node['children']) && is_array($node['children'])) {
                $this->updateTree($node['children'], $category->id);
            }
        }
    }

    function getNestedCategories()
    {
        $categories = Category::getNested();
        return response()->json($categories);
    }
}
