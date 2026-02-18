<?php $this->load->view('transactions_list', $transactions ? get_defined_vars() : []); ?>
<?php $this->load->view('pagination', $transactions ? get_defined_vars() : []); ?>
