<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title?></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

	<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Books </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExample03">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item 
				<?php if($page=='list') {echo 'active';}?>">
					<a class="nav-link" 
					href="<?php echo base_url().'index.php/book/'?>">
						List Book
					</a>
				</li>
				<li class="nav-item 
				<?php if($page=='create') {echo 'active';}?>">
					<a class="nav-link" 
					href="<?php echo base_url().'index.php/book/create'?>">
						Create New Book
					</a>
				</li>
			</ul>
		</div>
	</nav>

<?php echo $main?>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<!-- script for insert new author and type of book -->
	<script>
		var dropdownAuthor = document.querySelector('#author');
		var dropdownType = document.querySelector('#type');
		var newAuthor = document.querySelector('#newAuthor');
		var newType = document.querySelector('#newType');
		var authorVisibility = false;
		var typeVisibility = false;

		//Event for 
		dropdownAuthor.addEventListener('change',function() {
			if (dropdownAuthor.value=='new') {
				newAuthor.removeAttribute('hidden');
				authorVisibility = true;
			}
			else {
				newAuthor.setAttribute('hidden','');
				authorVisibility = false;
			}
		});

		dropdownType.addEventListener('change',function() {
			if (dropdownType.value=='new') {
				newType.removeAttribute('hidden');
				authorVisibility = true;
			}
			else {
				newType.setAttribute('hidden','');
				authorVisibility = false;
			}
		});
	</script>
	<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>
</body>
</html>
