var fs = require('fs');
var jsdom = require('jsdom');
var mkdirp = require('mkdirp');
var Utils = require('./helpers/Utils.js');
var jquery = fs.readFileSync("jquery-1.12.1.min.js", "utf-8");
try{
	var dataStore = 'E:/phuongnv/me/data/';
	var urlSite='http://demohtml.templatesquare.com/lastore/index.html';
	var domainName = 'http://demohtml.templatesquare.com/lastore';
	var folderName = domainName.replace('http://','');
	var folderName = folderName.replace(/\//g,'.');
	var DataPath = dataStore+folderName+'/';

	var Assets={
		downloadFileTo: function(fileSource, fileDest, callback)
		{
			Utils.download(fileSource,fileDest,function(res){
				callback(res);
			})
		},
		parseAndCreatPath: function(href)
		{
			var self=this;
			var arrayE = href.split('/');
			var pathE = [];
			for(var i=0; i< (arrayE.length-1); i++){
				pathE.push(arrayE[i]);
			}
			var aPath = pathE.join('/');
			var folderPathR = DataPath+aPath+'/';
			return folderPathR;
		},
		crawl: function(href)
		{
			if(href!=undefined && href.indexOf('http')==-1){
				var self=this;
				var folderFilePath = self.parseAndCreatPath(href);
				if(!fs.existsSync(folderFilePath)){
                    console.log('create folder');
                    mkdirp.sync(folderFilePath);
                }

				var fileSource = domainName+'/'+href;
				var fileDest = DataPath+href;
				try {
				    fs.accessSync(fileDest, fs.F_OK);
				    // Do something
				} catch (e) {
				    // It isn't accessible
				    //console.log('e',e);
				    Utils.download(fileSource,fileDest,function(res){
						console.log('download|'+fileDest+'|',res);
					})
				}
			}
		}
	}

	mkdirp(DataPath, function (err) {
	    if (err) console.error(err)
	    else {
	    	console.log('Great!'+DataPath);
	    	jsdom.env({
				url: urlSite,
		        src: [jquery],
		        done: function (err, window) {
		        	if(typeof window === 'object'){
		        		var $ = window.$;
				    	var HTML=[];
			    		$("html").find("a[href$='.html']").each(function(){
			    			var href = $(this).attr('href');
			    			if(HTML.indexOf(href)==-1){
			    				console.log('href',href);
			    				HTML.push(href);
			    				Assets.crawl(href);
			    				var subUrlSite = domainName+'/'+href;
			    				jsdom.env({
									url: subUrlSite,
							        src: [jquery],
							        done: function (err, window) {
							        	if(typeof window === 'object'){
							        		var $ = window.$;
							        		
							        		//find and crawl img
							        		var img = [];
							        		$("html").find("img").each(function(img){
							        			var src = $(this).attr('src');
							        			Assets.crawl(src);
							        		});
							        		//find and crawl css
							        		$("html").find("link").each(function(){
							        			var href = $(this).attr('href');
							        			Assets.crawl(href);
							        		});
							        		//find and crawl js
							        		$("html").find("script").each(function(){
							        			var src = $(this).attr('src');
							        			Assets.crawl(src);
							        		});
							        	}else{
							        	 	console.log('window is not a object');
							        	}
							        }
								});
			    			}
			    		})
		    		}
		    	}
		    });
		}	
	});
	
}catch(e)
{
	console.log('Exception: '+e);
}

