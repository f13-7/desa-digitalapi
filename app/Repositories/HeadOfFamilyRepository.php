<?php 

namespace App\Repositories;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use App\Models\HeadOfFamily;
use DB;
use Exception;
use App\Repositories\UserRepository;

class HeadOfFamilyRepository implements HeadOfFamilyRepositoryInterface
{
        public function getAll(?string $search, ?int $limit, bool $execute)
    {
      $query = HeadOfFamily::where(function ($query) use ($search){
        if($search){
            $query->search($search);
        }
    });
       $query->orderBy('created_at','desc');
       if ($limit){
        $query->take($limit);

       }
       if ($execute) {
        return $query->get();
       }

       return $query;
    }
        public function getAllPaginated(?string $search,?int $rowPerPage) {
            $query = $this->getAll(
                $search,
                $rowPerPage,
                false
            );

            return $query->paginate($rowPerPage);
         }

          public function create(array $data){
      DB::beginTransaction();

          try {
             $userRepository = new UserRepository($data);

             $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
             ]);
             $headOfFamily =  new HeadOfFamily;
             $headOfFamily->user_id = $user->id;
             $headOfFamily-> profile_picture  = $data['profile_picture']->asset('assets/head-of-families', 'public');
        $headOfFamily->identity_number = $data['identity_number'];
        $headOfFamily->gender  = $data['gender'];
        $headOfFamily->date_of_birth = $data['date_of_birth'];
        $headOfFamily->phone_number = $data['phone_number'];
        $headOfFamily->occupation = $data['occupation'];
        $headOfFamily->marital_status = $data['marital_status'];
             $headOfFamily->save();

             DB::commit();

             return $user;
             } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
          }
      }
        public function update(string $id, array $data) {
          DB::beginTransaction();

          try {
             $user = User::find($id);
             $user->name = $data['name'];

             if (isset($data['password']))  { 
                $user->password = bcrypt($data['password']);
             }
             $user->save();

             DB::commit();

             return $user;
             } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
          }
        
      }

      public function delete(string $id)
      {
        DB::beginTransaction();

     try {
             $headOfFamily = HeadOfFamily::find($id);
             $headOfFamily->delete();
             DB::commit();


             return $headOfFamily;
             } catch (\Exception $e) {
                    DB::rollBack();
                    throw new Exception($e->getMessage());
          }
      }
}