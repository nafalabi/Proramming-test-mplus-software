<main id="create home" class="mt-5">
	<div class="wrapper container">

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
		
		<?php echo form_open(base_url().'index.php/book/create');?>
			<div class="form-group">
				<label for="title">Title</label>
				<input class="form-control" name="title" required></input>
			</div>

			<div class="form-group">
				<label for="author">Author</label>
				<select name="author" class="form-control" id="author" required>
					<option value="">-- Select --</option>
					<?php for($i=0;$i < count($authors); $i++) {?>
					<?php extract($authors[$i]);?>
					<option 
						value="<?php echo $author_id;?>">
						<?php echo $name;?>
					</option>}
					<?php } //End of For loop?>
					<option value="new">- Insert New Author -</option>
				</select>
				<input class="form-control" name="newAuthor" id="newAuthor" placeholder="Insert new author here" hidden></input>
			</div>

			<div class="form-group">
				<label for="date-published">Date Published</label>
				<input class="form-control" value="<?php echo date('d M Y', time())?>" disabled></input>
			</div>

			<div class="form-group">
				<label for="pages">Number of Pages</label>
				<input class="form-control" name="pages" type="number"></input>
			</div>

			<div class="form-group">
				<label for="type">Type of Book</label>
				<select name="type" class="form-control" id="type">
					<option value="">-- Select --</option>
					<?php for($i=0;$i < count($types); $i++) {?>
					<?php extract($types[$i]);?>
					<option 
						value="<?php echo $type_id;?>">
						<?php echo $name;?>
					</option>}
					<?php } //End of For loop?>
					<option value="new">- Insert New Type -</option>
				</select>
				<input class="form-control" name="newType" id="newType" placeholder="Insert new type here" hidden></input>
			</div>

			<div class="form-group">
				<input class="btn btn-block btn-primary" type="submit" value="Create"></input>
			</div>
		<?php echo form_close()?>
	</div>
</main>