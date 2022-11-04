<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vistor;
use Auth;
use Hash;

/**
 * Class UserService.
 */
class UserService
{

    public static function getAllUsers()
    {

        $users = User::paginate(5)->onEachSide(0);
        return $users;
    }
    public static function table($pageNumber)
    {

        $users = User::paginate(5, ['*'], 'page', $pageNumber)->withPath(route("users.index"))->onEachSide(0);
        return $users;
    }



    public static function store($request)
    {

        $data = $request->all();

        $user = User::where("name", $request->name);

        if ($user->exists()) {
            $data["success"] = false;
            $data["message"] = "هذا المشرف موجود بالفعل !";
            return $data;
        }

        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();


        $photo = null;
        $photoName = null;

        if ($request->hasFile("photo")) {
            $photo = $request->file("photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();
            $photo->move($path . "/images/users", "$photoName");
            $photoName = "/images/users/" . $photoName;
        }
        $password = Hash::make("");
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photoName;

        $user = User::create($data);
        $roles = explode(",", $request->roles);
        $user->syncRoles($roles);

        $data["success"] = true;
        $data["message"] = "تم اضافة المشرف بنجاح";

        return $data;
    }



    public static function show($id)
    {
        $user = User::with("roles", "permissions")->findOrfail($id);
        return $user;
    }


    public static function destroy($id)
    {
        $user = User::findOrFail($id);
        $data["user"] = $user;
        $user->delete();

        //Delete Old Photo
        DeleteService::deleteFile($user->user_photo);

        return $user;
    }

    public static function destroyAll()
    {
        User::role("");

        //Delete All Photos
        DeleteService::deleteAllFiles("/images/users");

        return true;
    }

    public static function createLoginDataIfNotExists()
    {

        $data = null;
        if (User::count() < 1) {
            $data["password"] = Hash::make("owner");
            $data["name"] = "owner";
            $data = User::create($data);
        }
        return $data;
    }


    public static function update($request, $id)
    {
        $data = $request->all();

        $user = User::find($id);

        $oldUser = User::where("name", $request->name);

        if ($oldUser->exists() && $oldUser->first()->name != $user->name) {
            $data["success"] = false;
            $data["message"] = "هذا المشرف موجود بالفعل";

            return $data;
        }


        $path = null;
        if (file_exists(public_path()))
            $path = public_path();
        else
            $path = base_path();



        $photo = null;
        $photoName = $user->photo;
        if ($request->hasFile("photo")) {
            $photo = $request->file("photo");
            $photoName = time() . "." . $photo->getClientOriginalExtension();

            // Delete Old Photo
            DeleteService::deleteFile($user->photo);


            $photo->move($path . "/images/users", "$photoName");
            $photoName = "/images/users/" . $photoName;
        }
        $password = $user->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photoName;

        $user->update($data);
        $roles = explode(",", $request->roles);
        $user->syncRoles($roles);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset($photoName);

        return $data;
    }
}
