<main id="create home" class="mt-5">
	<div class="wrapper container">

		<div class="heading">
			<h1>Delete Data</h1>
			<hr>
		</div>

		<?php if(validation_errors()): ?>
		<div class="alert alert-warning">
			<?php echo validation_errors();?>
		</div>
		<?php endif?>

		<?php if($this->session->flashdata('warning')): ?>
		<div class="alert alert-warning">
			<?php echo $this->session->flashdata('warning');?>
		</div>
		<?php endif?>

		<?php if($this->session->flashdata('success')): ?>
		<div class="alert alert-success">
			<?php echo $this->session->flashdata('success');?>
		</div>
		<?php endif?>
		
		<?php echo form_open(base_url().'index.php/book/delete/'.$result['id']);?>

			<?php extract($result);?>
			<?php echo form_hidden('id',$id)?>
			
			<div class="form-group">
				<div class="title">
					<h3><?php echo $title?></h3>
				</div>
				<div class="details">
					<div class="row">
						<p class="col-md-3">Author</p>
						<p class="col-md-9"><?php echo $author_name?></p>
					</div>
					<div class="row">
						<p class="col-md-3">Date Published</p>
						<p class="col-md-9"><?php echo $date_published?></p>
					</div>
					<div class="row">
						<p class="col-md-3">Number of Pages</p>
						<p class="col-md-9"><?php echo $number_of_pages?></p>
					</div>
					<div class="row">
						<p class="col-md-3">Type of Book</p>
						<p class="col-md-9"><?php echo $type_name?></p>
					</div>
				</div>
			</div>

			<div class="form-group">
				<input type="text" name="confirm" class="form-control" required>
				<small id="confirmhelp" class="form-text text-muted">
					Please type "CONFIRM" (all capitalize) in the field above
				</small>
			</div>

			<div class="form-group">
				<input class="btn btn-block btn-danger" type="submit" value="Delete"></input>
				<a class="btn btn-primary btn-block" href="<?php echo base_url()?>">Cancel</a>
			</div>
		<?php echo form_close()?>
	</div>
</main>