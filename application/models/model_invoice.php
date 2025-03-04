<?php
class model_invoice extends CI_Model
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');
        $nama = $this->input->post('nama');
        $alamat = $this->input->post('alamat');
        $invoice = [
            'nama' => $nama,
            'alamat' => $alamat,
            'tgl_pesan' => date('Y-m-d H:i:s'),
            'batas_bayar' => date('Y-m-d H:i:s', mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 1, date('Y')))
        ];

        $this->db->insert('tb_invoice', $invoice);
        $id_invoice = $this->db->insert_id();

        foreach ($this->cart->contents() as $item) {
            $data = [
                'id_invoice' => $id_invoice,
                'id_barang' => $item['id'],
                'nama_brg' => $item['name'],
                'jumlah' => $item['qty'],
                'harga' => $item['price']
            ];
            $this->db->insert('tb_pesanan', $data);
        }
        return true;
    }

    public function tampil_data()
    {
        $result = $this->db->get('tb_invoice');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }



    public function getInvoicebyId($id_invoice)
    {
        $result = $this->db->where('id', $id_invoice)->get('tb_invoice');
        if ($result->num_rows() > 0) {
            return $result->row_array();
        } else {
            return false;
        }
    }

    public function getPesananbyId($id_invoice)
    {
        $result = $this->db->where('id_invoice', $id_invoice)->get('tb_pesanan');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else {
            return false;
        }
    }
} 