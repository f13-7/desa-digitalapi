<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\SocialAssistanceRecipentUpdateRequest;
use App\Http\Requests\SocialAssistanceRecipentStoreRequest;
use App\Http\Resources\PaginateResource;
use App\Http\Resources\SocialAssistanceRecipentResource;
use Illuminate\Http\Request;
use App\Interfaces\SocialAssistanceRecipentRepositoryInterface;

class SocialAssistanceRecipentController extends Controller
{
       private SocialAssistanceRecipentRepositoryInterface $socialAssistanceRecipientRepository;


    public function __construct(SocialAssistanceRecipentRepositoryInterface $socialAssistanceRecipientRepository ) 
    {
        $this->socialAssistanceRecipientRepository = $socialAssistanceRecipientRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
             try{
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getAll(
                $request->search,
                $request->limit,
                true
            );
           return ResponseHelper::jsonResponse(true, 'Data anggota keluarga Berhasil Diambil', SocialAssistanceRecipentResource::collection($socialAssistanceRecipients), 200);
        } catch(\Exception $e){
            return ResponseHelper::jsonResponse(true, 'Data anggota keluarga Gagal Diambil', null, 500);
        }
    }
    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string',
            'row_per_page' => 'required|integer'
        ]);

        try {
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getAllPaginated(
                $request['search'] ?? null,
                $request['row_per_page']
            );

            return ResponseHelper::jsonResponse(true,  'Data anggota keluarga Berhasil Diambil', PaginateResource::make($socialAssistanceRecipients,SocialAssistanceRecipentResource::class), 200);

        } catch(\Exception $e){
            return ResponseHelper::jsonResponse(true, 'Data anggota  keluarga Gagal Diambil', null, 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(SocialAssistanceRecipentStoreRequest $request)
    {
              $request = $request->validated();

        try{
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Anggota Keluarga berhasil ditambahkan', new SocialAssistanceRecipentResource
            ($socialAssistanceRecipient), 201);

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
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
            if (!$socialAssistanceRecipient) {
        return ResponseHelper::jsonResponse(false,'Kepala Keluarga tidak ditemukan', null,404);
    }
            return ResponseHelper::jsonResponse(true,'Detail kepala keluarga berhasil diambil', new SocialAssistanceRecipentResource($socialAssistanceRecipient), 200);
        }

    catch(\Exception $e){
        return ResponseHelper::jsonResponse(false, $e->getMessage(), null,500);
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SocialAssistanceRecipentUpdateRequest $request, string $id)
    {
        $request = $request->validated();

         try{
            $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->getById($id);
         if (!$socialAssistanceRecipient) {
           return ResponseHelper::jsonResponse(false,'Kepala Keluarga tidak ditemukan', null,404);
         }
    $socialAssistanceRecipient = $this->socialAssistanceRecipientRepository->update($id, $request);
    

            return ResponseHelper::jsonResponse(true,'Kepala Keluarga berhasil diupdate', new SocialAssistanceRecipentResource($socialAssistanceRecipient), 200);
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
            $socialAssistanceRecipients = $this->socialAssistanceRecipientRepository->getById($id);
         if (!$socialAssistanceRecipients) {
         return ResponseHelper::jsonResponse(false,'Kepala Keluarga tidak ditemukan', null,404);
         }
    $socialAssistances = $this->socialAssistanceRecipientRepository->delete($id);
    

            return ResponseHelper::jsonResponse(true,'Data Kepala Keluarga berhasil dihapus', new SocialAssistanceRecipentResource($socialAssistanceRecipients), 200);
        }  catch(\Exception $e){
        return ResponseHelper::jsonResponse(false, $e->getMessage(), null,500);
           }
    }
}
