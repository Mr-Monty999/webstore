<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vistor;
use Auth;
use Hash;
use Storage;

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


        $photo = null;
        if ($request->hasFile("photo"))
            $photo = $request->file("photo")->store("users", "public");


        $password = Hash::make("");
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photo;

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
        Storage::disk("public")->delete($user->photo);

        return $user;
    }

    public static function destroyAll()
    {
        User::where("id", "!=", Auth::id())->delete();
        //Delete All Photos
        Storage::disk("public")->deleteDirectory("users");

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



        $photo = $oldUser->first()->photo;
        if ($request->hasFile("photo")) {
            Storage::disk("public")->delete($oldUser->first()->photo);
            $photo = $request->file("photo")->store("users", "public");
        }




        $password = $user->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photo;

        $user->update($data);
        $roles = explode(",", $request->roles);
        $user->syncRoles($roles);

        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset("storage/$photo");

        return $data;
    }
    public static function updatePrivacy($request, $id)
    {

        $data = $request->all();

        $user = User::find($id);

        $oldUser = User::where("name", $request->name);

        if ($oldUser->exists() && $oldUser->first()->name != $user->name) {
            $data["success"] = false;
            $data["message"] = "هذا المشرف موجود بالفعل";

            return $data;
        }



        $photo = $oldUser->first()->photo;
        if ($request->hasFile("photo")) {
            Storage::disk("public")->delete($oldUser->first()->photo);
            $photo = $request->file("photo")->store("users", "public");
        }


        $password = $user->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photo;

        $user->update($data);


        $data["success"] = true;
        $data["message"] = "تم الحفظ بنجاح";
        $data["photo_path"] = asset("storage/$photo");

        return $data;
    }
}
