<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::whereRaw(1);

        if ($request->n)
            $users->where('name', 'like', '%' . $request->n . '%');

        if ($request->p)
            $users->where('phone', 'like', '%' . $request->p . '%');

        if ($request->e)
            $users->where('email', 'like', '%' . $request->e . '%');

        $users = $users->orderByDesc('id')->paginate(20);

        $viewData = [
            'users' => $users,
            'query' => $request->query()
        ];

        return view('admin.pages.user.index', $viewData);
    }

    public function view(Request $request, $id)
    {
        $user     = User::find($id);

        $rooms      = Room::with('category:id,name,slug','city:id,name,slug','district:id,name,slug','wards:id,name,slug')
            ->where("auth_id", $id);

        if ($request->category_id)
            $rooms->where('category_id', $request->category_id);

        if ($request->n)
            $rooms->where('name', 'like', '%' . $request->n . '%');

        $rooms      = $rooms->orderByDesc('id')->paginate(20);
        $categories = Category::select('id', 'name')->get();

        $viewData   = [
            'rooms'      => $rooms,
            'categories' => $categories,
            'query'      => $request->query(),
            'user' => $user
        ];

        return view('admin.pages.user.view', $viewData);
    }

    public function edit($id)
    {
        $user     = User::find($id);
        $viewData = [
            'user' => $user
        ];

        return view('admin.pages.user.update', $viewData);
    }

    public function update($id, Request $request)
    {
        try {
            $data               = $request->except('_token','avatar');
            $data['updated_at'] = Carbon::now();

            if ($request->avatar) {
                $file = upload_image('avatar');
                if (isset($file) && $file['code'] == 1) {
                    $data['avatar'] = $file['name'];
                }
            }

            User::find($id)->update($data);

            return redirect()->route('get_admin.user.index');
        } catch (\Exception $exception) {
            Log::error("---------------------  " . $exception->getMessage());
            return redirect()->back();
        }
    }

    public function delete($id)
    {
        User::find($id)->delete();
        return redirect()->back();
    }
}
