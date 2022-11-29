<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function index()
    {
        //menuju halaman rekomendasi
        return view('rekomendasi');
    }

    public function store(Request $request)
    {
        $keluhan = $request->keluhan;
        // $tahun = $request->tahun;
        // dd($tahun);
    
        $rekom = new Penggunaan($keluhan, $request->tahun);
    
        $data = [
            'keluhannya' => $keluhan,
            'khasiatnya' => $rekom->khasiat(),
            'umurnya' => $rekom->umur(),
            'jamunya' => $rekom->namaJamu(),
            'sarannya' => $rekom->saran(),
        ];
    
        return view('rekomendasi', compact('data'));
    }

}

class Jamu
{
    public function __construct($keluhan, $tahun)
    {
        $this->keluhan = $keluhan;
        $this->tahunLahir = date('Y', strtotime($tahun));
    }

    public function umur(){
        return date('Y')-$this->tahunLahir;
    }
    
    public function namaJamu()
    {
        if($this->keluhan == 'Keseleo dan kurang nafsu makan' || $this->keluhan == 'kurang nafsu makan'){
            return 'Beras Kencur';
        }else if($this->keluhan=='Pegal-pegal'){
            return 'Kunyit Asam';
        }else if($this->keluhan=='Darah tinggi dan gula darah' || $this->keluhan == 'gula darah'){
            return 'Brotowali';
        }else if($this->keluhan=='Kram perut dan masuk angin' || $this->keluhan == 'masuk angin'){
            return 'Temulawak';
        }else{
            return 'Tidak ditemukan jamu';
        }
    }

    public function khasiat()
    {
        //menentukan khasiat berdasarkan keluhan
        if ($this->namaJamu() == 'Beras Kencur') {
            return "Meredakan keseleo dan menambah nafsu makan.";
        }elseif ($this->namaJamu() == 'Kunyit Asam') {
            return "Meredakan pegal-pegal.";
        }elseif ($this->namaJamu() == 'Brotowali') {
            return "Menurunkan kadar gula darah.";
        }elseif ($this->namaJamu() == 'Temulawak') {
            return "Meredakan kram perut.";
        }else {
            return "Tidak ditemukan khasiat";
        }
    }

}

class Penggunaan extends Jamu
{
    public function saran(){// method saran
        if($this->umur()<=10){
            $status = 'Dikonsumsi 1x';
        }else{
            $status = 'Dikonsumsi 2x';
        }

        if($this->namaJamu() == 'Beras Kencur' && $this->keluhan == 'keseleo'){
            $penggunaan = 'Dioleskan';
        }else{
            $penggunaan = 'Dikonsumsi';
        }

        return 'Pengkonsumsian : '. $status . ' & '. 'Penggunaan : '. $penggunaan;

    }
}