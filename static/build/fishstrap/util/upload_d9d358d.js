define('fishstrap/util/upload.js', function(require, exports, module){

var $ = require('fishstrap/core/global.js');
var html5 = require('fishstrap/core/html5.js');
var imageCompresser = require('fishstrap/util/imageCompresser.js');
var jpegMeta = require('fishstrap/util/jpegMeta.js').JpegMeta;
module.exports = {
	_checkFileSize:function( file , defaultOption , nextStep ){
		function checkMaxSize(size){
			if( size > defaultOption.maxSize ){
				if( defaultOption.maxSize < 1024 )
					defaultOption.onFail('上传文件必须少于'+defaultOption.maxSize+'Byte');
				else if( defaultOption.maxSize < 1024*1024 )
					defaultOption.onFail('上传文件必须少于'+(defaultOption.maxSize/1024)+'KB');
				else
					defaultOption.onFail('上传文件必须少于'+(defaultOption.maxSize/1024/1024)+'MB');
			}else{
				nextStep();
			}
		}
		if( file.files ){
			//支持HTML5的浏览器
			if( file.files[0].size )
				checkMaxSize(file.files[0].size);
			else
				checkMaxSize(file.files[0].fileSize);
		}else{
			if( defaultOption._fileName.match(/.jpg|.jpeg|.gif|.png|.bmp/i)){
				//如果是图像文件
				var imgObj =new Image();
				imgObj.onerror = function(){
					defaultOption.onFail('图像格式不正确');
				}
				//1s内仍然没有读取到图像大小则直接到下一步
				var intervalCount = 0;
				var interval = setInterval(function(){
					intervalCount++;
					if( imgObj.fileSize > 0 ){
						checkMaxSize(imgObj.fileSize);
						clearInterval(interval);
					}else if( intervalCount == 10 ){
						clearInterval(interval);
						nextStep();
					}
				},100);
				imgObj.src = defaultOption._fileAddress;
			}else{
				//如果不是图像文件，就放过它吧，旧式浏览器无法对非图像文件获取文件大小
				nextStep();
			}
		}
	},
	_checkCanUpload:function( file,defaultOption,nextStep ){
		if ($.os.android) {
			var MQQBrowser = navigator.userAgent.match(/MQQBrowser\/([^\s]+)/);
			if (!MQQBrowser || MQQBrowser && MQQBrowser[1] < '5.2') {
				if ($.os.version.toString().indexOf('4.4') === 0 || $.os.version.toString() <= '2.1') {
					defaultOption.onFail('您的安卓手机系统暂不支持上传功能，请下载最新版的QQ浏览器');
					return;
				}
			}
		} else if ($.os.ios && $.os.version.toString() < '6.0') {
			defaultOption.onFail('您的手机系统不支持传图，请升级到ios6.0以上');
			return;
		}
		if ($.os.wx && $.os.wxVersion.toString() < '5.2') {
			defaultOption.onFail('您当前的微信版本太低，不支持传图，请升级到最新版');
			return;
		}
		nextStep(); 
	},
	_checkFileSelect:function( file , defaultOption , nextStep ){
		if( file.files ){
			//支持HTML5的浏览器
			if( file.files.length == 0 )
				return;
			defaultOption._fileName = file.files[0].name;
			var a = window.URL || window.webkitURL || false;
			if (a) {
				defaultOption._fileAddress = a.createObjectURL(file.files[0]);
			}else{
				defaultOption._fileAddress = file.value;
			}
			
		}else{
			//不支持HTML5的浏览器
			if( !file.value || file.value == null )
				return;
			defaultOption._fileName = file.value;
			//file.select();
			defaultOption._fileAddress = file.value ;
		}
		nextStep();
	},
	_checkFileType:function( file , defaultOption , nextStep ){
		//测试后缀来检查文件类型
		if( defaultOption.type && defaultOption.type != null ){
			var isAllow = false;
			var allowTypes = defaultOption.type.split('|');
			for( var i in allowTypes ){
				var allowType = $.trim(allowTypes[i]);
				if( allowType == "")
					continue;
				var allowType = '.'+allowType;
				if( defaultOption._fileName.substring( 
					defaultOption._fileName.length - allowType.length ) == allowType ){
					isAllow = true;
					break;
				}
			}
			if( !isAllow ){
				defaultOption.onFail('仅支持上传以下格式的文件：'+defaultOption.type);
				return;
			}
		}
		nextStep();
	},
	_readImage:function( file,defaultOption , nextStep ){
		html5.fileReader.open({
			file:file.files[0],
			mode:'binary',
			onSuccess:function(data){
				defaultOption._fieldata = data;
				nextStep();
				return;
			},
			onFail:function(msg){
				defaultOption.onFail(msg);
				return;
			},
		});
	},
	_compressImage:function( file,defaultOption , nextStep ){
		//配置压缩图片的选项
		var conf = {
			quality: defaultOption.quality,
			scale: 0,
			orien:1,
		};
		if( defaultOption.width && defaultOption.width != null)
			conf.maxW = defaultOption.width;
		if( defaultOption.height && defaultOption.height != null)
			conf.maxH = defaultOption.height;
		if( conf.maxW && conf.maxH )
			conf.scale = conf.maxW/conf.maxH ;
		if (file.files[0].type == 'image/jpeg') {
			try {
				var jpg = new jpegMeta.JpegFile(defaultOption._fieldata,defaultOption._fileName);
			} catch (e) {
				$.console.warn('读取jpeg的meta数据失败'+e);
			}
			if (jpg&&jpg.tiff && jpg.tiff.Orientation) {
				conf = $.extend(conf, {
					orien: jpg.tiff.Orientation.value
				});
			}
		}
		//读取并压缩图片
		var img = new Image();
		img.onload = function() {
			var uploadBase64;
			try {
				uploadBase64 = imageCompresser.getImageBase64(this, conf);
			} catch (e) {
				defaultOption.onFail('压缩图片失败 '+e);
				return false;
			}
			if (uploadBase64.indexOf('data:image') < 0) {
				defaultOption.onFail('上传照片格式不支持');
				return false;
			}
			defaultOption._uploadData = uploadBase64.split(';base64,')[1];
			nextStep();
		}
		img.onerror = function() {
			defaultOption.onFail('读取图片数据失败');
			return false;
		}
		img.src = defaultOption._fileAddress;//imageCompresser.getFileObjectURL(file);
	},
	_uploadImage:function( file,defaultOption  ){
		//制作虚假的进度条，1000毫秒自动往上增加5%
		defaultOption._progress = 1;
		defaultOption._progressInterval = 0;
		defaultOption.onProgress(defaultOption._progress);
		defaultOption._progressInterval = setInterval(function(){
			if( defaultOption._progress + 5 >= 100 ){
				clearInterval(defaultOption._progressInterval);
				defaultOption._progressInterval = null;
				return;
			}
			defaultOption._progress += 5 ;
			defaultOption.onProgress(defaultOption._progress);
		},1000);
		//构造数据，提交表单
		var formData = new FormData();
		formData.append('data', defaultOption._uploadData);
		var progress = function(e) {
			if(e.lengthComputable){
				defaultOption._progress = Math.ceil(100 * (e.loaded / e.total));
				defaultOption.onProgress(defaultOption._progress);
			}
		}
		var complete = function(e) {
			defaultOption.onSuccess(e.target.response);
		}
		var failed = function() {
			defaultOption.onFail('网络断开，请稍后重新操作');
		}
		var abort = function() {
			defaultOption.onFail('上传已取消');
		}
		var httpReuqest = new XMLHttpRequest();
		if( httpReuqest.upload ){
			httpReuqest.upload.addEventListener('progress',progress, false);
		}
		httpReuqest.addEventListener('progress',progress, false);
		httpReuqest.addEventListener("load", complete, false);
		httpReuqest.addEventListener("abort", abort, false);
		httpReuqest.addEventListener("error", failed, false);
		httpReuqest.open("POST", defaultOption.url + '?t=' + Date.now(),true);
		httpReuqest.send(formData);
	},
	_iframeUpload:function(frameId,formId,defaultOption){
		//制作虚假的进度条，1000毫秒自动往上增加5%
		defaultOption._progress = 1;
		defaultOption._progressInterval = 0;
		defaultOption.onProgress(defaultOption._progress);
		defaultOption._progressInterval = setInterval(function(){
			if( defaultOption._progress + 5 >= 100 ){
				clearInterval(defaultOption._progressInterval);
				defaultOption._progressInterval = null;
				return;
			}
			defaultOption._progress += 5 ;
			defaultOption.onProgress(defaultOption._progress);
		},1000);
		//提交表单
		$('#'+formId).submit();
	},
	file:function( option ){
		var self = this;
		//初始化option
		var defaultOption = {
			url:'',
			target:'',
			field:'',
			type:null,
			maxSize:null,
			accept:null,
			onProgress:function(data){
			},
			onSuccess:function(){
			},
			onFail:function(msg){
			},
		};
		for( var i in option ){
			defaultOption[i] = option[i];
		}
		//绘制图形
		var div = "";
		var formId = $.uniqueNum();
		var frameId = $.uniqueNum();
		var fileId = $.uniqueNum();
		if(defaultOption.accept)
			defaultOption.accept = 'accept="'+defaultOption.accept+'"';
		div = '<form id="'+formId+'" action="'+defaultOption.url+'" target="'+frameId+'" method="post" enctype="multipart/form-data" style="opacity:0;display:block;position:absolute;top:0px;bottom:0px;left:0px;right:0px;width:100%;height:100%;z-index:9;overflow:hidden;">'+
			'<input type="file" id="'+fileId+'" style="width:100%;height:100%;font-size:1000px;" name="'+defaultOption.field+'"'+defaultOption.accept+'/>'+
			'<iframe name="'+frameId+'" id="'+frameId+'" style="display:none">'+
		'</form>';
		div = $(div);
		$('#'+defaultOption.target).css('position','relative');
		$('#'+defaultOption.target).append(div);
		
		//挂载iframe载入事件
		$('#'+frameId).load(function(){
			//iframe载入事件会触发两次，一次是空白页面，第二次是提交文件后的页面
			//检查progress是否存在就能区分这两种事件了。
			if(!defaultOption._progress)
				return;
			var result;
			if(this.contentWindow){
				result = $(this.contentWindow.document.body).html();
			}else{
				result = $(this.contentDocument.document.body).html();
			}
			clearInterval(defaultOption._progressInterval);
			defaultOption.onProgress(100);
			defaultOption.onSuccess(result);
		});
		//挂载上传事件操作
		div.find('input').on('change',function(){
			var file = this;
			self._checkCanUpload( file , defaultOption , function(){
				self._checkFileSelect( file , defaultOption , function(){
					self._checkFileType( file , defaultOption , function(){
						self._checkFileSize( file , defaultOption , function(){
							self._iframeUpload(frameId,formId,defaultOption);
						});
					});
				});
			});
		});
	},
	image:function( option ){
		var self = this;
		var isHtml5Support;
		if( window.File&&window.FileList&&window.FileReader&&window.Blob)
			isHtml5Support = true;
		else
			isHtml5Support = false;
		if( isHtml5Support == false ){
			//不支持HTML5的浏览器则直接使用普通上传模式，不会在客户端进行压缩图片后再上传
			option.type = 'png|jpg|jpeg|gif|bmp';
			option.accept = 'image/*';
			return self.file( option );
		}
		//初始化option
		var defaultOption = {
			url:'',
			target:'',
			field:'',
			width:null,
			height:null,
			quality:0.8,
			onProgress:function(data){
			},
			onSuccess:function(){
			},
			onFail:function(msg){
			},
		};
		for( var i in option ){
			defaultOption[i] = option[i];
		}
		defaultOption.type = 'png|jpg|jpeg|gif|bmp';
		//绘制图形
		var div = "";
		var fileId = $.uniqueNum();
		if(defaultOption.accept)
			defaultOption.type = 'accept="image/*"';
		div = '<input id="'+fileId+'" type="file" name="'+defaultOption.field+ '" style="opacity:0;display:block;position:absolute;top:0px;bottom:0px;left:0px;right:0px;width:100%;height:100%;z-index:9;font-size:1000px;" accept="image/*">';
		div = $(div);
		$('#'+defaultOption.target).css('overflow','hidden');
		$('#'+defaultOption.target).css('position','relative');
		$('#'+defaultOption.target).append(div);
		//挂载上传事件操作
		div.on('change',function(){
			var file = this;
			self._checkCanUpload( file , defaultOption , function(){
				self._checkFileSelect( file , defaultOption , function(){
					self._checkFileType( file , defaultOption , function(){
						self._readImage( file , defaultOption , function(){
							self._compressImage( file , defaultOption , function(){
								self._uploadImage( file,defaultOption);
							});
						});
					});
				});
			});
		});
	}
};

});