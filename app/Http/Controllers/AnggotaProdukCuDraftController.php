<?php
namespace App\Http\Controllers;

use DB;
use Auth;
use File;
use Image;
use Validator;
use App\AnggotaCu;
use App\AnggotaCuCu;
use App\AnggotaCuKlaim;
use App\Support\Helper;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\AnggotaProdukCu;
use App\AnggotaProdukCuTransaksi;
use App\AnggotaProdukCuDraft;
use Illuminate\Http\Request;
use Venturecraft\Revisionable\Revision;
use App\Imports\AnggotaCuDraftImport;

class AnggotaProdukCuDraftController extends Controller{

	protected $imagepath = 'images/anggotaCu/';
	protected $width = 300;
	protected $height = 200;
	protected $message = "Anggota CU";

	public function index($cu)
	{
		if($cu == 'semua'){
			$table_data = AnggotaProdukCuDraft::with('cu','produk_cu','anggota_cu')->advancedFilter();	
		}else{
			$table_data = AnggotaProdukCuDraft::with('cu','produk_cu','anggota_cu')->where('id_cu', $cu)->advancedFilter();	
		}
		
		return response()
			->json([
				'model' => $table_data
			]);
	}

	public function store($id)
	{
		$anggotaProdukCuDraft = AnggotaProdukCuDraft::findOrFail($id);

		$anggotaProdukCu = AnggotaProdukCu::where('anggota_cu_id', $anggotaProdukCuDraft->anggota_cu_id)->where('produk_cu_id', $anggotaProdukCuDraft->produk_cu_id)->where('no_rek', $anggotaProdukCuDraft->no_rek)->first();

		\DB::beginTransaction(); 
		try{
			if($anggotaProdukCu){
				$anggotaProdukCu->update([
					'anggota_cu_cu_id' => $anggotaProdukCuDraft->anggota_cu_cu_id,
					'produk_cu_id' => $anggotaProdukCuDraft->produk_cu_id,
					'saldo' => $anggotaProdukCuDraft->saldo,
					'no_rek' => $anggotaProdukCuDraft->no_rek,
					'tanggal' => $anggotaProdukCuDraft->tanggal_buka,
					'tanggal_target' => $anggotaProdukCuDraft->tanggal_target,
					'lama_pinjaman' => $anggotaProdukCuDraft->lama_pinjaman,
					'tujuan' => $anggotaProdukCuDraft->tujuan,
				]);	
		
				AnggotaProdukCuDraftTransaksi::create([
					'anggota_produk_cu_id' => $kelas->id,
					'saldo' => $anggotaProdukCuDraft->saldo,
					'tanggal' => $anggotaProdukCuDraft->tanggal_transaksi,
					'lama_sisa_pinjaman' => $anggotaProdukCuDraft->lama_sisa_pinjaman,
				]);

				$anggotaProdukCuDraft->delete();
			}else{
				$kelas = AnggotaProdukCu::create([
					'anggota_cu_id' => $anggotaProdukCuDraft->anggota_cu_id,
					'anggota_cu_cu_id' => $anggotaProdukCuDraft->anggota_cu_cu_id,
					'produk_cu_id' => $anggotaProdukCuDraft->produk_cu_id,
					'saldo' => $anggotaProdukCuDraft->saldo,
					'no_rek' => $anggotaProdukCuDraft->no_rek,
					'tanggal' => $anggotaProdukCuDraft->tanggal_buka,
					'tanggal_target' => $anggotaProdukCuDraft->tanggal_target,
					'lama_pinjaman' => $anggotaProdukCuDraft->lama_pinjaman,
					'tujuan' => $anggotaProdukCuDraft->tujuan,
				]);
		
				AnggotaProdukCuTransaksi::create([
					'anggota_produk_cu_id' => $kelas->id,
					'saldo' => $anggotaProdukCuDraft->saldo,
					'tanggal' => $anggotaProdukCuDraft->tanggal_transaksi,
					'lama_sisa_pinjaman' => $anggotaProdukCuDraft->lama_sisa_pinjaman,
				]);

				$anggotaProdukCuDraft->delete();
			}

			\DB::commit();

			return response()
				->json([
					'saved' => true,
					'message' => 'Produk anggota CU berhasil ditambah'
				]);	
		} catch (\Exception $e){
			\DB::rollBack();
			abort(500, $e->getMessage());
		}	
	}

