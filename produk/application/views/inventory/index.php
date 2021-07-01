<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Inventory</title>
	<style>
    .bs-example{
        margin: 20px;
    }
    .navbar{
        margin-bottom: 1rem;
    }
</style>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datepicker.css">

    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
</head>

    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
        <a href="#" class="navbar-brand"> Inventory</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse2">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse2">
            <div class="navbar-nav">
                <a href="#" class="nav-item nav-link active">Home</a>
            </div>
          
        </div>
    </nav>

     <div class="container">
     <input id="url" type="hidden" value="<?=base_url('inventory/add');?>"/>
     <input id="url1" type="hidden" value="<?=base_url('inventory/update');?>"/>
     <input id="url2" type="hidden" value="<?=base_url('inventory/search');?>"/>
     <input id="url3" type="hidden" value="<?=base_url('inventory/detail');?>"/>
     <input id="url4" type="hidden" value="<?=base_url('inventory/delete');?>"/>
	 <button type="button" id="add" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap"> + Tambah Produk</button>
	 
    <div class="mt-3">
     <table id="example" class="table table-striped table-bordered " style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kode Barang</th>
                <th>Jumlah Barang</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>
    </table>
    <div>
    </div>
</body>
 
</html>
<?php  include('_partialform.php'); ?>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap4.min.js"></script>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/dataTables.responsive.min.js"></script>
<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/responsive.bootstrap4.min.js"></script>

<script type='text/javascript' src="<?php echo base_url(); ?>assets/js/inventory.js"></script>

 