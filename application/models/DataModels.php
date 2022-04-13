<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataModels extends CI_Model
{
    // GENERAL FUNCTION
    function get_one_table($table)
    {
        $query = $this->db->get_where($table);
        return $query->result();
    }

    function get_where_table($where, $table)
    {
        $query = $this->db->get_where($table, $where);
        return $query->result();
    }

    function create($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function update($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    function delete($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function cek_data($table, $where)
    {
        return $this->db->get_where($table, $where);
    }
    // END GENERAL FUNCTION

    // MODEL UNTUK DASHBOARD ADMIN
    function tampil_user()
    {
        $hsl = $this->db->query("SELECT COUNT(id_user) as total_user FROM tbl_user WHERE id_user != 'P00001' AND data_status = 1");
        return $hsl;
    }

    function tampil_toko()
    {
        $this->db->select('COUNT(id_toko) as total_toko');
        $this->db->where('data_status', 1);
        $hasil = $this->db->get('tbl_toko');
        return $hasil;
    }

    function tampil_brand()
    {
        $this->db->select('COUNT(id_brand) as total_brand');
        $this->db->where('data_status', 1);
        $hasil = $this->db->get('tbl_brand');
        return $hasil;
    }

    function tampil_barang()
    {
        $this->db->select('COUNT(id_barang) as total_barang');
        $this->db->where('data_status', 1);
        $hasil = $this->db->get('tbl_barang');
        return $hasil;
    }

    function tampil_detail_barang_by_jenis()
    {
        $this->db->select('count(id_barang) as total_barang');
        $this->db->where('data_status', 1);
        $this->db->where('status_order <=', 2);
        $this->db->group_by('id_barang');
        $hasil = $this->db->get('tbl_detail_barang');
        return $hasil;
    }

    function tampil_detail_barang_by_item()
    {
        $this->db->select('count(id_detail_barang) as total_detail_barang');
        $this->db->where('data_status', 1);
        $this->db->where('status_order <=', 2);
        $hasil = $this->db->get('tbl_detail_barang');
        return $hasil;
    }

    function tampil_detail_barang_by_jml()
    {
        $this->db->select('COALESCE(SUM(stock_quantity),0) AS jml_barang_PO');
        $this->db->where('data_status', 1);
        $this->db->where('status_order <=', 2);
        $hasil = $this->db->get('tbl_detail_barang');
        return $hasil;
    }

    function tampil_terima_barang_toko_by_jenis()
    {
        $this->db->select('COUNT(tbl_detail_barang.id_barang) as total_barang_toko');
        $this->db->from('tbl_riwayat');
        $this->db->join('tbl_detail_barang', 'tbl_detail_barang.id_detail_barang = tbl_riwayat.id_detail_barang');
        $this->db->where('tbl_riwayat.data_status', 1);
        $this->db->where('tbl_detail_barang.data_status', 1);
        $this->db->group_by('tbl_detail_barang.id_barang');
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_terima_barang_toko_by_item()
    {
        $this->db->select('COUNT(tbl_riwayat.id_detail_barang) as total_detail_barang_toko');
        $this->db->from('tbl_riwayat');
        $this->db->join('tbl_detail_barang', 'tbl_detail_barang.id_detail_barang = tbl_riwayat.id_detail_barang');
        $this->db->where('tbl_riwayat.data_status', 1);
        $this->db->where('tbl_detail_barang.data_status', 1);
        $this->db->group_by('tbl_riwayat.id_detail_barang');
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_terima_barang_toko_by_jml()
    {
        $this->db->select('COALESCE(SUM(banyak),0) AS total_stock_toko');
        $this->db->where('data_status', 1);
        $hasil = $this->db->get('tbl_riwayat');
        return $hasil;
    }

    function tampil_penjualan_by_jenis()
    {
        $this->db->select('COUNT(tbl_detail_barang.id_barang) as total_barang_penjualan');
        $this->db->from('tbl_penjualan');
        $this->db->join('tbl_riwayat', 'tbl_riwayat.id_riwayat = tbl_penjualan.id_riwayat');
        $this->db->join('tbl_detail_barang', 'tbl_detail_barang.id_detail_barang = tbl_riwayat.id_detail_barang');
        $this->db->where('tbl_penjualan.data_status', 1);
        $this->db->where('tbl_riwayat.data_status', 1);
        $this->db->where('tbl_detail_barang.data_status', 1);
        $this->db->group_by('tbl_detail_barang.id_barang');
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_penjualan_by_item()
    {
        $this->db->select('COUNT(tbl_riwayat.id_detail_barang) as total_detail_barang_penjualan');
        $this->db->from('tbl_penjualan');
        $this->db->join('tbl_riwayat', 'tbl_riwayat.id_riwayat = tbl_penjualan.id_riwayat');
        $this->db->join('tbl_detail_barang', 'tbl_detail_barang.id_detail_barang = tbl_riwayat.id_detail_barang');
        $this->db->where('tbl_penjualan.data_status', 1);
        $this->db->where('tbl_riwayat.data_status', 1);
        $this->db->where('tbl_detail_barang.data_status', 1);
        $this->db->group_by('tbl_riwayat.id_detail_barang');
        $hasil = $this->db->get();
        return $hasil;
    }

    function tampil_penjualan_by_jml()
    {
        $this->db->select('COALESCE(SUM(qty),0) AS total_penjualan');
        $this->db->where('data_status', 1);
        $hasil = $this->db->get('tbl_penjualan');
        return $hasil;
    }

    function tampil_lantai()
    {
        $this->db->select('COUNT(id_lantai) as total_lantai');
        $this->db->where('data_status', 1);
        $hasil = $this->db->get('tbl_lantai');
        return $hasil;
    }
    // MODEL UNTUK DASHBOARD ADMIN - END/

    // MASTER DATA FUNCTION
    function get_table_barang($id_toko = null)
    {
        $this->db->select('tbl_barang.id, tbl_barang.id_barang, tbl_barang.nama_barang, tbl_brand.nama_brand, tbl_harga.harga_baru, tbl_barang.deskripsi_barang, tbl_barang.id_diskon, tbl_barang.id_cashback, COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = tbl_barang.id_barang AND data_status=1),0) as total_stock');


        $this->db->join('tbl_brand', 'tbl_barang.id_brand = tbl_brand.id_brand');
        $this->db->join('tbl_access_barang_toko', 'tbl_barang.id_barang = tbl_access_barang_toko.id_barang');
        $this->db->join('tbl_toko', 'tbl_access_barang_toko.id_toko = tbl_toko.id_toko');
        // $this->db->join('tbl_lantai', 'tbl_barang.id_lantai = tbl_lantai.id_lantai');
        $this->db->join('tbl_harga', 'tbl_barang.id_harga = tbl_harga.id_harga');

        $this->db->where('tbl_barang.data_status', 1);
        if (!empty($id_toko)) {
            $this->db->where('tbl_access_barang_toko.id_toko', $id_toko);
        }
        $this->db->order_by('tbl_barang.id_barang', 'ASC');

        $query = $this->db->get_where('tbl_barang');
        return $query->result();
    }

    function get_table_diskon()
    {
        $this->db->select('id_diskon, persentase, order_data');

        $this->db->where('data_status', 1);
        $this->db->order_by('order_data', 'ASC');

        $query = $this->db->get_where('tbl_diskon');
        return $query->result();
    }

    function get_table_cashback()
    {
        $this->db->select('id_cashback, nominal, order_data');

        $this->db->where('data_status', 1);
        $this->db->order_by('order_data', 'ASC');

        $query = $this->db->get_where('tbl_cashback');
        return $query->result();
    }
    // END MASTER DATA FUNCTION


    function get_where_toko_lantai($where, $table)
    {
        $this->db->select('tbl_access_toko_lantai.*, tbl_toko.*, tbl_lantai.*');
        $this->db->join('tbl_toko', 'tbl_access_toko_lantai.id_toko = tbl_toko.id_toko');
        $this->db->join('tbl_lantai', 'tbl_access_toko_lantai.id_lantai = tbl_lantai.id_lantai');

        $this->db->order_by('tbl_access_toko_lantai.id_toko', 'ASC');
        $this->db->order_by('tbl_access_toko_lantai.id_lantai', 'ASC');

        $query = $this->db->get_where($table, $where);
        return $query->result();
    }

    function get_where_toko_lantai_pdf_2($where, $table)
    {
        $this->db->select('tbl_access_toko_lantai.*, tbl_toko.*, tbl_lantai.*');
        $this->db->join('tbl_toko', 'tbl_access_toko_lantai.id_toko = tbl_toko.id_toko');
        $this->db->join('tbl_lantai', 'tbl_access_toko_lantai.id_lantai = tbl_lantai.id_lantai');

        $this->db->group_by('tbl_access_toko_lantai.id_toko');
        $this->db->order_by('tbl_access_toko_lantai.id_toko', 'ASC');
        $this->db->order_by('tbl_access_toko_lantai.id_lantai', 'ASC');

        $query = $this->db->get_where($table, $where);
        return $query->result();
    }

    // function get_barang($id_barang)
    // {
    //     $hsl = $this->db->query("SELECT * FROM tbl_barang a JOIN tbl_harga b ON a.id_harga=b.id_harga where a.id_barang='$id_barang'");
    //     return $hsl;
    // }

    function get_where_brand()
    {
        $SQL = "SELECT * FROM tbl_brand WHERE data_status='1'";
        return $this->db->query($SQL)->result();
    }

    function get_where_user($where, $table)
    {
        $this->db->select('tbl_user.*, tbl_role.*, tbl_toko.*');
        $this->db->join('tbl_role', 'tbl_user.id_role = tbl_role.id_role');
        $this->db->join('tbl_toko', 'tbl_user.id_toko = tbl_toko.id_toko', 'LEFT');
        $this->db->order_by('tbl_user.id_role', 'ASC');

        $query = $this->db->get_where($table, $where);
        return $query->result();
    }

    function get_where_role()
    {
        $SQL = "SELECT * FROM tbl_role WHERE data_status='1' AND id_role!='1'";
        return $this->db->query($SQL)->result();
    }

    function get_where_lantai($where, $table)
    {
        $this->db->select('tbl_access_toko_lantai.*, tbl_toko.*, tbl_lantai.*');
        $this->db->join('tbl_toko', 'tbl_access_toko_lantai.id_toko = tbl_toko.id_toko');
        $this->db->join('tbl_lantai', 'tbl_access_toko_lantai.id_lantai = tbl_lantai.id_lantai');

        $this->db->order_by('tbl_access_toko_lantai.id_toko', 'ASC');
        $this->db->order_by('tbl_access_toko_lantai.id_lantai', 'ASC');

        $query = $this->db->get_where($table, $where);
        return $query->result();
    }

    // function get_lantai_master_data($where, $table)
    // {
    //     $this->db->select('tbl_barang.*, tbl_lantai.*');
    //     $this->db->join('tbl_lantai', 'tbl_barang.id_lantai = tbl_lantai.id_lantai');

    //     $this->db->group_by('tbl_barang.id_lantai');
    //     $this->db->order_by('tbl_barang.id_lantai', 'ASC');

    //     $query = $this->db->get_where($table, $where);
    //     return $query->result();
    // }

    function get_where_lantai_aja($where, $table)
    {
        $this->db->select('tbl_barang.*, tbl_lantai.*');
        $this->db->join('tbl_lantai', 'tbl_barang.id_lantai = tbl_lantai.id_lantai');

        $this->db->group_by('tbl_barang.id_lantai');
        $this->db->order_by('tbl_barang.id_lantai', 'ASC');

        $query = $this->db->get_where($table, $where);
        return $query->result();
    }

    function filter_data_barang($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null, $id_lantai = null, $id_barang = null)
    {
        $this->db->select('a.id_barang,f.harga_baru,e.id_toko,a.deskripsi_barang,a.nama_barang,b.nama_brand,e.nama_toko,a.created_at');
        $this->db->from('tbl_barang a');
        $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
        // $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');
        $this->db->join('tbl_access_barang_toko g', 'a.id_barang=g.id_barang', 'inner');
        $this->db->join('tbl_toko e', ' g.id_toko=e.id_toko', 'inner');
        $this->db->join('tbl_harga f', ' a.id_harga=f.id_harga', 'inner');

        if (!empty($id_toko)) {
            $this->db->where('e.id_toko', $id_toko);
        }

        // if (!empty($id_lantai)) {
        //     $this->db->where('a.id_lantai', $id_lantai);
        // }

        if (!empty($id_barang)) {
            $this->db->where('a.id_barang', $id_barang);
        }

        if (!empty($search)) {
            $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
        }
        $this->db->where('a.data_status', 1);
        $this->db->where('g.data_status', 1);
        $this->db->where('g.id_toko', $id_toko);

        $this->db->order_by('a.created_at', 'asc'); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    // function filter_detail($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null, $id_lantai = null, $id_barang = null, $bulan = null, $tahun = null)
    // {
    //     $this->db->select('a.id_barang,a.id_lantai,a.id_toko,a.deskripsi_barang,a.nama_barang,b.nama_brand,c.nama_lantai,d.id_detail_barang,d.no_po,DATE_FORMAT(d.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,DATE_FORMAT(d.tanggal_masuk,"%m") AS bulan,DATE_FORMAT(d.tanggal_masuk,"%Y") AS tahun,d.stock_sold,d.ukuran,d.stock_quantity,e.nama_toko,(d.stock_quantity - d.stock_sold) AS sisa ');
    //     $this->db->from('tbl_detail_barang d');
    //     $this->db->join('tbl_barang a', ' d.id_barang=a.id_barang', 'left');
    //     $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
    //     $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');
    //     $this->db->join('tbl_toko e', ' e.id_toko=a.id_toko', 'left');

    //     if (!empty($id_toko)) {
    //         $this->db->where('a.id_toko', $id_toko);
    //     }

    //     if (!empty($id_lantai)) {
    //         $this->db->where('a.id_lantai', $id_lantai);
    //     }

    //     if (!empty($id_barang)) {
    //         $this->db->where('a.id_barang', $id_barang);
    //     }

    //     if (!empty($bulan)) {
    //         $this->db->having('bulan',  $bulan);
    //     }
    //     if (!empty($tahun)) {
    //         $this->db->having('tahun',  $tahun);
    //     }
    //     if (!empty($search)) {
    //         $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.ukuran', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.no_po', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.stock_sold', $search); // Untuk menambahkan query where OR LIKE   
    //     }

    //     $this->db->where('d.data_status', 1);
    //     $this->db->where('d.status_order', 0);

    //     $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    //     $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
    //     $query = $this->db->get();
    //     return $query->result_array(); // Eksekusi query sql sesuai kondisi diatas
    // }

    // function filter_detail($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null, $bulan = null, $tahun = null)
    // {
    //     $this->db->select('a.id_barang,a.deskripsi_barang,a.nama_barang,b.nama_brand,c.nama_lantai,d.id_detail_barang,d.no_po,DATE_FORMAT(d.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,DATE_FORMAT(d.tanggal_masuk,"%m") AS bulan,DATE_FORMAT(d.tanggal_masuk,"%Y") AS tahun,d.stock_sold,d.ukuran,d.stock_quantity,e.nama_toko,(d.stock_quantity - d.stock_sold) AS sisa ');
    //     $this->db->from('tbl_detail_barang d');
    //     $this->db->join('tbl_barang a', ' d.id_barang=a.id_barang', 'left');
    //     $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
    //     // $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');
    //     // $this->db->join('tbl_toko e', ' e.id_toko=a.id_toko', 'left');

    //     // if (!empty($id_toko)) {
    //     //     $this->db->where('a.id_toko', $id_toko);
    //     // }

    //     // if (!empty($id_lantai)) {
    //     //     $this->db->where('a.id_lantai', $id_lantai);
    //     // }

    //     if (!empty($id_barang)) {
    //         $this->db->where('a.id_barang', $id_barang);
    //     }

    //     if (!empty($bulan)) {
    //         $this->db->having('bulan',  $bulan);
    //     }
    //     if (!empty($tahun)) {
    //         $this->db->having('tahun',  $tahun);
    //     }
    //     if (!empty($search)) {
    //         $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         // $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.ukuran', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.no_po', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.stock_sold', $search); // Untuk menambahkan query where OR LIKE   
    //     }

    //     $this->db->where('d.data_status', 1);
    //     $this->db->where('d.status_order', 0);

    //     $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    //     $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
    //     $query = $this->db->get();
    //     return $query->result_array(); // Eksekusi query sql sesuai kondisi diatas
    // }

    function filter_detail($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null, $bulan = null, $tahun = null)
    {
        $this->db->select('a.id_barang,a.deskripsi_barang,a.nama_barang,b.nama_brand,d.id_detail_barang,d.no_po,DATE_FORMAT(d.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,DATE_FORMAT(d.tanggal_masuk,"%m") AS bulan,DATE_FORMAT(d.tanggal_masuk,"%Y") AS tahun,d.stock_sold,d.ukuran,d.stock_quantity,(d.stock_quantity - d.stock_sold) AS sisa ');
        $this->db->from('tbl_detail_barang d');
        $this->db->join('tbl_barang a', ' d.id_barang=a.id_barang', 'left');
        $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
        // $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');
        // $this->db->join('tbl_toko e', ' e.id_toko=a.id_toko', 'left');

        // if (!empty($id_toko)) {
        //     $this->db->where('a.id_toko', $id_toko);
        // }

        // if (!empty($id_lantai)) {
        //     $this->db->where('a.id_lantai', $id_lantai);
        // }

        if (!empty($id_barang)) {
            $this->db->where('a.id_barang', $id_barang);
        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }
        if (!empty($tahun)) {
            $this->db->having('tahun',  $tahun);
        }
        if (!empty($search)) {
            $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('d.ukuran', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('d.no_po', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('d.tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('d.stock_sold', $search); // Untuk menambahkan query where OR LIKE   
        }

        $this->db->where('d.data_status', 1);
        $this->db->where('d.status_order', 0);

        $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array(); // Eksekusi query sql sesuai kondisi diatas
    }

    // function filter_master_data($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null, $id_lantai = null, $id_barang = null, $noPo = null, $nabar = null, $nabrand = null, $bulan = null, $tahun = null)
    // {
    //     $this->db->select('
    //                         b.id,
    //                         b.id_barang,
    //                         b.nama_barang,
    //                         c.nama_brand,
    //                         b.id_toko,
    //                         DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
    //                         DATE_FORMAT(a.created_at,"%m") AS bulan,
    //                         DATE_FORMAT(a.created_at,"%Y") AS tahun,
    //                         d.nama_toko,
    //                         e.id_lantai,
    //                         e.nama_lantai,
    //                         CONCAT("Rp. ", format( f.harga_baru, 0)) as harga_baru,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon,
    //                         CONCAT(( SELECT CONCAT("Rp. ", format( nominal, 0)) FROM tbl_cashback WHERE id_cashback = b.id_cashback AND order_data = 1 ), "+", ( SELECT CONCAT("Rp. ", format( nominal, 0)) FROM tbl_cashback WHERE id_cashback = b.id_cashback AND order_data = 2 ), "+", ( SELECT CONCAT("Rp. ", format( nominal, 0)) FROM tbl_cashback WHERE id_cashback = b.id_cashback AND order_data = 3 )) AS cashback,
    //                         CONCAT("Rp. ", format( ((f.harga_baru * ( 1-( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ) / 100 )) - (SELECT sum(nominal) FROM tbl_cashback WHERE id_cashback = b.id_cashback) ), 0)) AS harga_netto,
    //                         COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang AND data_status=1),0) as total_stock,
    //                         b.deskripsi_barang
    //                     ');

    //     $this->db->from('tbl_detail_barang a');
    //     $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'Right');
    //     $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
    //     $this->db->join('tbl_toko d', 'b.id_toko=d.id_toko');
    //     $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
    //     $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
    //     $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
    //     $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');


    //     if (!empty($id_toko)) {
    //         $this->db->where('b.id_toko', $id_toko);
    //     }

    //     if (!empty($id_lantai)) {
    //         $this->db->where('b.id_lantai', $id_lantai);
    //     }

    //     if (!empty($id_barang)) {
    //         $this->db->where('b.id_barang', $id_barang);
    //     }

    //     if (!empty($noPo)) {
    //         $this->db->where('a.no_po', $noPo);
    //     }

    //     if (!empty($nabar)) {
    //         $this->db->where('b.nama_barang', $nabar);
    //     }

    //     if (!empty($nabrand)) {
    //         $this->db->where('c.nama_brand', $nabrand);
    //     }

    //     if (!empty($bulan)) {
    //         $this->db->having('bulan',  $bulan);
    //     }
    //     if (!empty($tahun)) {
    //         $this->db->having('tahun',  $tahun);
    //     }

    //     if (!empty($search)) {
    //         $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.nama_toko', $search); // Untuk menambahkan query where OR LIKE

    //     }

    //     $this->db->where('b.data_status', '1');
    //     $this->db->group_by('b.id_barang');

    //     $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    //     $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
    //     $query = $this->db->get();
    //     return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    // }


    function filter_master_data($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null, $id_toko = null, $noPo = null, $nabar = null, $nabrand = null, $bulan = null, $tahun = null)
    {
        $this->db->select('
                            b.id,
                            b.id_barang,
                            b.nama_barang,
                            c.nama_brand,
                            DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
                            DATE_FORMAT(b.created_at,"%m") AS bulan,
                            DATE_FORMAT(b.created_at,"%Y") AS tahun,
                            d.nama_toko,
                            CONCAT("Rp. ", format( f.harga_baru, 0)) as harga_baru,
                            COALESCE(( SELECT diskon FROM tbl_desc_diskon WHERE id_barang = b.id_barang AND data_status=1),"-") as diskon,
                            COALESCE(( SELECT cashback FROM tbl_desc_cashback WHERE id_barang = b.id_barang AND data_status=1),"-") as cashback,
                            COALESCE(CONCAT("Rp. ", format( b.harga_akhir, 0)),0) AS harga_netto,
                            COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang AND data_status=1),0) as total_stock,
                            b.deskripsi_barang
                        ');

        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'Right');
        $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
        $this->db->join('tbl_access_barang_toko i', 'b.id_barang=i.id_barang');
        $this->db->join('tbl_toko d', 'i.id_toko=d.id_toko');
        // $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
        $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
        // $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
        // $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');


        if (!empty($id_toko)) {
            $this->db->where('i.id_toko', $id_toko);
        }

        // if (!empty($id_lantai)) {
        //     $this->db->where('b.id_lantai', $id_lantai);
        // }

        if (!empty($id_barang)) {
            $this->db->where('b.id_barang', $id_barang);
        }

        if (!empty($noPo)) {
            $this->db->where('a.no_po', $noPo);
        }

        if (!empty($nabar)) {
            $this->db->where('b.nama_barang', $nabar);
        }

        if (!empty($nabrand)) {
            $this->db->where('c.nama_brand', $nabrand);
        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }
        if (!empty($tahun)) {
            $this->db->having('tahun',  $tahun);
        }

        if (!empty($search)) {
            $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('b.id_barang', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('d.nama_toko', $search); // Untuk menambahkan query where OR LIKE

        }

        $this->db->where('b.data_status', '1');
        $this->db->group_by('b.id_barang');



        $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    function export_master_data($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null, $id_toko = null, $noPo = null, $nabar = null, $nabrand = null, $bulan = null, $tahun = null)
    {
        $this->db->select('
                            b.id,
                            b.id_barang,
                            b.nama_barang,
                            c.nama_brand,
                            DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
                            DATE_FORMAT(b.created_at,"%m") AS bulan,
                            DATE_FORMAT(b.created_at,"%Y") AS tahun,
                            d.nama_toko,
                            CONCAT("Rp. ", format( f.harga_baru, 0)) as harga_baru,
                            COALESCE(( SELECT diskon FROM tbl_desc_diskon WHERE id_barang = b.id_barang AND data_status=1),"-") as diskon,
                            COALESCE(( SELECT cashback FROM tbl_desc_cashback WHERE id_barang = b.id_barang AND data_status=1),"-") as cashback,
                            COALESCE(CONCAT("Rp. ", format( b.harga_akhir, 0)),0) AS harga_netto,
                            COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang AND data_status=1),0) as total_stock,
                            b.deskripsi_barang
                        ');

        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'Right');
        $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
        $this->db->join('tbl_access_barang_toko i', 'b.id_barang=i.id_barang');
        $this->db->join('tbl_toko d', 'i.id_toko=d.id_toko');
        $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');


        if (!empty($id_toko)) {
            $this->db->where('i.id_toko', $id_toko);
        }

        if (!empty($id_barang)) {
            $this->db->where('b.id_barang', $id_barang);
        }

        if (!empty($noPo)) {
            $this->db->where('a.no_po', $noPo);
        }

        if (!empty($nabar)) {
            $this->db->where('b.nama_barang', $nabar);
        }

        if (!empty($nabrand)) {
            $this->db->where('c.nama_brand', $nabrand);
        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }
        if (!empty($tahun)) {
            $this->db->having('tahun',  $tahun);
        }

        if (!empty($search)) {
            $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('b.id_barang', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('b.data_status', '1');
        $this->db->group_by('b.id_barang');

        $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    // function filter($search=null, $limit=null, $start=null, $order_field=null, $order_ascdesc=null, $id_toko=null, $id_lantai=null, $id_barang=null,$noPo=null,$nabar=null,$nabrand=null,$bulan=null, $tahun=null){ 

    //     $this->db->select('
    //                         b.id,
    //                         b.id_barang,
    //                         b.nama_barang,
    //                         c.nama_brand,
    //                         b.id_toko,
    //                         d.nama_toko,
    //                         b.id_lantai,
    //                         e.nama_lantai,
    //                         concat("Rp. ", format( f.harga_baru, 0)) as harga_baru,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%") AS diskon_1,
    //                       CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%") AS diskon_2,
    //                       CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon_3,
    //                         concat("Rp. ", format( h.jumlah, 0)) AS cashback,
    //                         concat("Rp. ", format( ((f.harga_baru * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ) / 100 )) - h.jumlah ), 0)) AS harga_netto,
    //                         COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang),0) as total_stock,
    //                         b.deskripsi_barang,
    //                         a.id_detail_barang,
    //                         a.no_po,
    //                         DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
    //                         DATE_FORMAT(a.created_at,"%m") AS bulan,
    //                         DATE_FORMAT(a.created_at,"%Y") AS tahun,
    //                         a.stock_sold,
    //                         a.ukuran,
    //                         a.stock_quantity,
    //                         b.created_at,
    //                         b.updated_at 
    //                     ');

    //     $this->db->from('tbl_detail_barang a');
    //     $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang','Right');
    //     $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
    //     $this->db->join('tbl_toko d', 'b.id_toko=d.id_toko');
    //     $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
    //     $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
    //     $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
    //     $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');      


    //     if(!empty($id_toko)){
    //         $this->db->where('b.id_toko',$id_toko);
    //     }

    //     if(!empty($id_lantai)){
    //         $this->db->where('b.id_lantai',$id_lantai);
    //     }

    //     if(!empty($id_barang)){
    //         $this->db->where('b.id_barang',$id_barang);
    //     }

    //     if(!empty($noPo)){
    //         $this->db->where('a.no_po',$noPo);
    //     }

    //     if(!empty($nabar)){
    //         $this->db->where('b.nama_barang',$nabar);
    //     }

    //     if(!empty($nabrand)){
    //         $this->db->where('c.nama_brand',$nabrand);
    //     }  

    //     if(!empty($bulan)){
    //     $this->db->having('bulan',  $bulan);

    //     }
    //     if(!empty($tahun)){
    //         $this->db->having('tahun',  $tahun);

    //         }

    //     if(!empty($search)){
    //         $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.ukuran', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.no_po', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.stock_sold', $search); // Untuk menambahkan query where OR LIKE
    //     }   

    //     $this->db->where('b.data_status','1');
    //     $this->db->group_by('b.id_barang');

    //     $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    //     $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
    //     $query = $this->db->get();         
    //     return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    // }

    // function filter($search=null, $limit=null, $start=null, $order_field=null, $order_ascdesc=null, $id_toko=null, $id_lantai=null, $id_barang=null,$noPo=null,$nabar=null,$nabrand=null,$bulan=null, $tahun=null){ 

    //     $this->db->select('
    //                         b.id,
    //                         b.id_barang,
    //                         b.nama_barang,
    //                         c.nama_brand,
    //                         b.id_toko,
    //                         d.nama_toko,
    //                         b.id_lantai,
    //                         e.nama_lantai,
    //                         concat("Rp. ", format( f.harga_baru, 0)) as harga_baru,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%") AS diskon_1,
    //                       CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%") AS diskon_2,
    //                       CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon_3,
    //                         concat("Rp. ", format( h.jumlah, 0)) AS cashback,
    //                         concat("Rp. ", format( ((f.harga_baru * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ) / 100 )) - h.jumlah ), 0)) AS harga_netto,
    //                         COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang),0) as total_stock,
    //                         b.deskripsi_barang,
    //                         a.id_detail_barang,
    //                         a.no_po,
    //                         DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
    //                         DATE_FORMAT(a.created_at,"%m") AS bulan,
    //                         DATE_FORMAT(a.created_at,"%Y") AS tahun,
    //                         a.stock_sold,
    //                         a.ukuran,
    //                         a.stock_quantity,
    //                         b.created_at,
    //                         b.updated_at 
    //                     ');

    //     $this->db->from('tbl_detail_barang a');
    //     $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang','Right');
    //     $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
    //     $this->db->join('tbl_toko d', 'b.id_toko=d.id_toko');
    //     $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
    //     $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
    //     $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
    //     $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');

    //     // $this->db->select('a.id_barang,a.id_lantai,a.id_toko,a.deskripsi_barang,a.nama_barang,a.harga_barang,a.harga_akhir,a.created_at,b.nama_brand,c.nama_lantai,d.id_detail_barang,d.no_po,DATE_FORMAT(d.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,DATE_FORMAT(a.created_at,"%m") AS bulan,DATE_FORMAT(a.created_at,"%Y") AS tahun,d.stock_sold,d.ukuran,d.stock_quantity,e.nama_toko, COALESCE(SUM(d.stock_sold),0) as total,

    //     // CONCAT(COALESCE((SELECT SUM(g.persentase)FROM tbl_diskon as g LEFT JOIN tbl_barang AS a on g.id_barang=a.id_barang WHERE g.id_barang=a.id_barang),0),"%") AS total_diskon,
    //     // COALESCE(f.jumlah,0) as cashback,

    //     // ROUND(a.harga_barang - (a.harga_barang * ((SELECT SUM(g.persentase)FROM tbl_diskon as g LEFT JOIN tbl_barang AS a on g.id_barang=a.id_barang WHERE g.id_barang=a.id_barang) / 100)) )as setelah_diskon');

    //     // $this->db->from('tbl_detail_barang d');
    //     // $this->db->join('tbl_barang a',' d.id_barang=a.id_barang','Right');
    //     // $this->db->join('tbl_brand b',' b.id_brand=a.id_brand','left');
    //     // $this->db->join('tbl_lantai c',' c.id_lantai=a.id_lantai','left');
    //     // $this->db->join('tbl_toko e',' e.id_toko=a.id_toko','left');
    //     // $this->db->join('tbl_cashback f',' f.id_barang=a.id_barang','Right');
    //     // $this->db->join('tbl_diskon g',' g.id_barang=a.id_barang','left');



    //     if(!empty($id_toko)){
    //         $this->db->where('b.id_toko',$id_toko);
    //     }

    //     if(!empty($id_lantai)){
    //         $this->db->where('b.id_lantai',$id_lantai);
    //     }

    //     if(!empty($id_barang)){
    //         $this->db->where('b.id_barang',$id_barang);
    //     }

    //     if(!empty($noPo)){
    //         $this->db->where('a.no_po',$noPo);
    //     }

    //     if(!empty($nabar)){
    //         $this->db->where('b.nama_barang',$nabar);
    //     }

    //     if(!empty($nabrand)){
    //         $this->db->where('c.nama_brand',$nabrand);
    //     }  

    //     if(!empty($bulan)){
    //     $this->db->having('bulan',  $bulan);

    //     }
    //     if(!empty($tahun)){
    //         $this->db->having('tahun',  $tahun);

    //         }

    //     if(!empty($search)){
    //         $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.ukuran', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.no_po', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.stock_sold', $search); // Untuk menambahkan query where OR LIKE
    //     }   

    //     $this->db->where('b.data_status','1');
    //     $this->db->group_by('b.id_barang');

    //     $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    //     $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
    //     $query = $this->db->get();         
    //     return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    // }

    // public function filter_penjualan($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko, $id_lantai, $id_barang)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tbl_riwayat a');
    //     $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
    //     $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');

    //     if (!empty($search)) {
    //         $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
    //     }

    //     $this->db->where('a.data_status', 1);
    //     $this->db->where('c.id_toko', $id_toko);
    //     $this->db->where('c.id_lantai', $id_lantai);
    //     $this->db->where('c.id_barang', $id_barang);

    //     $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
    //     $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function filter_penjualan($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('a.data_status', 1);
        // $this->db->where('c.id_toko', $id_toko);
        // $this->db->where('c.id_lantai', $id_lantai);
        $this->db->where('c.id_barang', $id_barang);

        $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_all()
    {
        return $this->db->where('data_status', 1)->count_all('tbl_barang'); // Untuk menghitung semua data 
    }

    // public function count_filter_master_data($search, $id_toko, $noPo, $nabar, $nabrand)
    // {
    //     $this->db->select('
    //                         b.id,
    //                         b.id_barang,
    //                         b.nama_barang,
    //                         c.nama_brand,
    //                         b.id_toko,
    //                         d.nama_toko,
    //                         d.id_toko,
    //                         e.nama_lantai,
    //                         CONCAT("Rp. ", format( f.harga_baru, 0)) as harga_baru,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon,
    //                         CONCAT(( SELECT CONCAT("Rp. ", format( nominal, 0)) FROM tbl_cashback WHERE id_cashback = b.id_cashback AND order_data = 1 ), "+", ( SELECT CONCAT("Rp. ", format( nominal, 0)) FROM tbl_cashback WHERE id_cashback = b.id_cashback AND order_data = 2 ), "+", ( SELECT CONCAT("Rp. ", format( nominal, 0)) FROM tbl_cashback WHERE id_cashback = b.id_cashback AND order_data = 3 )) AS cashback,
    //                         CONCAT("Rp. ", format( ((f.harga_baru * ( 1-( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ) / 100 )) - (SELECT sum(nominal) FROM tbl_cashback WHERE id_cashback = b.id_cashback) ), 0)) AS harga_netto,
    //                         COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang AND data_status=1),0) as total_stock,
    //                         b.deskripsi_barang
    //                     ');

    //     $this->db->from('tbl_detail_barang a');
    //     $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'Right');
    //     $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
    //     $this->db->join('tbl_toko d', 'b.id_toko=d.id_toko');
    //     $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
    //     $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
    //     $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
    //     $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');

    //     if (!empty($id_toko)) {
    //         $this->db->where('b.id_toko', $id_toko);
    //     }

    //     if (!empty($noPo)) {
    //         $this->db->where('a.no_po', $noPo);
    //     }

    //     if (!empty($nabar)) {
    //         $this->db->where('b.nama_barang', $nabar);
    //     }

    //     if (!empty($nabrand)) {
    //         $this->db->where('c.nama_brand', $nabrand);
    //     }

    //     if (!empty($search)) {
    //         $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('d.nama_toko', $search); // Untuk menambahkan query where OR LIKE

    //     }

    //     $this->db->where('b.data_status', '1');
    //     $this->db->group_by('b.id_barang');

    //     $query = $this->db->get();
    //     return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    // }

    public function count_filter_master_data($search, $noPo, $nabar, $nabrand)
    {
        $this->db->select('
                            b.id,
                            b.id_barang,
                            b.nama_barang,
                            c.nama_brand,
                            DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
                            DATE_FORMAT(a.created_at,"%m") AS bulan,
                            DATE_FORMAT(a.created_at,"%Y") AS tahun,
                            CONCAT("Rp. ", format( f.harga_baru, 0)) as harga_baru,
                            COALESCE(( SELECT diskon FROM tbl_desc_diskon WHERE id_barang = b.id_barang AND data_status=1),"-") as diskon,
                            COALESCE(( SELECT cashback FROM tbl_desc_cashback WHERE id_barang = b.id_barang AND data_status=1),"-") as cashback,
                            COALESCE(CONCAT("Rp. ", format( b.harga_akhir, 0)),0) AS harga_netto,
                            COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang AND data_status=1),0) as total_stock,
                            b.deskripsi_barang
                        ');

        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'Right');
        $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
        // $this->db->join('tbl_toko d', 'b.id_toko=d.id_toko');
        // $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
        $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
        // $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
        // $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');

        // if (!empty($id_toko)) {
        //     $this->db->where('b.id_toko', $id_toko);
        // }

        // if (!empty($noPo)) {
        //     $this->db->where('a.no_po', $noPo);
        // }

        if (!empty($nabar)) {
            $this->db->where('b.nama_barang', $nabar);
        }

        if (!empty($nabrand)) {
            $this->db->where('c.nama_brand', $nabrand);
        }

        if (!empty($search)) {
            $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('b.id_barang', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('d.nama_toko', $search); // Untuk menambahkan query where OR LIKE

        }

        $this->db->where('b.data_status', '1');
        $this->db->group_by('b.id_barang');

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    // public function count_filter($search,$id_toko,$noPo,$nabar,$nabrand){
    //     $this->db->select('
    //                         b.id,
    //                         b.id_barang,
    //                         b.nama_barang,
    //                         c.nama_brand,
    //                         b.id_toko,
    //                         d.nama_toko,
    //                         b.id_lantai,
    //                         e.nama_lantai,
    //                         concat("Rp. ", format( f.harga_baru, 0)) as harga_baru,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%+", ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon,
    //                         CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ), "%") AS diskon_1,
    //                       CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ), "%") AS diskon_2,
    //                       CONCAT(( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ), "%") AS diskon_3,
    //                         concat("Rp. ", format( h.jumlah, 0)) AS cashback,
    //                         concat("Rp. ", format( ((f.harga_baru * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 1 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 2 ) / 100 ) * ( 1- ( SELECT persentase FROM tbl_diskon WHERE id_diskon = b.id_diskon AND order_data = 3 ) / 100 )) - h.jumlah ), 0)) AS harga_netto,
    //                         COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = b.id_barang),0) as total_stock,
    //                         b.deskripsi_barang,
    //                         a.id_detail_barang,
    //                         a.no_po,
    //                         DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk,
    //                         DATE_FORMAT(a.created_at,"%m") AS bulan,
    //                         DATE_FORMAT(a.created_at,"%Y") AS tahun,
    //                         a.stock_sold,
    //                         a.ukuran,
    //                         a.stock_quantity,
    //                         b.created_at,
    //                         b.updated_at 
    //                     ');

    //     $this->db->from('tbl_detail_barang a');
    //     $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang','Right');
    //     $this->db->join('tbl_brand c', 'b.id_brand=c.id_brand');
    //     $this->db->join('tbl_toko d', 'b.id_toko=d.id_toko');
    //     $this->db->join('tbl_lantai e', 'b.id_lantai=e.id_lantai');
    //     $this->db->join('tbl_harga f', 'b.id_harga=f.id_harga');
    //     $this->db->join('tbl_diskon g', 'b.id_diskon=g.id_diskon');
    //     $this->db->join('tbl_cashback h', 'b.id_cashback=h.id_cashback');

    //     if(!empty($id_toko)){
    //         $this->db->where('b.id_toko',$id_toko);
    //     }

    //     if(!empty($noPo)){
    //         $this->db->where('a.no_po',$noPo);
    //     }

    //     if(!empty($nabar)){
    //         $this->db->where('b.nama_barang',$nabar);
    //     }

    //     if(!empty($nabrand)){
    //         $this->db->where('c.nama_brand',$nabrand);
    //     }

    //     if(!empty($search)){
    //         $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('c.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('e.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.ukuran', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.no_po', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('a.stock_sold', $search); // Untuk menambahkan query where OR LIKE
    //     }

    //     $this->db->where('b.data_status','1');
    //     $this->db->group_by('b.id_barang');

    //     $query = $this->db->get();         
    //     return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    // }

    // public function count_filter($search,$id_toko,$noPo,$nabar,$nabrand){
    //     $this->db->select('a.id_barang,a.deskripsi_barang,a.nama_barang,b.nama_brand,c.nama_lantai,d.stock_quantity');
    //     $this->db->from('tbl_detail_barang d');
    //     $this->db->join('tbl_barang a',' d.id_barang=a.id_barang','Right');
    //     $this->db->join('tbl_brand b',' b.id_brand=a.id_brand','left');
    //     $this->db->join('tbl_lantai c',' c.id_lantai=a.id_lantai','left');
    //     $this->db->join('tbl_cashback f',' f.id_barang=a.id_barang','Right');
    //     $this->db->join('tbl_diskon g',' g.id_barang=a.id_barang','left');
    //     if(!empty($id_toko)){
    //       $this->db->where('a.id_toko',$id_toko);
    //     }

    //     if(!empty($noPo)){
    //       $this->db->where('d.no_po',$noPo);
    //     }

    //     if(!empty($nabar)){
    //       $this->db->where('a.nama_barang',$nabar);
    //     }

    //     if(!empty($nabrand)){
    //       $this->db->where('b.nama_brand',$nabrand);
    //     }

    //     if(!empty($search)){
    //         $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //     }

    //     $this->db->where('a.data_status','1');
    //     $this->db->group_by('a.id_barang');

    //     $query = $this->db->get();         
    //     return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    // }

    public function count_filter2($search)
    {
        $this->db->select('a.id_barang,a.deskripsi_barang,a.nama_barang,b.nama_brand,c.nama_lantai,d.stock_quantity');
        $this->db->from('tbl_detail_barang d');
        $this->db->join('tbl_barang a', ' d.id_barang=a.id_barang', 'left');
        $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
        $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');

        if (!empty($search)) {
            $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('d.data_status', '1');

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    // public function count_filter_detail($search, $id_barang)
    // {
    //     $this->db->select('a.id_barang,a.deskripsi_barang,a.nama_barang,b.nama_brand,c.nama_lantai,d.stock_quantity');
    //     $this->db->from('tbl_detail_barang d');
    //     $this->db->join('tbl_barang a', ' d.id_barang=a.id_barang', 'left');
    //     $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
    //     $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');

    //     if (!empty($search)) {
    //         $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
    //     }

    //     $this->db->where('d.id_barang', $id_barang);
    //     $this->db->where('d.data_status', 1);
    //     $this->db->where('d.status_order', 0);

    //     $query = $this->db->get();
    //     return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    // }

    public function count_filter_detail($search, $id_barang)
    {
        $this->db->select('a.id_barang,a.deskripsi_barang,a.nama_barang,b.nama_brand,d.stock_quantity');
        $this->db->from('tbl_detail_barang d');
        $this->db->join('tbl_barang a', ' d.id_barang=a.id_barang', 'left');
        $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
        // $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');

        if (!empty($search)) {
            $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('d.id_barang', $id_barang);
        $this->db->where('d.data_status', 1);
        $this->db->where('d.status_order', 0);

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function count_filter_barang($search, $id_toko = null, $id_lantai = null)
    {
        $this->db->select('a.id_barang,a.deskripsi_barang,f.harga_baru,a.nama_barang,b.nama_brand, g.id_toko');
        $this->db->from('tbl_barang a');
        $this->db->join('tbl_brand b', ' b.id_brand=a.id_brand', 'left');
        $this->db->join('tbl_access_barang_toko g', 'a.id_barang=g.id_barang', 'inner');
        // $this->db->join('tbl_lantai c', ' c.id_lantai=a.id_lantai', 'left');
        $this->db->join('tbl_harga f', ' a.id_harga=f.id_harga', 'inner');

        if (!empty($search)) {
            $this->db->like('a.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('b.nama_brand', $search); // Untuk menambahkan query where OR LIKE
            // $this->db->or_like('c.nama_lantai', $search); // Untuk menambahkan query where OR LIKE
        }

        if (!empty($id_toko)) {
            $this->db->where('g.id_toko', $id_toko);
        }

        // if (!empty($id_lantai)) {
        //     $this->db->where('a.id_lantai', $id_lantai);
        // }

        $this->db->where('a.data_status', '1');

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    // public function count_filter_penjualan($search, $id_toko, $id_lantai, $id_barang)
    // {
    //     $this->db->select('*');
    //     $this->db->from('tbl_riwayat a');
    //     $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
    //     $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');

    //     if (!empty($search)) {
    //         $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
    //         $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
    //         $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
    //     }

    //     $this->db->where('a.data_status', 1);
    //     $this->db->where('c.id_toko', $id_toko);
    //     $this->db->where('c.id_lantai', $id_lantai);
    //     $this->db->where('c.id_barang', $id_barang);

    //     $query = $this->db->get();
    //     return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    // }

    public function count_filter_penjualan($search, $id_barang)
    {
        $this->db->select('*');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('a.data_status', 1);
        // $this->db->where('c.id_toko', $id_toko);
        // $this->db->where('c.id_lantai', $id_lantai);
        $this->db->where('c.id_barang', $id_barang);

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function get_all_stok()
    {
        $this->db->select('*');
        $this->db->from('tbl_barang a');
        $this->db->join('tbl_brand b', ' a.id_brand=b.id_brand', 'left');
        $this->db->join('tbl_lantai c', ' a.id_lantai=c.id_lantai', 'left');
        $this->db->join('tbl_detail_barang d', ' a.id_barang=d.id_barang', 'left');
        $this->db->where('a.data_status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_toko($id_toko = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_toko');

        if (!empty($idToko)) {
            $this->db->where('id_toko', $id_toko);
        }

        $this->db->where('data_status', '1');
        $this->db->order_by('nama_toko', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_data_toko($id)
    {
        $this->db->select('*');
        $this->db->from('tbl_access_barang_toko a');
        $this->db->join('tbl_barang e', 'a.id_barang=e.id_barang', 'left');
        $this->db->join(' tbl_toko b', ' a.id_toko=b.id_toko', 'left');
        $this->db->join(' tbl_brand c', ' e.id_brand=c.id_brand', 'left');
        // $this->db->join(' tbl_lantai d', ' a.id_lantai=d.id_lantai', 'left');
        $this->db->where('a.data_status', '1');
        $this->db->where('a.id_toko', $id);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_brand()
    {
        $this->db->select('*');
        $this->db->from('tbl_brand');
        $this->db->where('data_status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_lantai()
    {
        $this->db->select('*');
        $this->db->from('tbl_lantai');
        $this->db->where('data_status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_detail_barang()
    {
        $this->db->select('*');
        $this->db->from('tbl_detail_barang a');
        $this->db->join(' tbl_barang b', ' a.id_barang=b.id_barang', 'left');
        $this->db->join(' tbl_toko c', ' b.id_toko=c.id_toko', 'left');
        $this->db->join(' tbl_brand d', ' b.id_brand=d.id_brand', 'left');
        $this->db->where('a.data_status', '1');
        $query = $this->db->get();
        return $query->result();
    }

    function query_stock($id_barang)
    {
        $hsl = $this->db->query("
                                    SELECT
                                    a.id_toko,
                                    b.nama_toko,
                                    COALESCE(( SELECT sum(stock_sold) FROM tbl_detail_barang WHERE id_barang = a.id_barang AND id_toko = a.id_toko AND data_status=1)-COALESCE(( SELECT     sum(qty)  FROM tbl_penjualan AS c   INNER JOIN tbl_riwayat AS d ON d.id_riwayat = c.id_riwayat  INNER JOIN tbl_detail_barang AS e ON e.id_detail_barang = d.id_detail_barang  WHERE c.data_status = 1 AND e.id_barang = a.id_barang     AND e.id_toko = a.id_toko),0),0) as total_stock,
                                    COALESCE(( SELECT   sum(qty)  FROM tbl_penjualan AS c   INNER JOIN tbl_riwayat AS d ON d.id_riwayat = c.id_riwayat  INNER JOIN tbl_detail_barang AS e ON e.id_detail_barang = d.id_detail_barang  WHERE c.data_status = 1 AND e.id_barang = a.id_barang     AND e.id_toko = a.id_toko),0) as terjual
    
     
                                    FROM
                                        tbl_access_barang_toko AS a
                                        INNER JOIN tbl_toko AS b ON b.id_toko = a.id_toko
                                        
                                    WHERE
                                        a.id_barang = '$id_barang' 
                                        AND a.data_status = '1' 
                                        AND b.data_status = '1' 
                                    GROUP BY
                                        a.id_toko
                                    ORDER BY
                                        b.nama_toko ASC 
                                ");
        return $hsl;
    }

    function get_detbarang_by_kode($kobar)
    {
        $hsl = $this->db->query("SELECT tbl_detail_barang.*, DATE_FORMAT(tanggal_masuk,'%d-%m-%Y') AS tanggal_masuk FROM tbl_detail_barang  WHERE no_po='$kobar'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_detail_barang' => $data->id_detail_barang,
                    'no_po' => $data->no_po,
                    'stock_quantity' => $data->stock_quantity,
                    'ukuran' => $data->ukuran,
                    'warna' => $data->warna,
                    'tanggal_masuk' => $data->tanggal_masuk,
                    'sisa' => $data->stock_quantity - $data->stock_sold
                );
            }
        }
        return $hasil;
    }

    function get_detbarang_by_kode2($id)
    {
        $hsl = $this->db->query("SELECT tbl_detail_barang.*, DATE_FORMAT(tanggal_masuk,'%d-%m-%Y') AS tanggal_masuk FROM tbl_detail_barang  WHERE id='$id'");

        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id' => $data->id,
                    'id_detail_barang' => $data->id_detail_barang,
                    'no_po' => $data->no_po,
                    'stock_quantity' => $data->stock_quantity,
                    'ukuran' => $data->ukuran,
                    'warna' => $data->warna,
                    'tanggal_masuk' => $data->tanggal_masuk,
                    'sisa' => $data->stock_quantity - $data->stock_sold,
                    'stockToko' => $data->stock_sold
                );
            }
        }
        return $hasil;
    }


    function get_barang_by_kode($kobar)
    {
        $hsl = $this->db->query("SELECT b.id_cashback,c.nominal, b.id_barang, b.id_brand, b.nama_barang, b.deskripsi_barang, a.persentase,b.harga_akhir, c.nominal, d.harga_baru FROM tbl_diskon as a right Join tbl_barang as b on a.id_barang=b.id_barang left join tbl_cashback AS c on b.id_cashback=c.id_cashback join tbl_harga AS d ON b.id_harga=d.id_harga WHERE b.id_barang='$kobar' ORDER BY a.created_at DESC limit 3")->result_array();

        $hasil = array(
            'id_barang' => $hsl[0]['id_barang'],
            'id_brand' => $hsl[0]['id_brand'],
            // 'id_toko' => $hsl[0]['id_toko'],
            // 'id_lantai' => $hsl[0]['id_lantai'],
            'nama_barang' => $hsl[0]['nama_barang'],
            'deskripsi_barang' => $hsl[0]['deskripsi_barang'],
            'harga_barang' => $hsl[0]['harga_baru'],
            'harga_akhir' => $hsl[0]['harga_akhir'],

        );

        // print_r($hasil);
        // exit();

        return $hasil;
    }

    //GET toko BY Produk ID
    function get_toko_by_produk($kobar)
    {
        $this->db->select('*');
        $this->db->from('tbl_toko a');
        $this->db->join('tbl_access_barang_toko b', 'a.id_toko=b.id_toko');
        $this->db->join('tbl_barang c', 'c.id_barang=b.id_barang');
        $this->db->where('c.id_barang', $kobar);
        $query = $this->db->get();
        return $query;
    }

    // function get_barang_by_kode($kobar){
    //     $hsl=$this->db->query("SELECT * FROM tbl_barang  WHERE id_barang='$kobar'");
    //     if($hsl->num_rows()>0){
    //         foreach ($hsl->result() as $data) {
    //         $hasil=array(
    //             'id_barang' => $data->id_barang,
    //             'id_brand' => $data->id_brand,
    //             'id_toko' => $data->id_toko,
    //             'id_lantai' => $data->id_lantai,
    //             'nama_barang' => $data->nama_barang,
    //             'deskripsi_barang' => $data->deskripsi_barang
    //             ) ;
    //         }
    //     }
    //     return $hasil;
    // }

    function get_penjualan_by_kode($kobar)
    {
        $hsl = $this->db->query("SELECT *, DATE_FORMAT(tanggal_terima,'%d-%m-%Y') AS tanggal_terima FROM tbl_riwayat AS a JOIN tbl_detail_barang AS b on a.id_detail_barang=b.id_detail_barang  WHERE a.id_riwayat='$kobar'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'id_riwayat' => $data->id_riwayat,
                    'id_detail_barang' => $data->id_detail_barang,
                    'no_po' => $data->no_po,
                    'banyak' => intval($data->banyak),
                    'tanggal_terima' => $data->tanggal_terima,
                    'keterangan' => $data->keterangan
                );
            }
        }
        return $hasil;
    }

    public function get_data_po()
    {
        $id_toko = $this->uri->segment(4);
        $id_lantai = $this->uri->segment(5);
        $id_barang = $this->uri->segment(6);

        $hsl = $this->db->query("SELECT  * FROM tbl_detail_barang a JOIN tbl_barang b ON  a.id_barang=b.id_barang  WHERE a.data_status = '1' AND  b.id_barang='$id_barang'");
        // $hsl = $this->db->query("SELECT  * FROM tbl_detail_barang a JOIN tbl_barang b ON  a.id_barang=b.id_barang  WHERE a.data_status = '1' AND  b.id_toko = '$id_toko' AND  b.id_lantai='$id_lantai' AND  b.id_barang='$id_barang'");
        return $hsl;
    }

    //get tahun 
    function get_tahun($orderby, $id_toko)
    {
        $this->db->select("DISTINCT DATE_FORMAT(tbl_barang.created_at,'%Y') AS tahun");
        $this->db->from("tbl_barang");
        $this->db->join('tbl_access_barang_toko', 'tbl_barang.id_barang=tbl_access_barang_toko.id_barang', 'inner');

        if (!empty($id_toko)) {
            $this->db->where('tbl_access_barang_toko.id_toko', $id_toko);
        }

        $this->db->where("tbl_barang.data_status", "1");
        $this->db->order_by('tahun', $orderby);
        $Q = $this->db->get();
        $this->_data = $Q->result();

        $Q->free_result();
        return $this->_data;
    }

    function get_periode_tahun($orderby, $tahun, $id_toko)
    {
        $this->db->select("DISTINCT DATE_FORMAT(created_at,'%Y') AS tahun");
        $this->db->from("tbl_barang");

        if (!empty($id_toko)) {
            $this->db->where('id_toko', $id_toko);
        }

        $this->db->where("data_status", "1");
        $this->db->order_by('tahun', $orderby);
        $Q = $this->db->get();
        $this->_data = $Q->result();

        $Q->free_result();
        return $this->_data;
    }

    //get bulan
    function get_bulan($orderby, $id_toko)
    {
        $this->db->select("DISTINCT DATE_FORMAT(tbl_barang.created_at,'%m') AS bulan");
        $this->db->from("tbl_barang");
        $this->db->join('tbl_access_barang_toko', 'tbl_barang.id_barang=tbl_access_barang_toko.id_barang', 'inner');

        if (!empty($id_toko)) {
            $this->db->where('tbl_access_barang_toko.id_toko', $id_toko);
        }

        $this->db->where("tbl_barang.data_status", "1");
        $this->db->order_by('bulan', $orderby);
        $Q = $this->db->get();
        $this->_data = $Q->result();

        $Q->free_result();
        return $this->_data;
    }

    //get bulan
    function get_periode_bulan($orderby, $bulan, $id_toko)
    {
        $this->db->select("DISTINCT DATE_FORMAT(created_at,'%m') AS bulan");
        $this->db->from("tbl_barang");

        if (!empty($id_toko)) {
            $this->db->where('id_toko', $id_toko);
        }

        $this->db->where("data_status", "1");
        $this->db->order_by('bulan', $orderby);
        $Q = $this->db->get();
        $this->_data = $Q->result();

        $Q->free_result();
        return $this->_data;
    }

    //get tahun detail
    function get_periode_tahun_detail($orderby, $tahun)
    {
        $this->db->select("DISTINCT DATE_FORMAT(tanggal_masuk,'%Y') AS tahun");
        $this->db->from("tbl_detail_barang");
        $this->db->where("data_status", "1");
        $this->db->order_by('tahun', $orderby);
        $Q = $this->db->get();
        $this->_data = $Q->result();

        $Q->free_result();
        return $this->_data;
    }

    //get bulan detail
    function get_periode_bulan_detail($orderby, $bulan)
    {
        $this->db->select("DISTINCT DATE_FORMAT(tanggal_masuk,'%m') AS bulan");
        $this->db->from("tbl_detail_barang");
        $this->db->where("data_status", "1");
        $this->db->order_by('bulan', $orderby);
        $Q = $this->db->get();
        $this->_data = $Q->result();

        $Q->free_result();
        return $this->_data;
    }

    function simpan_po($nopo, $sp, $sb, $id_toko)
    {
        foreach ($this->cart->contents() as $item) {
            $idDetail  = $this->CodeModels->create_code_det_barang();

            $data = array(
                'id_detail_barang' => $idDetail,
                'no_po'         =>    $nopo,
                'id_harga'      => $item['id_harga'],
                'id_barang'        =>    $item['id'],
                'ukuran'        =>    $item['options']['ukuran'],
                'warna'         =>    $item['options']['warna'],
                'keterangan'         =>    $item['options']['ket'],
                'stock_quantity'    =>    $item['qty'],
                'tanggal_masuk'    =>    date('Y-m-d'),
                'nama_sp' => $sp,
                'nama_sb' => $sb,
                'id_toko' => $id_toko
            );
            $this->db->insert('tbl_detail_barang', $data);
        }
        return true;
    }

    function get_all_sp()
    {
        $this->db->select('*');
        $this->db->from('tbl_status_pengiriman');
        $this->db->where('data_status', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function get_all_sb()
    {
        $this->db->select('*');
        $this->db->from('tbl_status_barang');
        $this->db->where('data_status', 1);
        $query = $this->db->get();
        return $query->result();
    }


    function filter_data_barang_po($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null)
    {

        $this->db->select('a.no_po,DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk, a.nama_sp,a.nama_sb');
        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'inner');
        $this->db->join('tbl_access_barang_toko d', 'b.id_barang=d.id_barang', 'inner');
        $this->db->join('tbl_toko c', 'd.id_toko=c.id_toko', 'inner');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('a.id_toko', $id_toko);
        $this->db->group_by('a.no_po');
        $this->db->order_by('tanggal_masuk', 'asc'); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    public function count_all_po()
    {
        return $this->db->where('data_status', 1)->count_all('tbl_detail_barang'); // Untuk menghitung semua data 
    }

    public function count_filter_barang_po($search, $id_toko = null, $id_lantai = null)
    {
        $this->db->select('a.no_po,DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk, a.nama_sp,a.nama_sb');
        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', 'a.id_barang=b.id_barang', 'inner');
        $this->db->join('tbl_access_barang_toko d', 'b.id_barang=d.id_barang', 'inner');
        $this->db->join('tbl_toko c', 'd.id_toko=c.id_toko', 'inner');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('a.id_toko', $id_toko);
        $this->db->group_by('a.no_po');
        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    //Penjualan Customer

    function filter_data_barang_penjualan($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null)
    {

        $this->db->select('*,a.keterangan,b.id as idRiwayat,(g.harga_baru - d.harga_akhir) as margin ');
        $this->db->from('tbl_penjualan a');
        $this->db->join('tbl_riwayat b', 'a.id_riwayat=b.id_riwayat', 'inner');
        $this->db->join('tbl_detail_barang c', 'b.id_detail_barang=c.id_detail_barang', 'inner');
        $this->db->join('tbl_barang d', 'd.id_barang=c.id_barang', 'inner');

        $this->db->join('tbl_access_barang_toko e', 'e.id_barang=d.id_barang', 'inner');
        $this->db->join('tbl_toko f', 'f.id_toko=e.id_toko', 'inner');
        $this->db->join('tbl_harga g', 'd.id_barang=g.id_barang', 'inner');

        $this->db->where('f.id_toko', $id_toko);

        // if (!empty($search)) {
        //     $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
        //     $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        // }

        $this->db->where('a.data_status', 1);

        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    function filter_data_barang_penjualan2($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_barang = null)
    {

        $this->db->select('*,b.id as idRiwayat');
        $this->db->from('tbl_penjualan a');
        $this->db->join('tbl_riwayat b', 'a.id_riwayat=b.id_riwayat', 'inner');
        $this->db->join('tbl_detail_barang c', 'b.id_detail_barang=c.id_detail_barang', 'inner');
        $this->db->join('tbl_barang d', 'd.id_barang=c.id_barang', 'inner');
        if (!empty($id_barang)) {
            $this->db->where('d.id_barang', $id_barang);
        }
        // if (!empty($search)) {
        //     $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
        //     $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        // }

        $this->db->where('a.data_status', 1);

        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    function filter_data_barang_penjualan3($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null)
    {

        $this->db->select('*,b.id as idRiwayat');
        $this->db->from('tbl_penjualan a');
        $this->db->join('tbl_riwayat b', 'a.id_riwayat=b.id_riwayat', 'inner');
        $this->db->join('tbl_detail_barang c', 'b.id_detail_barang=c.id_detail_barang', 'inner');
        $this->db->join('tbl_barang d', 'd.id_barang=c.id_barang', 'inner');
        $this->db->join('tbl_access_barang_toko e', 'e.id_barang=d.id_barang', 'inner');
        $this->db->join('tbl_toko f', 'f.id_toko=e.id_toko', 'inner');
        $this->db->join('tbl_brand g', 'g.id_brand=d.id_brand', 'inner');
        $this->db->join('tbl_lantai h', 'h.id_lantai=b.id_lantai', 'inner');
        if (!empty($id_toko)) {
            $this->db->where('f.id_toko', $id_toko);
        }
        // if (!empty($search)) {
        //     $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
        //     $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        // }

        $this->db->where('a.data_status', 1);

        $query = $this->db->get();
        return $query->result_array();   // Eksekusi query sql sesuai kondisi diatas
    }

    public function count_all_penjualan()
    {
        return $this->db->where('data_status', 1)->count_all('tbl_penjualan'); // Untuk menghitung semua data 
    }

    public function count_filter_barang_penjualan($search, $id_toko = null, $id_lantai = null)
    {
        $this->db->select('*,a.keterangan,b.id as idRiwayat,(g.harga_baru - d.harga_akhir) as margin ');
        $this->db->from('tbl_penjualan a');
        $this->db->join('tbl_riwayat b', 'a.id_riwayat=b.id_riwayat', 'inner');
        $this->db->join('tbl_detail_barang c', 'b.id_detail_barang=c.id_detail_barang', 'inner');
        $this->db->join('tbl_barang d', 'd.id_barang=c.id_barang', 'inner');
        $this->db->join('tbl_access_barang_toko e', 'e.id_barang=d.id_barang', 'inner');
        $this->db->join('tbl_toko f', 'f.id_toko=e.id_toko', 'inner');
        $this->db->join('tbl_harga g', 'd.id_barang=g.id_barang', 'inner');

        $this->db->where('f.id_toko', $id_toko);

        // if (!empty($search)) {
        //     $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
        //     $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        // }

        $this->db->where('a.data_status', 1);

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function count_filter_barang_penjualan2($search, $id_barang = null, $id_lantai = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_penjualan a');
        $this->db->join('tbl_riwayat b', 'a.id_riwayat=b.id_riwayat', 'inner');
        $this->db->join('tbl_detail_barang c', 'b.id_detail_barang=c.id_detail_barang', 'inner');
        $this->db->join('tbl_barang d', 'd.id_barang=c.id_barang', 'inner');
        if (!empty($id_barang)) {
            $this->db->where('d.id_barang', $id_barang);
        }
        // if (!empty($search)) {
        //     $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
        //     $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        // }

        $this->db->where('a.data_status', 1);

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function count_filter_barang_penjualan3($search, $id_barang = null, $id_lantai = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_penjualan a');
        $this->db->join('tbl_riwayat b', 'a.id_riwayat=b.id_riwayat', 'inner');
        $this->db->join('tbl_detail_barang c', 'b.id_detail_barang=c.id_detail_barang', 'inner');
        $this->db->join('tbl_barang d', 'd.id_barang=c.id_barang', 'inner');
        $this->db->join('tbl_brand g', 'g.id_brand=d.id_brand', 'inner');
        $this->db->join('tbl_lantai h', 'h.id_lantai=b.id_lantai', 'inner');
        if (!empty($id_barang)) {
            $this->db->where('d.id_barang', $id_barang);
        }
        // if (!empty($search)) {
        //     $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
        //     $this->db->or_like('nama_sp', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('nama_sb', $search); // Untuk menambahkan query where OR LIKE
        //     $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
        // }

        $this->db->where('a.data_status', 1);

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function filter_po($search, $limit, $start, $order_field, $order_ascdesc, $no_po, $bulan = null, $tahun = null)
    {
        $this->db->select('a.id,a.id_barang,a.id_detail_barang,a.nama_sp,a.nama_sb,c.harga_baru,a.stock_quantity,a.stock_sold,(a.stock_quantity-a.stock_sold)AS sisa,a.ukuran,a.warna,b.nama_barang,DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk, DATE_FORMAT(a.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(a.tanggal_masuk, "%Y") AS tahun');
        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', ' b.id_barang=a.id_barang', 'left');
        $this->db->join('tbl_harga c', ' c.id_harga=a.id_harga', 'left');
        if (!empty($search)) {
            $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE

        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }

        if (!empty($tahun)) {
            $this->db->having('tahun',  $bulan);
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('a.no_po', $no_po);
        $this->db->where('a.status_order <= ', 2);

        $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filter_po($search, $no_po)
    {
        $this->db->select('a.id,a.id_barang,a.id_detail_barang,a.nama_sp,a.nama_sb,c.harga_baru,a.stock_quantity,a.stock_sold,(a.stock_quantity-a.stock_sold)AS sisa,a.ukuran,a.warna,b.nama_barang,DATE_FORMAT(a.tanggal_masuk,"%d-%m-%Y") AS tanggal_masuk');
        $this->db->from('tbl_detail_barang a');
        $this->db->join('tbl_barang b', ' b.id_barang=a.id_barang', 'left');
        $this->db->join('tbl_harga c', ' c.id_harga=a.id_harga', 'left');
        if (!empty($search)) {
            $this->db->like('b.nama_barang', $search); // Untuk menambahkan query where LIKE
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('a.no_po', $no_po);
        $this->db->where('a.status_order <= ', 1);
        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function filter_penjualan2($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $no_po = null, $bulan = null, $tahun = null)
    {
        $this->db->select('b.id as idDetail,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin,e.nama_lantai');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');
        $this->db->join('tbl_lantai e', 'e.id_lantai=a.id_lantai', 'left');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }

        if (!empty($tahun)) {
            $this->db->having('tahun',  $bulan);
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('b.no_po', $no_po);
        // $this->db->where('a.id_db_aai', 'b.id');
        $this->db->where('b.status_order >=', 2);

        $this->db->order_by('a.id', $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();
    }

    public function filter_penjualan3($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $id_toko = null, $bulan = null, $tahun = null)
    {
        $this->db->select('g.*,f.*,e.*,c.deskripsi_barang,b.id_barang,b.id as idDetail,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');
        $this->db->join('tbl_brand e', 'c.id_brand=e.id_brand', 'inner');
        $this->db->join('tbl_lantai f', 'a.id_lantai=f.id_lantai', 'inner');
        $this->db->join('tbl_toko g', 'b.id_toko=g.id_toko', 'inner');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }

        if (!empty($tahun)) {
            $this->db->having('tahun',  $bulan);
        }

        if (!empty($id_toko)) {
            $this->db->where('b.id_toko', $id_toko);
        }


        $this->db->where('a.data_status', 1);
        // $this->db->where('a.id_db_aai', 'b.id');
        $this->db->where('b.status_order >=', 2);
        $this->db->group_by('b.id_barang');

        $this->db->order_by('a.id', $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filter_penjualan2($search, $no_po)
    {
        $this->db->select('b.id as idDetail,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin,e.nama_lantai');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');
        $this->db->join('tbl_lantai e', 'e.id_lantai=a.id_lantai', 'left');

        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('b.no_po', $no_po);
        $this->db->where('b.status_order >=', 2);

        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }

    public function count_filter_penjualan3($search, $id_toko = null)
    {
        $this->db->select('g.*,f.*,e.*,c.deskripsi_barang,b.id_barang,b.id as idDetail,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');
        $this->db->join('tbl_brand e', 'c.id_brand=e.id_brand', 'inner');
        $this->db->join('tbl_lantai f', 'a.id_lantai=f.id_lantai', 'inner');
        $this->db->join('tbl_toko g', 'b.id_toko=g.id_toko', 'inner');


        if (!empty($search)) {
            $this->db->like('no_po', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('tanggal_masuk', $search); // Untuk menambahkan query where OR LIKE
            $this->db->or_like('keterangan', $search); // Untuk menambahkan query where OR LIKE
        }

        if (!empty($id_toko)) {
            $this->db->where('b.id_toko', $id_toko);
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('b.status_order >=', 2);
        $this->db->group_by('b.id_barang');
        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }


    public function dataToko($search = null, $limit = null, $start = null, $order_field = null, $order_ascdesc = null, $no_po = null, $bulan = null, $tahun = null)
    {
        $this->db->select('a.id_riwayat,b.id as id_detail,b.id_detail_barang,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,b.warna,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin ');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');

        if (!empty($search)) {
            $this->db->like('nama_barang', $search); // Untuk menambahkan query where LIKE
        }

        if (!empty($bulan)) {
            $this->db->having('bulan',  $bulan);
        }

        if (!empty($tahun)) {
            $this->db->having('tahun',  $bulan);
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('b.no_po', $no_po);
        // $this->db->where('a.id_db_aai', 'b.id');
        $this->db->where('b.status_order >=', 2);
        $this->db->where('a.banyak >', 0);
        $this->db->order_by('a.id', $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT

        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_dataToko($search, $no_po)
    {
        $this->db->select('a.id_riwayat,b.id as id_detail,b.id_detail_barang,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,b.warna,a.tanggal_terima, a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');

        if (!empty($search)) {
            $this->db->like('nama_barang', $search); // Untuk menambahkan query where LIKE
        }

        $this->db->where('a.data_status', 1);
        $this->db->where('b.no_po', $no_po);
        $this->db->where('b.status_order >=', 2);
        $this->db->where('a.banyak >', 0);
        // $this->db->group_by('b.id_detail_barang');
        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }


    public function filter_data_lantai($search, $limit, $start, $order_ascdesc, $id_toko, $id_lantai)
    {
        $this->db->select('b.id as idDetail,b.id_barang as id_barang,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin,c.deskripsi_barang,e.nama_brand ');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');
        $this->db->join('tbl_brand e', 'e.id_brand=c.id_brand', 'left');

        if (!empty($search)) {
            $this->db->like('nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('nama_brand', $search); // Untuk menambahkan query where OR LIKE
        }


        $this->db->where('a.data_status', 1);
        $this->db->where('b.id_toko', $id_toko);
        $this->db->where('a.id_lantai', $id_lantai);
        // $this->db->where('a.id_db_aai', 'b.id');
        $this->db->where('b.status_order >=', 2);
        $this->db->group_by('id_barang');
        $this->db->order_by('a.id', $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filter_data_lantai($search, $limit, $start, $order_ascdesc, $id_toko, $id_lantai)
    {
        $this->db->select('b.id as idDetail,b.id_barang as id_barang,a.id,b.no_po,b.ukuran,b.stock_quantity,b.stock_sold,b.tanggal_masuk,c.nama_barang,a.tanggal_terima,a.banyak, DATE_FORMAT(b.tanggal_masuk, "%m") AS bulan, DATE_FORMAT(b.tanggal_masuk, "%Y") AS tahun,a.keterangan,d.harga_baru,c.harga_akhir,(d.harga_baru - c.harga_akhir) AS margin,c.deskripsi_barang,e.nama_brand');
        $this->db->from('tbl_riwayat a');
        $this->db->join('tbl_detail_barang b', 'a.id_detail_barang=b.id_detail_barang', 'left');
        $this->db->join('tbl_barang c', 'b.id_barang=c.id_barang', 'left');
        $this->db->join('tbl_harga d', 'b.id_harga=d.id_harga', 'left');
        $this->db->join('tbl_brand e', 'e.id_brand=c.id_brand', 'left');

        if (!empty($search)) {
            $this->db->like('c.nama_barang', $search); // Untuk menambahkan query where LIKE
            $this->db->or_like('e.nama_brand', $search); // Untuk menambahkan query where OR LIKE

        }

        $this->db->where('a.data_status', 1);
        $this->db->where('b.id_toko', $id_toko);
        $this->db->where('a.id_lantai', $id_lantai);
        $this->db->where('b.status_order >=', 2);
        $this->db->group_by('id_barang');
        $this->db->order_by('a.id', $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT
        $query = $this->db->get();
        return $query->num_rows();  // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }


    function insertimport($data, $data_harga, $data_diskon, $data_cashback, $data_toko, $data_barang_update, $data_desc_diskon, $data_desc_cashback)
    {
        $this->db->insert_batch('tbl_barang', $data);
        $this->db->insert_batch('tbl_harga', $data_harga);
        $this->db->insert_batch('tbl_diskon', $data_diskon);
        $this->db->insert_batch('tbl_cashback', $data_cashback);
        $this->db->insert_batch('tbl_access_barang_toko', $data_toko);
        $this->db->insert_batch('tbl_desc_diskon', $data_desc_diskon);
        $this->db->insert_batch('tbl_desc_cashback', $data_desc_cashback);
        $this->db->update_batch('tbl_barang', $data_barang_update, 'id_barang');

        return $this->db->insert_id();
    }

    function insertbarang($data_toko)
    {
        $this->db->insert_batch('tbl_access_barang_toko', $data_toko);
        return $this->db->insert_id();
    }

    // GET ALL PRODUCT
    function get_toko()
    {
        $query = $this->db->get('tbl_access_barang_toko');
        return $query;
    }

    //GET barang BY toko ID
    function get_barang_by_toko($id_barang)
    {
        $this->db->select('*');
        $this->db->from('tbl_access_barang_toko');
        $this->db->join('tbl_barang', 'id_barang=id_toko');
        $this->db->where('id_barang', $id_barang);
        $query = $this->db->get();
        return $query;
    }

    //READ
    function get_barang($id_barang)
    {
        $hsl = $this->db->query("SELECT * FROM tbl_barang a JOIN tbl_harga b ON a.id_harga=b.id_harga where a.id_barang='$id_barang'");
        return $hsl;
    }

    //UPDATE LIST TOKO
    function update_listToko($idBrarang, $listToko)
    {
        $this->db->trans_start();
        //UPDATE TO PACKAGE



        //DELETE DETAIL PACKAGE
        $this->db->delete('tbl_access_barang_toko', array('id_barang' => $idBrarang));

        $result = array();
        foreach ($listToko as $key => $val) {
            $result[] = array(
                'id_barang'      => $idBrarang,
                'id_toko'      => $_POST['listToko'][$key]
            );
        }
        //MULTIPLE INSERT TO DETAIL TABLE
        $this->db->insert_batch('tbl_access_barang_toko', $result);
        $this->db->trans_complete();
    }

    // CREATE
    function create_barang($barang, $toko)
    {
        $this->db->trans_start();
        //INSERT TO PACKAGE
        date_default_timezone_set("Asia/Bangkok");
        $data  = array(
            // 'nama_barang' => $nambar,
            'created_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('tbl_barang', $data);
        //GET ID PACKAGE
        $id_barang = $this->db->insert_id();
        $result = array();
        foreach ($toko as $key => $val) {
            $result[] = array(
                'id_toko'   => $id_barang,
                'id_toko'   => $_POST['tbl_access_barang_toko'][$key]
            );
        }
        //MULTIPLE INSERT TO DETAIL TABLE
        $this->db->insert_batch('tbl_access_barang_toko', $result);
        $this->db->trans_complete();
    }

    function inserttoko($data_toko)
    {
        $this->db->insert_batch('tbl_access_barang_toko', $data_toko);
        return $this->db->insert_id();
    }

    // ==================================================================================================================
    public function filter_status_pengiriman($search, $limit, $start, $order_field, $order_ascdesc)
    {
        $this->db->like('nama_sp', $search); // Untuk menambahkan query where LIKE
        // $this->db->or_like('nama', $search); // Untuk menambahkan query where OR LIKE
        // $this->db->or_like('telp', $search); // Untuk menambahkan query where OR LIKE
        // $this->db->or_like('alamat', $search); // Untuk menambahkan query where OR LIKE
        $this->db->where('data_status', 1);
        $this->db->order_by($order_field, $order_ascdesc); // Untuk menambahkan query ORDER BY
        $this->db->limit($limit, $start); // Untuk menambahkan query LIMIT

        return $this->db->get('tbl_status_pengiriman')->result_array(); // Eksekusi query sql sesuai kondisi diatas
    }

    public function count_all_status_pengiriman()
    {
        // return $this->db->count_all('tbl_status_pengiriman'); // Untuk menghitung semua data tbl_status_pengiriman
        return $this->db->where('data_status', 1)->count_all('tbl_status_pengiriman'); // Untuk menghitung semua data tbl_status_pengiriman 
    }

    public function count_filter_status_pengiriman($search)
    {
        $this->db->like('nama_sp', $search); // Untuk menambahkan query where LIKE
        // $this->db->or_like('nama', $search); // Untuk menambahkan query where OR LIKE
        // $this->db->or_like('telp', $search); // Untuk menambahkan query where OR LIKE
        // $this->db->or_like('alamat', $search); // Untuk menambahkan query where OR LIKE
        $this->db->where('data_status', 1);

        return $this->db->get('tbl_status_pengiriman')->num_rows(); // Untuk menghitung jumlah data sesuai dengan filter pada textbox pencarian
    }
}