	public function storeAll($cu)
	{
		if($cu == 'semua'){
			$anggotaProdukCuDraft = AnggotaProdukCuDraft::get();
		}else{
			$anggotaProdukCuDraft = AnggotaProdukCuDraft::where('id_cu', $cu)->get();
		}

		\DB::beginTransaction(); 
		try{
			foreach($anggotaProdukCuDraft as $item){
				$anggotaProdukCu = AnggotaProdukCu::where('anggota_cu_id', $item->anggota_cu_id)->where('produk_cu_id', $item->produk_cu_id)->where('no_rek', $item->no_rek)->first();

				if($anggotaProdukCu){
					$selisih_saldo = $item->saldo - $anggotaProdukCu->saldo;
					
					$anggotaProdukCu->update([
						'anggota_cu_cu_id' => $item->anggota_cu_cu_id,
						'produk_cu_id' => $item->produk_cu_id,
						'saldo' => $item->saldo,
						'no_rek' => $item->no_rek,
						'tanggal' => $item->tanggal_buka,
						'tanggal_target' => $item->tanggal_target,
						'lama_pinjaman' => $item->lama_pinjaman,
						'tujuan' => $item->tujuan,
					]);	
			
					AnggotaProdukCuTransaksi::create([
						'anggota_produk_cu_id' => $anggotaProdukCu->id,
						'saldo' => $selisih_saldo,
						'tanggal' => $item->tanggal_transaksi,
						'lama_sisa_pinjaman' => $item->lama_sisa_pinjaman,
					]);
				}else{
					$kelas = AnggotaProdukCu::create([
						'anggota_cu_id' => $item->anggota_cu_id,
						'anggota_cu_cu_id' => $item->anggota_cu_cu_id,
						'produk_cu_id' => $item->produk_cu_id,
						'saldo' => $item->saldo,
						'no_rek' => $item->no_rek,
						'tanggal' => $item->tanggal_buka,
						'tanggal_target' => $item->tanggal_target,
						'lama_pinjaman' => $item->lama_pinjaman,
						'tujuan' => $item->tujuan,
					]);
			
					AnggotaProdukCuTransaksi::create([
						'anggota_produk_cu_id' => $kelas->id,
						'saldo' => $item->saldo,
						'tanggal' => $item->tanggal_transaksi,
						'lama_sisa_pinjaman' => $item->lama_sisa_pinjaman,
					]);	
				}
			}
			
			$anggotaProdukCuDraft->each->delete();

			\DB::commit();

			return response()
				->json([
					'saved' => true,
					'message' => 'Produk anggota CU berhasil ditambah'
				]);	
		} catch (\Exception $e){
			\DB::rollBack();
			abort(500, $e->getMessage());
		}	
	}

	public function edit($id)
	{
		$kelas = AnggotaProdukCuDraft::with('anggota_cu')->findOrFail($id);

		return response()
			->json([
					'form' => $kelas,
					'option' => []
			]);
	}


	public function update(Request $request, $id)
	{
		$kelas = AnggotaProdukCuDraft::findOrFail($id);

		$kelas->update([
			'anggota_cu_cu_id' => $request->anggota_cu_cu_id,
			'produk_cu_id' => $request->produk_cu['id'],
			'saldo' => $request->saldo,
			'no_rek' => $request->no_rek,
			'tanggal' => $request->tanggal,
			'tanggal_target' => $request->tanggal_target,
			'lama_pinjaman' => $request->lama_pinjaman,
			'tujuan' => $request->tujuan,
		]);	
		
		return response()
			->json([
				'saved' => true,
				'message' => 'Produk anggota CU berhasil diubah'
			]);
	}


	public function destroy($id)
	{
		$kelas = AnggotaProdukCuDraft::findOrFail($id);
		$kelas->delete();

		return response()
			->json([
				'deleted' => true,
				'message' => 'Produk anggota CU berhasil dihapus'
			]);
	}

	public function destroyAll($cu)
	{
		if($cu == 'semua'){
			$kelas = AnggotaProdukCuDraft::get();
			$kelas->each->delete();
		}else{
			$kelas = AnggotaProdukCuDraft::where('id_cu', $cu)->get();
			$kelas->each->delete();
		}

		return response()
			->json([
				'deleted' => true,
				'message' => 'Produk anggota CU berhasil dihapus'
			]);
	}

	public function count($cu)
	{
		if($cu == 'semua'){
			$table_data = AnggotaProdukCuDraft::count();
		}else{
			$table_data = AnggotaProdukCuDraft::where('id_cu', $cu)->count();
		}

		return response()
		->json([
				'model' => $table_data
		]);
	}
}