	<main id="list home" class="mt-5">
		<div class="wrapper container">
		<?php if($status==true) :?>
			<?php for ($i=0;$i < count($value);$i++) {?>
			<?php extract($value[$i]);?>
			<div class="entry mb-3">
				<div class="title">
					<h3 class="title-text"><?php echo $title ?></h3>
				</div>
				<div class="details container">
					<div class="author row">
						<div class="detail col-md-3">Author</div>
						<div class="value col-md-"><?php echo $author;?></div>
					</div>
					<div class="date row">
						<div class="detail col-md-3">Date Published</div>
						<div class="value col-md-"><?php echo $date_published;?></div>
					</div>
					<div class="pages row">
						<div class="detail col-md-3">Number of Pages</div>
						<div class="value col-md-"><?php echo $number_of_pages;?></div>
					</div>
					<div class="type row">
						<div class="detail col-md-3">Type of Book</div>
						<div class="value col-md-"><?php echo $type?></div>
					</div>
				</div>
			</div>
			<hr>
			<?php }?>
		<?php else :?>
			<div class="alert alert-warning" role="alert">
				No Data
			</div>
		<?php endif?>
		</div>
	</main>