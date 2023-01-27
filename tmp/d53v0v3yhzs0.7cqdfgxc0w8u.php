<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Whois Information System ~ Educollabs</title>
    <base href="<?= ($SCHEME.'://'.$HOST.$BASE.'/') ?>">
	<link rel="stylesheet" href="assets/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="shortcut icon" href="assets/img/icon.png">
	
	<style>
		body {
			background-image: url('assets/img/bg.jpg');
			background-repeat: no-repeat;
			background-size: cover;
			background-attachment:fixed;
			}
	</style>
	
  </head>
  <body>

	<div class="container">
	
		<div style="padding:50px;" class="text-center">
			<a href="https://dev.educollabs.org"><img src="assets/img/logo.png" width="300"/></a>
		</div>
		<div class="header text-center clearfix">
			<h3 class="text-muted">Whois Information Domain System</h3>
		</div>

		<div class="jumbotron text-center">
			<h1>Domain Whois</h1>
			<p class="lead">You can check ~1500 tlds' whois info</p>
			<div>
				<div class="input-append">
					<input type="text" class="form-control input-xxlarge" id="whoisWr" placeholder="Type domain here without www...">
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" id="checkWhois">Whois Lookup!</button>
					</span>
				</div><!-- /input-group -->
				<h2 class="text-center">or</h2>
				<div class="input-append">
					<input type="text" class="form-control input-xxlarge" id="bulkwhoisWr" placeholder="Search for domains..."></input>
					<span class="input-group-btn">
						<button class="btn btn-primary" type="button" id="checkbulkWhois">Bulk Whois Lookup!</button>
					</span>
				</div>
			</div>
		</div>
		<br>
		<div class="row" id="whoisdata" style="display:none;">
			<div class="col-md-12">
				<div class="well well-large" style="background-color:white;" id="winn">
				</div>
			</div>
		</div>
		<hr>
		<div class="row" id="bulkwhoisdata" style="display:none;">
			<div class="col-md-12">
				<table class="table table-responsive table-hover" style="background-color:white;" id="bulkwinn">
					<tbody class="info">
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="well well-large">
					<p align="justify"><strong>Supported TLD'S :</strong> <?= (implode(', ', $supported)) ?></p>
				</div>
			</div>
		</div>

      <footer class="footer text-center">
        <p><a href="https://educollabs.org">Smart Edutechno Collaborations</a> Whois &copy; 2022 Educollabs | MIT Open Source Licence</p>
      </footer>

    </div> <!-- /container -->



   
	<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="<?= ($UI) ?>ajax.js"></script>
    <script>
    $(document).ready(function(){
        $("#checkWhois").on("click",function(){
        $("#whoisdata").hide();
        $this = $(this);
        $this.prop("disabled", true);
        var domain = $("#whoisWr").val();
        $.post("<?= ($BASE) ?>/whois", {domain:domain}, function(data, textStatus) {

        if(data.status=="success") {
        $("#winn").html(data.data);
        $("#whoisdata").show();
        $this.prop("disabled", false); 
        }
        else if(data.status=="error") {
        alert(data.data);
        $this.prop("disabled", false);
        } else {
        alert("Server Alert! Please contact admin");
        $this.prop("disabled", false);
        }
        }, "json");

        });
		ajaxManager.run(); 
        $("#checkbulkWhois").on("click",function(){
        $("#whoisdata").hide();
        $("#bulkwhoisdata").hide();
        $this = $(this);
        $this.prop("disabled", true);
        var domain = $("#bulkwhoisWr").val();
        $.post("<?= ($BASE) ?>/bulkwhois", {domain:domain}, function(data, textStatus) {

        if(data.status=="success") {
		$('#bulkwinn tbody').html("");
		var defdomains = data.data;
		$.each(defdomains, function(i, dom) {
		ajaxManager.addReq({
				   type: 'POST',
				   url: '<?= ($BASE) ?>/whois',
				   data: {domain:dom },
				   success: function(data){
				   if(data.status=="success") {
					$('#bulkwinn tbody').append('<tr><td><h2>'+ dom+ '</h2></td></tr><tr><td>'+data.data+'</td></tr>');	
					} else {
					$('#bulkwinn tbody').append('<tr><td><h2>'+ dom+ '</h2></td></tr><tr><td>Can not get whois info for '+dom+'</td></tr>');	
					}
				   }
		});		
		
		

		});		
        $("#bulkwhoisdata").show();
        $this.prop("disabled", false); 
        }
        else if(data.status=="error") {
        alert(data.data);
        $this.prop("disabled", false);
        } else {
        alert("Server Alert! Please contact admin");
        $this.prop("disabled", false);
        }
        }, "json");

        });
    });
    </script>
  </body>
</html>