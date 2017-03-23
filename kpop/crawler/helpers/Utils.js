var slug    = require('slug');
var request = require('request');
var http = require('http');
var fs = require('fs');
var params = require('../config/params.js');
var Utils = {
	WriteToFile: function(fs,filePath, content){
		fs.writeFile(filePath, content, function(err) {
	        if(err) {
	            return console.log(err);
	        }
	        console.log("<h1>The file was saved!</h1>");
    	});
	},
	slug: function(text){
		slug.defaults.modes['pretty'] = {
		    replacement: '-',
		    symbols: true,
		    remove: /[.]/g,
		    lower: true,
		    charmap: slug.charmap,
		    multicharmap: slug.multicharmap
		};
		return slug(text);
	},
	/**
	* Example:
	*	download('https://www.google.com/images/srpr/logo3w.png', 'google.png', function(){
	*	  console.log('done');
	*	});
	*/
	/*download: function(uri, filename, callback){
	  request.head(uri, function(err, res, body){
	    console.log('content-type:', res.headers['content-type']);
	    console.log('content-length:', res.headers['content-length']);
	    switch(filename)
	    {
	    	case 'image/png':
	    		filename = filename+'.png';
	    		break;
	    	default:
	    		filename = filename+'.jpg';
	    		break;
	    }
	    request(uri).pipe(fs.createWriteStream(filename)).on('close', callback);
	  });
	},*/
	download: function(url, dest, cb) {
	  var file = fs.createWriteStream(dest);
	  var request = http.get(url, function(response) {
	    response.pipe(file);
	    file.on('finish', function() {
	      file.close(cb);  // close() is async, call cb after close completes.
	    });
	  }).on('error', function(err) { // Handle errors
	    fs.unlink(dest); // Delete the file async. (But we don't check the result)
	    if (cb) cb(err.message);
	  });
	},
	getFileType: function(str){
		return str.split('.').pop();
	},
	getPathStorage: function(){
		var date = new Date(); 
		var dayNumber = date.getDate();
		var monthNumber = date.getMonth();
		monthNumber = monthNumber+1;
		var yearNumber = date.getFullYear();
		var path = [params.storage, yearNumber, monthNumber, dayNumber];
		return path.join('/');
		if(fs.existsSync(path)){
			var readDir = fs.readdirSync(path);
		}
	}
}
module.exports=Utils;