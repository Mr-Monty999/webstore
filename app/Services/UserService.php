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
    public static function login($data)
    {

        if (Auth::attempt($data, true)) {
            $user = Auth::user();
            $user["token"] = $user->createToken(uniqid())->plainTextToken;
            $user->getAllPermissions();
            return $user;
        }
        return false;
    }
    public static function table($pageNumber)
    {

        $users = User::paginate(5, ['*'], 'page', $pageNumber)->withPath(route("users.index"))->onEachSide(0);
        return $users;
    }

    public static function userExists($name)
    {
        $userExists =  User::where("name", "=", $name)->exists();
        return $userExists;
    }

    public static function store($request)
    {

        $data = $request->all();


        $photo = null;
        if ($request->hasFile("photo"))
            $photo = $request->file("photo")->store("users", "public");


        $password = Hash::make("");
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photo;

        $user = User::create($data);

        if ($request->roles) {
            if (!is_array($request->roles)) {
                $roles = explode(",", $request->roles);
                $user->syncRoles($roles);
            } else
                $user->syncRoles($request->roles);
        }
        $user["photo_path"] = asset("storage/$photo");


        $user->getAllPermissions();


        return $user;
    }



    public static function show($id)
    {
        $user = User::with("roles.permissions")->findOrfail($id);
        $user["photo_path"] = asset("storage/$user->photo");

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
        $users =  User::where("id", "!=", Auth::id());
        //Delete All Photos
        Storage::disk("public")->delete($users->pluck("photo")->toArray());
        $users->delete();

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




        $photo = $user->photo;

        if ($request->hasFile("photo")) {
            Storage::disk("public")->delete($user->photo);
            $photo = $request->file("photo")->store("users", "public");
        }


        $password = $user->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photo;

        $user->update($data);
        if ($request->roles) {
            if (!is_array($request->roles)) {
                $roles = explode(",", $request->roles);
                $user->syncRoles($roles);
            } else
                $user->syncRoles($request->roles);
        }

        $user->getAllPermissions();


        $user["photo_path"] = asset("storage/$photo");

        return $user;
    }
    public static function updatePrivacy($request, $id)
    {

        $data = $request->all();

        $user = User::find($id);


        $photo = $user->photo;
        if ($request->hasFile("photo")) {
            Storage::disk("public")->delete($user->photo);
            $photo = $request->file("photo")->store("users", "public");
        }


        $password = $user->password;
        if (trim($request->password) != "")
            $password = Hash::make(trim($request->password));

        $data["password"] = $password;
        $data["photo"] = $photo;

        $user->update($data);
        $user->getAllPermissions();

        $user["photo_path"] = asset("storage/$photo");

        return $user;
    }
}
