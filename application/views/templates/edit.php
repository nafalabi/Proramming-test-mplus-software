<main id="create home" class="mt-5">
	<div class="wrapper container">

		<div class="heading">
			<h1>Edit Data</h1>
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
		
		<?php echo form_open(base_url().'index.php/book/edit/'.$result['id']);?>
			
			<?php echo form_hidden('id',$result['id'])?>
			
			<div class="form-group">
				<label for="title">Title</label>
				<input class="form-control" name="title" 
					value="<?php echo $result['title']?>" required>		
				</input>
			</div>

			<div class="form-group">
				<label for="author">Author</label>
				<select name="author" class="form-control" id="author" required>
					<?php for($i=0;$i < count($authors); $i++) {?>
					<?php extract($authors[$i]);?>
					<option 
						value="<?php echo $author_id;?>" 
						<?php if($author_id==$result['author_id']){echo ' selected';}?>>
						<?php echo $name;?>
					</option>}
					<?php } //End of For loop?>
					<option value="new">- Insert New Author -</option>
				</select>
				<input class="form-control" name="newAuthor" id="newAuthor" placeholder="Insert new author here" hidden></input>
			</div>

			<div class="form-group">
				<label for="date-published">Date Published</label>
				<input class="form-control" 
					value="<?php echo $result['date_published'];?>" disabled>
				</input>
			</div>

			<div class="form-group">
				<label for="pages">Number of Pages</label>
				<input class="form-control" name="pages" type="number" 
					value="<?php echo $result['number_of_pages'];?>">
				</input>
			</div>

			<div class="form-group">
				<label for="type">Type of Book</label>
				<select name="type" class="form-control" id="type">
					<?php for($i=0;$i < count($types); $i++) {?>
					<?php extract($types[$i]);?>
					<option 
						value="<?php echo $type_id;?>" 
						<?php if($type_id==$result['type_id']){echo ' selected';}?>>
						<?php echo $name;?>
					</option>}
					<?php } //End of For loop?>
					<option value="new">- Insert New Type -</option>
				</select>
				<input class="form-control" name="newType" id="newType" placeholder="Insert new type here" hidden></input>
			</div>

			<div class="form-group">
				<input class="btn btn-block btn-primary" type="submit" value="Edit"></input>
				<a class="btn btn-danger btn-block" href="<?php echo base_url()?>">Cancel</a>
			</div>
		<?php echo form_close()?>
	</div>
</main>