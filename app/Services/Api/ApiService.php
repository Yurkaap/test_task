<?php

namespace App\Services\Api;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApiService
{
    public function createUser(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        return $user;
    }

    public function recoverPassword(array $data): ?string
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return null;
        }

        $password = rand(1000, 9999).'-'.rand(1000, 9999);
        $user->password = Hash::make($password);
        $user->save();

        return $password;
    }

    public function createUserCompany(array $data)
    {
        $company = Company::create($data);

        if (!$company) {
            return null;
        }

        DB::table('users_companies')->insert(['user_id' => (int) $data['user_id'], 'company_id' => (int) $company->id]);

        return $company;
    }

    public function getUserCompanies(int $id): Collection
    {
        return DB::table('users_companies')
            ->join('companies', 'companies.id', '=', 'users_companies.company_id')
            ->where('users_companies.user_id', '=', $id)
            ->select('companies.id', 'companies.title', 'companies.phone', 'companies.description')
            ->orderBy('companies.id')
            ->get();
    }
}
