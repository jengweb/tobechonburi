<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JS File Upload with Progress</title>
<style>
.container {
	width: 500px;
	margin: 0 auto;
}

.progress_outer {
	border: 1px solid #000;
}

.progress {
	width: 20%;
	background: #DEDEDE;
	height: 20px;
}
</style>
</head>
<body>
	<div class='container'>
		<p>
			Select File: <input type='file' id='_file'> <input type='button'
				id='_submit' value='Upload!'>
		</p>
		<div class='progress_outer'>
			<div id='_progress' class='progress'></div>
		</div>
	</div>
	<script>
    var _submit = document.getElementById('_submit'),
    _file = document.getElementById('_file'),
    _progress = document.getElementById('_progress');

    var upload = function(){

        if(_file.files.length === 0){
            return;
        }

        var data = new FormData();
        data.append('SelectedFile', _file.files[0]);

        var request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if(request.readyState == 4){
                try {
                    var resp = JSON.parse(request.response);
                } catch (e){
                    var resp = {
                        status: 'error',
                        data: 'Unknown error occurred: [' + request.responseText + ']'
                    };
                }
                console.log(resp.status + ': ' + resp.data);
            }
        };

        request.upload.addEventListener('progress', function(e){
            _progress.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
        }, false);

        request.open('POST', '/tests_upload/outputJSON/');
        request.send(data);
    }

    _submit.addEventListener('click', upload);
    </script>
</body>
</html>