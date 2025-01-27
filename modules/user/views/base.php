<?php
    if ($section) {
        foreach ($section as $row) {
            $data['detail'] = $row;
            $data['attribut'] = $attribut;
            $this->load->view('section/'.$row->file,$data);
        }
    }
?>