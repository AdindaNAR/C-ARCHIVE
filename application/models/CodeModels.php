<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CodeModels extends CI_Model
{
    function create_code_user(){
        $this->db->select('RIGHT(tbl_user.id_user,5) as kode', FALSE);
        $this->db->order_by('id_user', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_user');   
        if ($query->num_rows() <> 0) {

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodejadi = "P" . $kodemax;
        return $kodejadi;
    }

    function create_code_toko(){
        $date = date('Ymd');
        $cari = "TK".$date;
        $this->db->select('RIGHT(tbl_toko.id_toko,8) as kode', FALSE);
        $this->db->like('id_toko', $cari); // where like untuk mengambil data pada kode TK dan tanggal sekarang
        $this->db->order_by('id_toko', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_toko');    
        if ($query->num_rows() <> 0) {

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT);
       
        $kodejadi = "TK" . $date .'-'. $kodemax;
        return $kodejadi;
    }

    function create_code_lantai(){
        $date = date('Ymd'); // fungsi ambil tanggal hari ini
        $cari = "LT".$date;
        $this->db->select('RIGHT(tbl_lantai.id_lantai,5) as kode', FALSE);
        $this->db->like('id_lantai', $cari); // where like untuk mengambil data pada tanggal sekarang
        $this->db->order_by('id_lantai', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_lantai');   
        if ($query->num_rows() <> 0) {

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else {
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT);
        $kodejadi = "LT" . $date .'-'. $kodemax;
        return $kodejadi;
    }

    function create_code_po(){
        $this->db->select('RIGHT(tbl_detail_barang.no_po,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->order_by('no_po', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_detail_barang'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
        $date = date('Ymd');
        $kodejadi = "PO" . $date .'-'. $kodemax; 
        return $kodejadi;
    }

    function create_code_riwayat(){
        $date = date('Ymd'); // fungsi ambil tanggal hari ini
        $cari = "RW".$date;
        $this->db->select('RIGHT(tbl_riwayat.id_riwayat,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->like('id_riwayat', $cari);
        $this->db->order_by('id_riwayat', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_riwayat'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
        $kodejadi = "RW" . $date .'-'. $kodemax; 
        return $kodejadi;
    }
    function create_code_penjualan(){
        $date = date('Ymd'); // fungsi ambil tanggal hari ini
        $cari = "PJ".$date;
        $this->db->select('RIGHT(tbl_penjualan.id_penjualan,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->like('id_penjualan', $cari);
        $this->db->order_by('id_penjualan', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_penjualan'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
        $kodejadi = "PJ" . $date .'-'. $kodemax; 
        return $kodejadi;
    }

    function create_code_faktur(){
        $this->db->select('RIGHT(tbl_riwayat.no_faktur,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->order_by('no_faktur', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_riwayat'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
        $kodejadi = "FK" . $kodemax; // hasilnya L00001-dst.
        return $kodejadi;
    }

    function create_code_barang(){ 
        $date = date('Ymd');
        $cari = "BRG".$date;
        $this->db->select('RIGHT(tbl_barang.id_barang,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->like('id_barang', $cari);
        $this->db->order_by('id_barang', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_barang'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
       
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
        $kodejadi = "BRG" . $date .'-'. $kodemax; // hasilnya -dst.
        return $kodejadi;
    }

    function create_code_det_barang(){
        $date = date('Ymd');
        $cari = "DT".$date;
        $this->db->select('RIGHT(tbl_detail_barang.id_detail_barang,5) as kode', FALSE);
        $this->db->like('id_detail_barang', $cari); // membaca 5 karakter dari kanan
        $this->db->order_by('id_detail_barang', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_detail_barang'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 5, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
    
        $kodejadi = "DT" . $date .'-'. $kodemax; 
        return $kodejadi;
    }

    // function create_code_brand(){
    //     $date = date('Ymd');
    //     $cari = "BD".$date;
    //     $this->db->select('RIGHT(tbl_brand.id_brand,5) as kode', FALSE); // membaca 5 karakter dari kanan
    //     $this->db->like('id_brand', $cari);
    //     $this->db->order_by('id_brand', 'DESC');
    //     $this->db->limit(1);
    //     $query = $this->db->get('tbl_brand'); // cek dulu apakah ada sudah ada kode di tabel.    
    //     if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

    //         $data = $query->row();
    //         $kode = intval($data->kode) + 1;
    //     } else { // jika kode belum ada 
    //         $kode = 1;
    //     }
    //     $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
    //     $kodejadi = "BD" . $date .'-'. $kodemax; 
    //     return $kodejadi;
    // }

    function create_code_wajib_pajak(){
        $date = date('Ymd');
        $cari = "WP".$date;
        $this->db->select('RIGHT(tbl_wajib_pajak.id_wajib_pajak,8) as kode', FALSE); // membaca 8 karakter dari kanan
        $this->db->like('id_wajib_pajak', $cari);
        $this->db->order_by('id_wajib_pajak', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_wajib_pajak'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT); // angka 8 menunjukkan jumlah digit angka 0
       
        $kodejadi = "WP" . $date .'-'. $kodemax; 
        return $kodejadi;
    }

    function create_code_pajak(){
        $date = date('Ymd');
        $cari = "PJK".$date;
        $this->db->select('RIGHT(tbl_pajak.id_pajak,8) as kode', FALSE); // membaca 8 karakter dari kanan
        $this->db->like('id_pajak', $cari);
        $this->db->order_by('id_pajak', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_pajak'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT); // angka 8 menunjukkan jumlah digit angka 0
       
        $kodejadi = "PJK" . $date .'-'. $kodemax; 
        return $kodejadi;
    }
    
    function create_code_harga(){
        $date = date('Ymd');
        $cari = "HG".$date;
        $this->db->select('RIGHT(tbl_harga.id_harga,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->like('id_harga', $cari);
        $this->db->order_by('id_harga', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_harga'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
        $kodejadi = "HG" . $date .'-'. $kodemax; 
        return $kodejadi;
    }
    function create_code_diskon(){
        $date = date('Ymd');
        $cari = "DC".$date;
        $this->db->select('RIGHT(tbl_diskon.id_diskon,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->like('id_diskon', $cari);
        $this->db->order_by('id_diskon', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_diskon'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
        $kodejadi = "DC" . $date .'-'. $kodemax; 
        return $kodejadi;
    }
    function create_code_cashback(){
        $date = date('Ymd');
        $cari = "CB".$date;
        $this->db->select('RIGHT(tbl_cashback.id_cashback,5) as kode', FALSE); // membaca 5 karakter dari kanan
        $this->db->like('id_cashback', $cari);
        $this->db->order_by('id_cashback', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_cashback'); // cek dulu apakah ada sudah ada kode di tabel.    
        if ($query->num_rows() <> 0) { // jika kode ternyata sudah ada. 

            $data = $query->row();
            $kode = intval($data->kode) + 1;
        } else { // jika kode belum ada 
            $kode = 1;
        }
        $kodemax = str_pad($kode, 8, "0", STR_PAD_LEFT); // angka 5 menunjukkan jumlah digit angka 0
       
        $kodejadi = "CB" . $date .'-'. $kodemax; 
        return $kodejadi;
    }
}