<?php
require dirname(__FILE__)."/../../libraries/CI_Util.php";
require dirname(__FILE__)."/../../libraries/CI_Log.php";

$ses = isset($_POST['session'])?$_POST['session']:'';
$session = "";
if($ses == ""){
	echo "请登录...";
	exit();
}

$requestMethod = $_SERVER['REQUEST_METHOD'];
	
$theTime = date('y-m-d h:i:s',time());
//$who = "李明";
$who = getMemberFromIP();
$where = "从".$_SERVER["REMOTE_ADDR"];
$doThings = "访问了添加设备页面";
writeToLog($theTime,$who,$where,$doThings);

?>

<link href="<?php echo base_url();?>static/devMS/css/addDevices/addDevices.css" rel="stylesheet"/>
<div id="add_devices">
	<div>
	<table>
			<tr>
				<td>
					<label>设备名：</label>
					<input id="dev_name" class="form-control input_style" style="margin-left:15px;"></input>
				</td>
				<td>
					<label>型号：</label>
					<input id="dev_model" class="input_style form-control"></input>
				</td>
				<td>
					<label>编号：</label>
					<input id="dev_num" class="input_style form-control" style="margin-left:15px;"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label>平台：</label>
					<select id="dev_plateform"  class="input_style form-control" style="margin-left:30px;">
						<option value="android">Android</option>
						<option value="ios">iOS</option>
					</select>
				</td>
				<td>
					<label>所属：</label>
					<input id="dev_owner" class="input_style form-control"></input>
				</td>
				<td>
					<label>品牌：</label>
					<input id="dev_brand" class="input_style form-control" style="margin-left:15px;"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label class="label_style">系统版本：</label>
					<input id="dev_version" class="form-control input_style"></input>
				</td>
				<td>
					<label>分类：</label>
					<select id="dev_category"  class="input_style form-control" style="margin-left:0px;">
						<option value="手机">手机</option>
						<option value="平板">平板</option>
						<option value="台式机">台式机</option>
						<option value="其他">其他</option>
					</select>
				</td>
				<td>
					<label>分辨率：</label>
					<input id="dev_resolution" class="form-control input_style"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label>CPU：</label>
					<input id="dev_cpu"  class="input_style form-control" style="margin-left:30px;"></input>
				</td>
				<td>
					<label>GPU：</label>
					<input id="dev_gpu"  class="input_style form-control"></input>
				</td>
				<td>
					<label>Cores：</label>
					<input id="dev_cores" class="input_style form-control"></input>
				</td>
			</tr>
			<tr>
				<td>
					<label>HDExpt：</label>
					<select id="dev_hdexport"  class="input_style form-control" style="margin-left:15px;">
						<option value="0">480P</option>
						<option value="1">720P</option>
						<option value="2">1080P</option>
						<option value="3">2K</option>
					</select>
				</td>
				<td>
					<label>1080P拍摄：</label>
					<select id="dev_hdcamera"  class="input_style form-control">
						<option value=""></option>
						<option value="0">No</option>
						<option value="1">Yes</option>
					</select>
				</td>
				<td>
					<label>Architecture：</label>
					<input id="dev_architecture" class="input_style form-control"></input>
				</td>
			</tr>
			<tr>
				<td colSpan="2">
					<label>其他：</label>
					<input id="dev_other" class="input_style form-control" style="margin-left:15px;width:400px;"></input>
				</td>
			</tr>
			<tr>
				<td colSpan="3">
					<label style=";float:left;">备注：</label>
					<textArea id="dev_comments" class="input_style form-control" style="margin-left:20px;width:400px;height:150px;"></textArea>
				</td>
			</tr>
			<tr>
				<td colSpan="3" style="background-color:#cccccc;padding:0px;">
					<div class="container" style="padding-top:5px;">
					<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data" >
					<!-- Redirect browsers with JavaScript disabled to the origin page -->
					<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
					<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
					<div class="row fileupload-buttonbar">
						<div class="col-lg-7" style="padding-top:0px">
							<!-- The fileinput-button span is used to style the file input field as button -->
							<span class="btn btn-success fileinput-button">
								<input type="file" name="files[]" multiple>
							</span>
							<button type="submit" class="btn btn-primary start">
								<i class="glyphicon glyphicon-upload"></i>
								<span>Start upload</span>
							</button>
							<button type="reset" class="btn btn-warning cancel">
								<i class="glyphicon glyphicon-ban-circle"></i>
								<span>Cancel upload</span>
							</button>
							<button type="button" class="btn btn-danger delete">
								<i class="glyphicon glyphicon-trash"></i>
								<span>Delete</span>
							</button>
							<input type="checkbox" class="toggle">
							<span class="fileupload-process"></span>
						</div>
					<table role="presentation" class="table table-striped" style="margin-top:40px;margin-bottom:5px;"><tbody class="files"></tbody></table>
				</form>
				<br>
				
			</div>
			
				<script id="template-upload" type="text/x-tmpl">
				{% for (var i=0, file; file=o.files[i]; i++) { %}
					<tr class="template-upload fade">
						<td>
							<span class="preview"></span>
						</td>
						<td>
							<p class="name">{%=file.name%}</p>
							<strong class="error text-danger"></strong>
						</td>
						<td>
							<p class="size">Processing...</p>
							<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
						</td>
						<td>
							{% if (!i && !o.options.autoUpload) { %}
								<button class="btn btn-primary start" disabled>
									<i class="glyphicon glyphicon-upload"></i>
									<span>Start</span>
								</button>
							{% } %}
							{% if (!i) { %}
								<button class="btn btn-warning cancel">
									<i class="glyphicon glyphicon-ban-circle"></i>
									<span>Cancel</span>
								</button>
							{% } %}
						</td>
					</tr>
				{% } %}
				</script>
				<!-- The template to display files available for download -->
				<script id="template-download" type="text/x-tmpl">
				{% for (var i=0, file; file=o.files[i]; i++) { %}
					<tr class="template-download fade">
						<td>
							<span class="preview">
								{% if (file.thumbnailUrl) { %}
									<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
								{% } %}
							</span>
						</td>
						<td>
							<p class="name">
								{% if (file.url) { %}
									<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
								{% } else { %}
									<span>{%=file.name%}</span>
								{% } %}
							</p>
							{% if (file.error) { %}
								<div><span class="label label-danger">Error</span> {%=file.error%}</div>
							{% } %}
						</td>
						<td>
							<span class="size">{%=o.formatFileSize(file.size)%}</span>
						</td>
						<td>
							{% if (file.deleteUrl) { %}
								<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl.split('?')[0] + 'index.php/Welcome/server/?' + file.deleteUrl.split('?')[1]%}"{% if (file.deleteWithCredentials) { %} 
								data-xhr-fields='{"withCredentials":true}'{% } %}>
									<i class="glyphicon glyphicon-trash"></i>
									<span>Delete</span>
								</button>
								<input type="checkbox" name="delete" value="1" class="toggle">
							{% } else { %}
								<button class="btn btn-warning cancel">
									<i class="glyphicon glyphicon-ban-circle"></i>
									<span>Cancel</span>
								</button>
							{% } %}
						</td>
					</tr>
				{% } %}
				</script>



					<!--<label>照片：</label>
					<button id="upload_pic" type="button" class="btn btn-sm btn-success" sytle="margin-left:10px;">上传图片</button>
					<label id="dev_pic_path" style="margin-left:10px;position:absolute;padding-top:5px;">the picture path</label>-->
				</td>
			</tr>
			<tr>
				<td colSpan="3" _style="background-color:#cccccc;padding:0px;">				
					<button id="dev_add_but" type="button" class="btn btn-primary">添 加 设 备</button>
					<button id="test" type="button" class="btn btn-primary">test</button>
				</td>
			</tr>
		</table>	
	</div>


</div>

<script src="<?php echo base_url();?>static/devMS/js/addDevices/addDevices.js"></script>


<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url();?>static/dist/js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="<?php echo base_url();?>static/dist/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?php echo base_url();?>static/dist/js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?php echo base_url();?>static/dist/js/main.js"></script>