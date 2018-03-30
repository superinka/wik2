
<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
 
    <title>Quiz Online</title>
 
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen" />
 
    <!-- Custom CSS -->
    <link href="<?php echo base_url('app') ?>/assets/css/custom.css" rel="stylesheet" media="screen" />
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
 
</head>
<body>
 
    <!-- container -->
    <div class="container">
 
        <div class="page-header">
            <h1>Danh sách đề thi</h1>
        </div>
        <?php if ($message){$this->load->view('message',$this->data); }?>
        <!-- placeholder for rendering react components -->
        <div id='app'></div>
 
    </div>
    <!-- /container -->
 
<!-- react js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.1.0/react.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.1.0/react-dom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.34/browser.min.js"></script>

<!-- axios -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>

 
<!-- react code -->

<script type="text/babel" src="<?php echo base_url('app') ?>/main.component.js"></script>
 
 
</body>
</html>