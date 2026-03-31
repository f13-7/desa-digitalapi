<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\HeadOfFamilyStoreRequest;
use App\Http\Resources\HeadOfFamilyResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\HeadOfFamilyRepositoryInterface;
use Illuminate\Http\Request;

class HeadOfFamilyController extends Controller
{
 private HeadOfFamilyRepositoryInterface $headOfFamilyRepository;

    public function __construct(HeadOfFamilyRepositoryInterface $headOfFamilyRepository) {
        $this->headOfFamilyRepository = $headOfFamilyRepository;
    }
    public function index(Request $request)
    {
        try{
            $headOfFamilies = $this->headOfFamilyRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
           return ResponseHelper::jsonResponse(true, 'Data kepala keluarga Berhasi+l Diambil', HeadOfFamilyResource::collection($headOfFamilies), 200);
        } catch(\Exception $e){
            return ResponseHelper::jsonResponse(true, 'Data kepala keluarga Gagal Diambil', null, 500);
        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer'
        ]);

        try {
            $headOfFamilies = $this->headOfFamilyRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(true,  'Data kepala keluarga Berhasil Diambil', PaginateResource::make($headOfFamilies, HeadOfFamilyResource::class), 200);

        } catch(\Exception $e){
            return ResponseHelper::jsonResponse(true, 'Data kepala keluarga Gagal Diambil', null, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeadOfFamilyStoreRequest $request)
    {
        $request = $request->validated();

        try{
            $user = $this->headOfFamilyRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Kepala Keluarga berhasil ditambahkan', new HeadOfFamilyResource($user), 201);

        }
        catch(\Exception $e){
            return ResponseHelper::jsonResponse(false, $e->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $user = $this->userRepository->getById($id);

            return ResponseHelper::jsonResponse(true,'Detail user berhasil diambil', new UserResource($user), 200);
        }

    catch(\Exception $e){
        return ResponseHelper::jsonResponse(false, $e->getMessage(), null,500);
    }

    if (!$user) {
        return ResponseHelper::jsonResponse(false,'User tidak ditemukan', null,404);
    }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $request = $request->validated();

         try{
            $user = $this->userRepository->getById($id);
         if (!$user) {
         return ResponseHelper::jsonResponse(false,'User tidak ditemukan', null,404);
         }
    $user = $this->userRepository->update($id, $request);
    

            return ResponseHelper::jsonResponse(true,'Data user berhasil diupdate', new UserResource($user), 200);
        }  catch(\Exception $e){
        return ResponseHelper::jsonResponse(false, $e->getMessage(), null,500);
           }
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                 try{
            $user = $this->userRepository->getById($id);
         if (!$user) {
         return ResponseHelper::jsonResponse(false,'User tidak ditemukan', null,404);
         }
    $user = $this->userRepository->delete($id);
    

            return ResponseHelper::jsonResponse(true,'Data user berhasil dihapus', new UserResource($user), 200);
        }  catch(\Exception $e){
        return ResponseHelper::jsonResponse(false, $e->getMessage(), null,500);
           }
    }
}
