<!DOCTYPE html>
<html>
<head>
	<title></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</head>
<body>
hola mundo

<select class="js-example-basic-single" name="state">
  <option value="AL">Alabama</option>
    ...
  <option value="WY">Wyoming</option>
</select>

<script type="text/javascript">
	

$(document).ready(function() {
    $('.js-example-basic-single').select2();
});

</script>
</body>
</html>